<?php

class FarReaches_Twitter_Card {

    /**
     * Only allow a publisher to define a valid card type
     *
     * @var array
     */
    public static $allowed_card_types = array('summary', 'photo', 'player');

    /**
     * Only allow HTTP and HTTPs schemes in URLs
     *
     * @var array
     */
    private static $allowed_schemes = array('http', 'https');

    private $url;

    private $card_type;
    /**
     * Per twitter doc:
     * A description that concisely summarizes the content of the page, as appropriate for presentation within a Tweet.
     * Do not re-use the title text as the description, or use this field to describe the general services provided by the website.
     * Description text will be truncated at the word to 200 characters.
     * @var unknown_type
     */
    private $description;

    private $title;

    private $player;

    private $image;

    /**
     * Create a new Twitter Card object, optionally overriding the default card type of "summary"
     *
     * @since 1.0
     * @param string $card_type The card type. one of "summary", "photo", "player"
     */
    public function __construct($post, $url, $title, $description, $card_type = 'summary') {
        if (is_string($card_type) && in_array($card_type, self::$allowed_card_types, true)) {
            $this->card_type = $card_type;
        } else {
            $this->card_type = 'summary';
        }
        $this->set_url($url);
        $this->set_description($description);
        $this->set_title($title);
    }

    /**
     * Test an inputted Twitter username for validity
     *
     * @param string $username Twitter username
     * @return bool true if valid else false
     */
    private function is_valid_username($username) {
        return is_string($username) && !empty($username);
    }

    /**
     * Basic validity test to make sure a Twitter ID input looks like a Twitter numerical ID
     *
     * @since 1.0
     * @param string $id Twitter user ID string
     * @return bool true if the string contains only digits. else false
     */
    private function is_valid_id($id) {
        return is_int($id) || (is_string($id) && ctype_digit($id));
    }

    /**
     * Test if given URL is valid and matches allowed schemes
     *
     * @param string $url URL to test
     * @param array $allowed_schemes one or both of http, https (player card requires https)
     * @return bool true if URL can be parsed and scheme allowed, else false
     */
    private function is_valid_url($url, $allowed_schemes = null) {
        if (is_string($url) && !empty($url)) {
            if (!is_array($allowed_schemes) || empty($allowed_schemes)) {
                $schemes = self::$allowed_schemes;
            } else {
                $schemes = array();
                foreach ($allowed_schemes as $scheme) {
                    if (in_array($scheme, self::$allowed_schemes, true))
                        $schemes[] = $scheme;
                }

                if (empty($schemes))
                    $schemes = self::$allowed_schemes;
            }

            // parse_url will test scheme + full URL validity vs. just checking if string begins with "https://"
            try {
                $scheme = parse_url($url, PHP_URL_SCHEME);
                if (is_string($scheme) && in_array(strtolower($scheme), $schemes, true) && esc_url_raw($url, self::$allowed_schemes))
                    return true;
            } catch (Exception $e) {
            } // E_WARNING in PHP < 5.3.3
        }
        return false;
    }

    /**
     * Pass all URLs through esc_url_raw. Unset the property if URL rejected
     *
     * @since 1.0
     * @uses esc_url_raw()
     */
    private function filter_urls() {
        if (isset($this->url)) {
            $this->url = esc_url_raw($this->url);
            if (!$this->url)
                unset($this->url);
        }

        if (isset($this->image) && isset($this->image->url)) {
            $this->image->url = esc_url_raw($this->image->url);
            if (!$this->image->url)
                unset($this->image);
        }

        if (isset($this->player) && isset($this->player->url)) {
            $this->player->url = esc_url_raw($this->player->url);
            if ($this->player->url) {
                if (isset($this->player->stream) && isset($this->player->stream->url))
                    $this->player->stream->url = esc_url_raw($this->player->stream->url);
                if (!$this->player->stream->url)
                    unset($this->player->stream);
            } else {
                unset($this->player);
            }
        }
    }

    /**
     * Canonical URL. Basic check for string before setting
     *
     * @param string $url canonical URL
     */
    public function set_url($url) {
        if ($this->is_valid_url($url))
            $this->url = $url;
    }

    public function get_url() {
        return $this->url;
    }

    /**
     * Page title.
     * Will be truncated at 70 characters by Twitter but need not necessarily be 70 characters on the page.
     *
     * @param string $title page title
     */
    public function set_title($title) {
        $title = $this->trim_to_fit($title, 70);
        // photo cards may explicitly declare an empty title
        if ($this->card_type !== 'photo' || !empty($title)) {
            $this->title = $title;
        }
    }

    public function get_title() {
        return $this->title;
    }

    /**
     * A description of the content.
     * Descriptions over 200 characters in length will be truncated by Twitter
     * @param string $description description of page content
     */
    public function set_description($description) {
        $this->description = $this->trim_to_fit($description, 200);
    }

    public function get_description() {
        return $this->description;
    }

    private function trim_to_fit($text, $size) {
        if (is_string($text)) {
            $output = str_replace(array("\r\n", "\r", "\n"), ' ', $text);
            $output = trim($output);

            if (strlen($output) > $size) {
                // assume ~4 characters per word
                $output = trim(wp_trim_words($output, $size / 4, ''));
                // wp_trim_words may have failed if the string lacks whitespace
                $output = substr($output, 0, $size);
            }

            return $output;
        } else {
            return '';
        }
    }

    /**
     * URL of an image representing the post, with optional dimensions to help preserve aspect ratios on Twitter resizing
     * Minimum size of 280x150 for photo cards, 60x60 for summary types
     * For summary cards images larger than 120x120 will be resized and cropped
     *
     * For player card: (per Twitter doc):
     * Image to be displayed in place of the player on platforms that don't support iframes or inline players.
     * You should make this image the same dimensions as your player -
     * images with fewer than 68,600 pixels (a 262x262 square image, or a 350x196 16:9 image) will cause the player card not to render
     *
     * @param string $url URL of an image representing content
     * @param int $width width of the specified image in pixels
     * @param int $height height of the specified image in pixels
     */
    public function set_image($image_data) {
        list($url, $width, $height) = $image_data;
        if ($this->is_valid_url($url)) {
            $image = new stdClass();
            $image->url = $url;
            if (is_int($width) && is_int($height) && $width > 0 && $height > 0) {
                // minimum dimensions for all card types
                switch ($this->card_type) {
                    case 'summary':
                        if ($width < 60 || $height < 60) {
                            return false;
                        }
                        break;
                    case 'player':
                        // 262x262 or 350x196 (16:9)
                        if ($width * $height < 68600) {
                            return false;
                        }
                        break;
                    case 'photo':
                        if ($width < 280 || $height < 150) {
                            return false;
                        }
                        break;
                }
                $image->width = $width;
                $image->height = $height;
            }
            $this->image = $image;
            return true;
        } else {
            return false;
        }
    }

    /**
     * HTTPS URL of an HTML suitable for display in an iframe
     * Expected width and height of the iframe are required
     * If the iframe width is greater than 435 pixels Twitter will resize to fit a 435 pixel width column
     *
     * @param string $url HTTPS URL to iframe player
     * @param int $width width in pixels preferred by iframe URL
     * @param int $height height in pixels preferred by iframe URL
     * @param string $stream_url
     * Link to a direct MP4 file with H.264 Baseline Level 3 video and AAC LC audio tracks
     * Videos up to 640x480 pixels supported
     */
    public function set_video($url, $width, $height, $stream_url = null) {
        if ($this->is_valid_url($url, array('https')) && is_int($width) && is_int($height) && $width > 0 && $height > 0) {
            $video = new stdClass();
            $video->url = $url;
            $video->width = $width;
            $video->height = $height;
            if ($this->is_valid_url($stream_url)) {
                $stream = new stdClass();
                $stream->url = $stream_url;
                $stream->type = 'video/mp4; codecs=&quot;avc1.42E01E1, mpa.40.2&quot;';
                $video->stream = $stream;
            } else {
                return false;
            }
            $this->player = $video;
            return true;
        } else {
            return false;
        }
    }

    public function get_video() {
        return $this->player;
    }

    /**
     * Build a user object based on username and id inputs
     *
     * @param string $username Twitter username. no need to include the "@" prefix
     * @param string $id Twitter numerical ID
     * @return array associative array with username key and optional id key
     */
    private function filter_account_info($username, $id = '') {
        $user = null;
        if (is_string($username)) {
            $username = ltrim(trim($username), '@');
            if (!empty($username) && $this->is_valid_username($username)) {
                $user = new stdClass();
                $user->username = $username;
                if ($id && $this->is_valid_id($id)) {
                    $user->id = (string)$id;
                }
            }
        }
        return $user;
    }

    /**
     * Twitter account for the site: Twitter username and optional account ID
     * A user may change his username but his numeric ID will stay the same
     *
     * @param string $username Twitter username. no need to include the "@" prefix
     * @param string|int $id Twitter numerical ID. passed as a string to better handle large numbers
     */
    public function set_site_account($username, $id = '') {
        $user = $this->filter_account_info($username, $id);
        if ($user && isset($user->username))
            $this->site = $user;
    }

    /**
     * Content creator / author
     *
     * @param string $username Twitter username. no need to include the "@" prefix
     * @param string|int $id Twitter numerical ID. passed as a string to better handle large numbers
     */
    public function set_creator_account($username, $id = '') {
        $user = $this->filter_account_info($username, $id);
        if ($user && isset($user->username))
            $this->creator = $user;
    }

    /**
     * Check if all required properties have been set
     * Required properties vary by card type
     *
     * @return bool true if all required properties exist for the specified type, else false
     */
    public function required_properties_exist() {
        if (empty($this->url) || empty($this->description)) {
            return false;
        }
        if ($this->card_type !== 'photo' && empty($this->title)) {
            // only photo cards do not need a title.
            return false;
        }
        switch ($this->card_type) {
            case 'player' :
                if (empty($this->player) || empty($this->player->url) || empty($this->player->width) || empty($this->player->height)) {
                    return false;
                }
                if (empty($this->image) || empty($this->image->url)) {
                    return false;
                }
                // TODO: check to see that image dimensions == player dimensions : how much slack is allowed?
                break;
            case 'photo':
                if (empty($this->image) || empty($this->image->url)) {
                    return false;
                }
                break;
        }
        return true;
    }

    /**
     * Translate object properties into an associative array of Twitter property names as keys mapped to their value
     *
     * @return array associative array with Twitter card properties as a key with their respective values
     */
    private function toArray() {
        if (!$this->required_properties_exist())
            return array();

        // initialize with required properties
        $t = array(
            'card' => $this->card_type,
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description
        );

        // add an image
        if (isset($this->image) && isset($this->image->url)) {
            $t['image'] = $this->image->url;
            if (isset($this->image->width) && isset($this->image->height)) {
                $t['image:width'] = $this->image->width;
                $t['image:height'] = $this->image->height;
            }
        }

        // video on a photo card does not make much sense
        if ($this->card_type !== 'photo' && isset($this->player) && isset($this->player->url)) {
            $t['player'] = $this->player->url;
            if (isset($this->player->width) && isset($this->player->height)) {
                $t['player:width'] = $this->player->width;
                $t['player:height'] = $this->player->height;
            }

            // no video stream without a main video player. content type required.
            if (isset($this->player->stream) && isset($this->player->stream->url) && isset($this->player->stream->type)) {
                $t['player:stream'] = $this->player->stream->url;
                $t['player:stream:content_type'] = $this->player->stream->type;
            }
        }

        // identify the site
        if (isset($this->site) && isset($this->site->username)) {
            $t['site'] = '@' . $this->site->username;
            if (isset($this->site->id))
                $t['site:id'] = $this->site->id;
        }

        //
        if (isset($this->creator) && isset($this->creator->username)) {
            $t['creator'] = '@' . $this->creator->username;
            if (isset($this->creator->id))
                $t['creator:id'] = $this->creator->id;
        }

        return $t;
    }

    /**
     * Build a single <meta> element from a name and value
     *
     * @since 1.0
     * @param string $name name attribute value
     * @param string|int $value value attribute value
     * @param bool $xml include a trailing slash for XML. encode attributes for XHTML in PHP 5.4+
     * @return meta element or empty string if name or value not valid
     */
    private function build_meta_element($name, $value, $xml = false) {
        if (!(is_string($name) && $name && (is_string($value) || (is_int($value) && $value > 0))))
            return '';
        $flag = ENT_COMPAT;
        // allow PHP 5.4 overrides
        if ($xml === true && defined('ENT_XHTML'))
            $flag = ENT_XHTML;
        else if (defined('ENT_HTML5'))
            $flag = ENT_HTML5;
        return '<meta name="twitter:' . htmlspecialchars($name, $flag) . '" content="' . htmlspecialchars($value, $flag) . '"' . ($xml === true ? ' />' : '>');
    }

    /**
     * Build a string of <meta> elements representing the object
     * Pass URLs through esc_url_raw to preserve site preferences
     *
     * @since 1.0
     * @param string $style markup style. "xml" adds a trailing slash to the meta void element
     * @return string <meta> elements or empty string if minimum requirements not met
     */
    private function generate_markup($style = 'html') {
        $xml = $style === 'xml';
        $this->filter_urls();
        $t = $this->toArray();
        $s = '';
        if (is_array($t) && !empty($t)) {
            foreach ($t as $name => $value) {
                $s .= $this->build_meta_element($name, $value, $xml);
            }
        }
        return $s;
    }

    /**
     * Output object properties as HTML meta elements with name and value attributes
     *
     * @return string HTML <meta> elements or empty string if minimum requirements not met for card type
     */
    public function asHTML() {
        return $this->generate_markup();
    }

    /**
     * Output object properties as XML meta elements with name and value attributes
     *
     * @since 1.0
     * @return string XML <meta> elements or empty string if minimum requirements not met for card type
     */
    public function asXML() {
        return $this->generate_markup('xml');
    }
}

?>