<?php
/**
 * RecursiveCallbackFilterIterator PHP 5.3 compatible class
 *
 * @package     wp-aws
 * @copyright   Copyright (c) 2015, Delicious Brains
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 *              This class was taken from
 *              http://php.net/manual/en/class.recursivecallbackfilteriterator.php#110974
 */

if ( ! class_exists( 'RecursiveCallbackFilterIterator' ) ) {
	// Only load the class if doesn't exist, ie. < PHP 5.4
	class RecursiveCallbackFilterIterator extends RecursiveFilterIterator {

		protected $callback;

		public function __construct( RecursiveIterator $iterator, $callback ) {
			$this->callback = $callback;

			parent::__construct( $iterator );
		}

		public function accept() {
			$callback = $this->callback;

			return $callback( parent::current(), parent::key(), parent::getInnerIterator() );
		}

		public function getChildren() {
			return new self( $this->getInnerIterator()->getChildren(), $this->callback );
		}

	}
}