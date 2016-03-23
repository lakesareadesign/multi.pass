<?php
/**
 * Generate meta tags for a external service's use ( current use case is twitter cards )
 *
 * Not hooked up because we need a UI to explain how to do twitter permissioning.
 *
 * TODO:
 *    1. get twitter account to attach site account information.
 *    2. handle 'photo' cards.
 *    3. mechanism / ui to help walk user through twitter's permissioning.
 *
 * @author patmoore
 *
 */
class FarReaches_Post_Markup_Manager extends FarReaches_Base {
    function __construct(FarReaches_Util $farReaches_Util, FarReaches_Communication $farReaches_Communication) {
        parent::__construct($farReaches_Util, $farReaches_Communication);
    }

    // TODO : do we need to hook the 'wp' action to get the wp_head early enough?
    public function init() {
        if (is_single()) {
            $this->add_action('wp_head', 'handle_wp_head');
        }
    }

    public function handle_wp_head() {
        global $post;
        if (is_single()) {
            $this->markup($post);
        } else {
            // what can we do?
        }
    }

    /**
     * Build a Twitter Card object. Possibly output markup
     *
     * @since 1.0
     */
    public function markup($post) {
        $post_id = $this->get_id($post);
        $url = apply_filters('rel_canonical', get_permalink($post));
        $post_type = get_post_type($post_id);
        $title = post_type_supports($post_type, 'title') ? get_the_title($post) : null;
        $description = post_type_supports($post_type, 'excerpt') ? $this->make_description($post) : null;
        // does current post type and the current theme support post thumbnails?
        if (post_type_supports($post_type, 'thumbnail') && has_post_thumbnail($post_id)) {
            $thumbnail_image_data = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        }
        $card = new FarReaches_Twitter_Card($post, $title, $description, $thumbnail_image_data);

//         if ( apply_filters( 'twitter_cards_htmlxml', 'html' ) === 'xml' )
//             echo $card->asXML();
//         else
//             echo $card->asHTML();
    }

    /**
     * Create a description from post excerpt or content. Prep for Twitter display.
     * Twitter will truncate the description at 200 characters. We will not enforce this character count to allow for a maximum character change or other consuming agents.
     *
     * @param stdClass $post WordPress post object
     * @return string description string
     */
    public function make_description($post) {
        if (!isset($post))
            return '';

        $text = '';

        // allow plugins to modify, prepend, and append content in excerpt or main content
        if (!empty($post->post_excerpt)) {
            // the_content may be triggered when building an excerpt from nothing
            $filters = array('the_excerpt', 'the_content');
            foreach ($filters as $filter) {
                remove_filter($filter, 'wptexturize');
            }
            $text = trim(apply_filters('the_excerpt', $post->post_excerpt));
            foreach ($filters as $filter) {
                add_filter($filter, 'wptexturize');
            }
            unset($filters);
        } else if (isset($post->post_content)) {
            remove_filter('the_content', 'wptexturize');
            $text = trim(apply_filters('the_content', $post->post_content));
            add_filter('the_content', 'wptexturize');
        }

        if (empty($text))
            return '';

        // shortcodes should have been handled in the_content filter. if they are still present then strip
        $text = strip_shortcodes($text);

        $text = str_replace(']]>', ']]&gt;', $text);
        $text = wp_strip_all_tags($text);

        $excerpt_more = apply_filters('excerpt_more', '[...]');

        // prep for a pure string compare
        $excerpt_more = html_entity_decode($excerpt_more, ENT_QUOTES, 'UTF-8');
        $excerpt_more = trim($excerpt_more);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = trim($text);

        if ($excerpt_more) {
            $excerpt_more_length = strlen($excerpt_more);
            // test if text ends with excerpt more. if so, remove it
            if (strlen($text) > $excerpt_more_length && substr_compare($text, $excerpt_more, $excerpt_more_length * -1, $excerpt_more_length) === 0) {
                $text = trim(substr($text, 0, $excerpt_more_length * -1));
            }
        }

        return $text;
    }
}

?>