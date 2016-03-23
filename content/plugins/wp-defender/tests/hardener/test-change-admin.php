<?php
include_once dirname( __DIR__ ) . '/test-hardener.php';

/**
 * @author: Hoang Ngo
 */
class ChangeAdminTest extends Hardener_Test {
	function test_change_admin() {
		///this only work once after test init
		if ( get_user_by( 'id', 1 ) ) {
			$test = new WD_Change_Default_Admin();
			$this->assertFalse( $test->check() );
			//create some contents belong to the user = 1
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );
			$this->factory->post->create( array( 'post_author' => 1 ) );

			//comments
			$this->factory->comment->create( array( 'user_id' => 1 ) );
			$this->factory->comment->create( array( 'user_id' => 1 ) );
			$this->factory->comment->create( array( 'user_id' => 1 ) );
			$this->factory->comment->create( array( 'user_id' => 1 ) );
			//user meta
			update_user_meta( 1, 'meta1', 1 );
			update_user_meta( 1, 'meta2', 2 );
			update_user_meta( 1, 'meta3', 3 );
			update_user_meta( 1, 'meta4', 4 );
			//links
			/*$this->factory->link->create( array( 'post_author' => 1 ) );
			$this->factory->link->create( array( 'post_author' => 1 ) );
			$this->factory->link->create( array( 'post_author' => 1 ) );
			$this->factory->link->create( array( 'post_author' => 1 ) );*/
			$new_user_id = $test->change_username( 'master' );
			wp_cache_flush();

			$post_old = get_posts( array(
				'author' => 1
			) );
			$this->assertEquals( 0, count( $post_old ) );

			$post_new = get_posts( array(
				'author' => 2
			) );
			$this->assertEquals( 4, count( $post_new ) );
			//usermeta
			$this->assertTrue( empty( get_user_meta( 1, 'meta1', true ) ) );
			$this->assertTrue( empty( get_user_meta( 1, 'meta2', true ) ) );
			$this->assertTrue( empty( get_user_meta( 1, 'meta3', true ) ) );
			$this->assertTrue( empty( get_user_meta( 1, 'meta4', true ) ) );

			$this->assertEquals( 1, get_user_meta( $new_user_id, 'meta1', true ) );
			$this->assertEquals( 2, get_user_meta( $new_user_id, 'meta2', true ) );
			$this->assertEquals( 3, get_user_meta( $new_user_id, 'meta3', true ) );
			$this->assertEquals( 4, get_user_meta( $new_user_id, 'meta4', true ) );

			$old_comments = get_comments( array(
				'author__in' => array( 1 )
			) );
			$this->assertEquals( 0, count( $old_comments ) );

			$new_comments = get_comments( array(
				'author__in' => array( $new_user_id )
			) );

			$this->assertEquals( 4, count( $new_comments ) );

			//post content was fine, now check with the comments
			$this->assertTrue( $test->check() );
		}
	}
}