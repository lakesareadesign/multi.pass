<?php

/**
 * WP Cli commands for theme.
 */
class FLTheme_WPCLI_Command extends WP_CLI_Command {

	/**
	 * Deletes compiled css for Beaver Theme.
	 *
	 * ## EXAMPLES
	 *
	 * 1. wp beaver theme clearcache
	 * 		- Clears and rebuilds the Beaver Theme CSS.
	*/
	public function clearcache( $args, $assoc_args ) {
		FLCustomizer::refresh_css();
		WP_CLI::success( 'Rebuilt the theme cache' );
	}
}

WP_CLI::add_command( 'beaver theme', 'FLTheme_WPCLI_Command' );
