<?php

if (!class_exists('WDS_Check_Abstract')) require_once(dirname(__FILE__) . '/class_wds_check_abstract.php');

class WDS_Check_Metadesc_Keywords extends WDS_Check_Post_Abstract {

	private $_state;

	public function get_status_msg () {
		if (-1 === $this->_state) return __("We couldn't find a description to check for keywords", 'wds');
		return $this->_state === false
			? __('Description has no keywords', 'wds')
			: __('Meta description contains keywords', 'wds')
		;
	}

	public function apply () {
		$post = $this->get_subject();
		$subject = false;
		$resolver = false;

		if (!is_object($post) || empty($post->ID)) {
			$subject = $this->get_markup();
		} else {
			$resolver = WDS_Endpoint_Resolver::resolve();
			$resolver->simulate_post($post->ID);

			$subject = WDS_OnPage::get()->get_description();
		}
		if ($resolver) $resolver->stop_simulation();
		return !!$this->_state = $this->has_focus($subject);
	}

	public function apply_html () {
		$subjects = WDS_Html::find_attributes('meta[name="description"]', 'content', $this->get_markup());
		if (empty($subjects)) {
			$this->_state = -1;
			return false;
		}

		$subject = reset($subjects);
		if (empty($subject)) {
			$this->_state = -1;
			return false;
		}

		return !!$this->_state = $this->has_focus($subject);
	}

	function get_recommendation()
	{
		if ($this->_state) {
			$message = __("The focus keyword for this article appears in the SEO description which means it has a better chance of matching what your visitors will search for, brilliant!", 'wds');
		} else {
			$message = __("An SEO description without your focus keywords has less chance of matching what your visitors are searching for vs a description that does. It's worth trying to get your focus keywords in there, just remember to keep it readable and natural.", 'wds');
		}

		return $message;
	}

	function get_more_info()
	{
		return __("It's considered good practice to try to include your focus keyword(s) in the SEO description of your pages because this is what people looking for the article are likely searching for. The higher chance of a keyword match, the higher chance your article will be found higher up in search results. Remember this is your chance to give a potential visitor a quick peek into what's inside your article - if they like what they read they'll click on your link.", 'wds');
	}
}