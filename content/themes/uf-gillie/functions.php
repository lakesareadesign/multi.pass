<?php

include_once get_template_directory() . '/library/upfront_functions.php';
include_once get_template_directory() . '/library/class_upfront_debug.php';
include_once get_template_directory() . '/library/class_upfront_server.php';
include_once get_template_directory() . '/library/class_upfront_theme.php';

class Uf_gillie extends Upfront_ChildTheme {

	protected $_exports_images = true;

	public function initialize() {
		add_filter('upfront_augment_theme_layout', array($this, 'augment_layout'));
		$this->add_actions_filters();
		$this->populate_pages();
		add_filter("comment_form_field_author", array( $this, "comment_form_author" ));
        add_filter("comment_form_field_email", array( $this, "comment_form_email" ));
        add_filter("comment_form_fields", array( $this, "comment_form_args" ) );
	}

	public function get_prefix(){
		return 'uf-gillie';
	}

	public static function serve(){
		return new self();
	}

	public function populate_pages() {

	}

	protected function add_actions_filters() {
		// Include current theme style
		add_action('wp_head', array($this, 'enqueue_styles'), 200);
	}

	public function enqueue_styles() {
		wp_enqueue_style('current_theme', get_stylesheet_uri());
	}
    public function augment_layout ($layout) {
        if (empty($layout['regions'])) return $layout;
        $layout['regions'] = $this->augment_regions($layout['regions']);
        return $layout;
    }

    /**
     * Overrides default comment form args
     *
     * @since 1.0.0
     *
     * @param $args
     * @return mixed
     */

	public function comment_form_args( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['url'] );
		unset( $fields['comment'] );

		// Add placeholder dynamically to keep woocommerce stars
		$placeholder = __("Leave a comment...", "uf_gillie");
		$comment_field = str_replace('id="comment"', 'id="comment" placeholder="'. $placeholder .'"', $comment_field);
		$fields['comment'] = $comment_field;

		return $fields;
	}

    public function comment_form_author( $field ){
        $placeholder = __("Name", "uf_gillie");
        $field = <<<FIELD
        <p class="comment-form-author">
          <input id="author" name="author" placeholder="{$placeholder}" type="text" value="" size="30" aria-required='true' />
        </p>
FIELD;
        return $field;
    }

    public function comment_form_email( $field ){
        $placeholder = __("Email address", "uf_gillie");
        $field = <<<FIELD
        <p class="comment-form-email">
          <input id="email" name="email" placeholder="{$placeholder}" type="text" value="" size="30" aria-required='true' />
        </p>
FIELD;
        return $field;
    }

    public function comment_form_website( $field ){
        $placeholder = __("Website url", "uf_gillie");
        $field = <<<FIELD
        <p class="comment-form-website">
          <input id="url" name="url" placeholder="{$placeholder}" type="text" value="" size="30" aria-required='true' />
        </p>
FIELD;
        return $field;
    }

    public function augment_regions ($regions) {
        if (!empty($this->_slider_imported)) return $regions;

        if (empty($regions) || !is_array($regions)) return $regions;
        foreach ($regions as $idx => $region) {
            if (empty($region['properties']) || !is_array($region['properties'])) continue;
            foreach($region['properties'] as $pidx => $prop) {
                if (empty($prop['name']) || empty($prop['value']) || 'background_slider_images' !== $prop['name']) continue;
                foreach ($prop['value'] as $order_id => $attachment_src) {
                    if (is_numeric($attachment_src)) continue; // A hopefully existing image.
                    $regions[$idx]['properties'][$pidx]['value'][$order_id] = $this->_import_slider_image($attachment_src);
                }
            }
        }

        $this->_slider_imported = true;
        return $regions;
    }
}

Uf_gillie::serve();

if (file_exists(dirname(__FILE__) . '/compat/compat.php')) require_once(dirname(__FILE__) . '/compat/compat.php');