<?php

/**
 * @author: Hoang Ngo
 */
class WD_Hardener_Widget extends WD_Controller {
	public function display() {
		//because we dont have any hook when wp or plugin/theme upgrade, so refresh here
		$hardener = WD_Hardener_Module::find_controller( 'hardener' );
		$modules  = $hardener->get_loaded_modules();
		if ( ! is_array( $modules ) ) {
			$modules = array();
		}
		$issues = array();
		foreach ( $modules as $rule ) {
			if ( $rule->is_ignored() == false && $rule->check() == false ) {
				$issues[] = $rule;
			}
		}

		$this->render( 'widgets/hardener', array(
			'modules' => $issues
		), true );
	}
}