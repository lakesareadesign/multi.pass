<?php
/**
 * @author: Hoang Ngo
 */
include_once dirname( __DIR__ ) . '/test-hardener.php';

class ProtectCoreDirTest extends Hardener_Test {
	/**
	 * case to test
	 * 1. Provide a blank htaccess => return false 3 check
	 * 2. Provide a htaccess with each rule => false 2 tothers
	 * 3. Provide a full htaccess + other rules from 3rd => true all
	 * 4. Provide a partial htacess with random one + other rules => false 2 (for each)
	 * 5. each case should have a fix, and compare to the result
	 *
	 */
	public function test_check_restrict_file_rule() {
		$test          = new WD_Protect_Core_Dir();
		$htaccess_path = wp_defender()->get_plugin_path() . 'tests/hardener/sample-htaccess/wp-content/';

		/**
		 * case 1:blank
		 */
		$content = file( $htaccess_path . 'case1' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		//fix for case 1
		$this->check_wp_content( $htaccess_path . 'case1' );
		/**
		 * case 2.1 we have one rule
		 */
		$content = file( $htaccess_path . 'case21' );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->check_wp_content( $htaccess_path . 'case21' );
		/**
		 * case 2.2 we have one rule
		 */
		$content = file( $htaccess_path . 'case22' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		$this->check_wp_content( $htaccess_path . 'case22' );
		/**
		 * case 2.3 we have one rule
		 */
		$content = file( $htaccess_path . 'case23' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->check_wp_content( $htaccess_path . 'case23' );

		/**
		 * case 3 we have a mixed file, with rules
		 */
		$content = file( $htaccess_path . 'case3' );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		/**
		 * case 4.1 we have one rule mixed
		 */
		$content = file( $htaccess_path . 'case41' );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->check_wp_content( $htaccess_path . 'case41' );
		/**
		 * case 4.2 we have one rule
		 */
		$content = file( $htaccess_path . 'case42' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		$this->check_wp_content( $htaccess_path . 'case42' );
		/**
		 * case 4.3 we have one rule
		 */
		$content = file( $htaccess_path . 'case43' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->check_wp_content( $htaccess_path . 'case43' );
	}

	/**
	 * case to test
	 * 1. Provide a blank htaccess => return false 4 check
	 * 2. Provide a htaccess with each rule => false 3 tothers
	 * 3. Provide a full htaccess + other rules from 3rd => true all
	 * 4. Provide a partial htacess with random one + other rules => false 4 (for each)
	 * 5. each case should have a fix, and compare to the result
	 *
	 */
	public function test_check_include_protection() {
		$test          = new WD_Protect_Core_Dir();
		$htaccess_path = wp_defender()->get_plugin_path() . 'tests/hardener/sample-htaccess/wp-include/';

		/**
		 * case 1:blank
		 */
		$content = file( $htaccess_path . 'case1' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) );
		$this->check_wp_include( $htaccess_path . 'case1' );

		/**
		 * case 2.1 we have one rule
		 */
		$content = file( $htaccess_path . 'case21' );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) );
		$this->check_wp_include( $htaccess_path . 'case21' );

		/**
		 * case 2.2 we have one rule
		 */
		$content = file( $htaccess_path . 'case22' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) );
		$this->check_wp_include( $htaccess_path . 'case22' );
		/**
		 * case 2.3 we have one rule
		 */
		$content = file( $htaccess_path . 'case23' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) );
		$this->check_wp_include( $htaccess_path . 'case23' );
		/**
		 * case 2.4 we have one rule
		 */
		$content = file( $htaccess_path . 'case24' );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) );
		$this->assertFalse( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) != false );
		$this->check_wp_include( $htaccess_path . 'case24' );
	}

	/**
	 * Copy the wrong htaccess to new file, and try to fix, then recheck
	 *
	 * @param $file_to_fix
	 *
	 */
	function check_wp_content( $file_to_fix ) {
		$test          = new WD_Protect_Core_Dir();
		$htaccess_path = wp_defender()->get_plugin_path() . 'tests/sample-htaccess/wp-content/';
		copy( $file_to_fix, $htaccess_path . 'htaccess' );

		$test->protect_content( $htaccess_path . 'htaccess' );
		$content = file( $htaccess_path . 'htaccess' );
		//recheck
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		unlink( $htaccess_path . 'htaccess' );
	}

	function check_wp_include( $file_to_fix ) {
		$test          = new WD_Protect_Core_Dir();
		$htaccess_path = wp_defender()->get_plugin_path() . 'tests/sample-htaccess/wp-content/';
		copy( $file_to_fix, $htaccess_path . 'htaccess' );

		$test->protect_include( $htaccess_path . 'htaccess' );
		$content = file( $htaccess_path . 'htaccess' );
		//recheck
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::BROWSER_LISTING ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PREVENT_PHP_ACCESS ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::PROTECT_HTACCESS ) != false );
		$this->assertTrue( $test->check_rule( $content, WD_Protect_Core_Dir::WPINCLUDE_EXCLUDE ) != false );
		unlink( $htaccess_path . 'htaccess' );
	}
}