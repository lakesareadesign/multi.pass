<?php

class Smartcrawl_Seomoz_Dashboard_Widget_Renderer extends Smartcrawl_Renderable {

	public function render() {
		$smartcrawl_options = Smartcrawl_Settings::get_options();

		if ( empty( $smartcrawl_options['access-id'] ) || empty( $smartcrawl_options['secret-key'] ) ) {
			$this->_render( 'notice', array(
				'class'   => 'wds-notice-error',
				'message' => esc_html__( 'Moz credentials not properly set up.', 'wds' ),
			) );

			return;
		}

		$target_url = preg_replace( '!http(s)?:\/\/!', '', get_bloginfo( 'url' ) );
		$seomozapi = new SEOMozAPI( $smartcrawl_options['access-id'], $smartcrawl_options['secret-key'] );
		$urlmetrics = $seomozapi->urlmetrics( $target_url );

		$attribution = str_replace( '/', '%252F', untrailingslashit( $target_url ) );
		$attribution = "https://moz.com/researchtools/ose/links?site={$attribution}";

		if ( is_object( $urlmetrics ) && $seomozapi->is_response_valid( $urlmetrics ) ) {
			$this->_render( 'seomoz-dashboard-widget', array(
				'attribution' => $attribution,
				'urlmetrics'  => $urlmetrics,
			) );
		} else {
			$error = isset( $urlmetrics->error_message ) ? $urlmetrics->error_message : '';
			$message = sprintf(
				"%s<br/><span class='wds-small-text'>%s</span>",
				esc_html__( 'Unable to retrieve data from the Moz API.', 'wds' ),
				$error
			);

			$this->_render( 'notice', array(
				'class'   => 'wds-notice-error',
				'message' => $message,
			) );
		}
	}

	protected function _get_view_defaults() {
		return array();
	}
}