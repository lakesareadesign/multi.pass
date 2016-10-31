<?php

/**
 * Author: Hoang Ngo
 */
class Test_Change_Admin extends WP_UnitTestCase {
	private $component;

	public function __construct() {
		$this->component = new WD_Change_Default_Admin();
	}

	public function testMain() {
		if ( username_exists( 'admin' ) ) {
			//should return false, as we still have admin
			$this->assertFalse( $this->component->check() );
			//create new user
			$user_id = $this->factory->user->create();
			$user    = get_user_by( 'id', $user_id );
			//test validate
			$new_username = '  !#dasd5123';
			$this->assertTrue( (boolean) is_wp_error( $this->component->validate( $new_username ) ) );
			$new_username = '';
			$this->assertTrue( (boolean) is_wp_error( $this->component->validate( $new_username ) ) );
			$new_username = 'admin';
			$this->assertTrue( (boolean) is_wp_error( $this->component->validate( $new_username ) ) );
			$new_username = $user->user_login;
			$this->assertTrue( (boolean) is_wp_error( $this->component->validate( $new_username ) ) );
			//change it
			$this->component->change_username( 'hoang' );
			//admin should not exist anymore
			$this->assertFalse( (boolean) username_exists( 'admin' ) );
			//check if our new user work
			$this->assertTrue( (boolean) username_exists( 'hoang' ) );
		}
	}
}