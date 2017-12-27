<?php

if (!class_exists('WDS_Check_Abstract')) require_once(dirname(__FILE__) . '/class_wds_check_abstract.php');

class WDS_Check_Slug_Keywords extends WDS_Check_Post_Abstract {

	private $_state;

	public function get_status_msg () {
		return $this->_state === false
			? __('Slug has no keywords', 'wds')
			: __('Slug contains keywords', 'wds')
		;
	}

	public function apply () {
		$text = $this->get_markup();
		$subject = join(' ', preg_split('/[-_]/', $text));
		return !!$this->_state = $this->has_focus($subject);
	}

	public function get_markup () {
		$subject = $this->get_subject();

		if (is_object($subject)) {
			if (!empty($subject->ID) && wp_is_post_revision($subject->ID)) {
				$post = get_post(wp_is_post_revision($subject->ID));
				$subject = '';
			} else {
				$post = $subject;
				$subject = '';
			}
			if (function_exists('get_sample_permalink')) {
				list($draft_tpl, $draft_name) = get_sample_permalink($post->ID);
			} else {
				$draft_tpl = ''; $draft_name = '';
			}
			$post_name = $post->post_name;
			$subject = !empty($post_name) ? $post_name : $draft_name;
		}

		return $subject;
	}

	public function get_recommendation()
	{
		if ($this->_state) {
			$message = __("You've got your focus keywords in the page slug which can contribute to your page rank as you have higher chance of matching search terms and Google does index your page slug, great stuff!", 'wds');
		} else {
			$message = __("Using your focus keywords in the page slug can contribute to your page rank as you have higher chance of matching search terms and Google does index your page slug. Try getting your focus keywords in there.", 'wds');
		}

		return $message;
	}

	public function get_more_info()
	{
		return __("The page URL you use for this post will be visible in search engine results, so it's important to also include words that the searcher is looking for - your focus keywords. It's debateable whether keywords in the slug are of any real search engine ranking benefit, one could assume that because the slug does get indexed that the algorithm may favour slugs more closely aligned with the topic being searched.", 'wds');
	}
}