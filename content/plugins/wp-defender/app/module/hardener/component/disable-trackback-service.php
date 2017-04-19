<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Hardener\Component;

use Hammer\Base\Container;
use Hammer\Helper\WP_Helper;
use WP_Defender\Module\Hardener\IRule_Service;
use WP_Defender\Module\Hardener\Rule_Service;

class Disable_Trackback_Service extends Rule_Service implements IRule_Service {
	const CACHE_KEY = 'disable_trackback';

	/**
	 * @return bool
	 */
	public function process() {
		//first need to cache the status
		$cache = WP_Helper::getCache();
		$cache->set( self::CACHE_KEY, 1, 0 );

		return true;
	}

	/**
	 * @return bool
	 */
	public function revert() {
		$cache = Container::instance()->get( 'cache' );
		$cache->delete( self::CACHE_KEY );

		return true;
	}

	/**
	 * @return mixed
	 */
	public function check() {
		$cache = WP_Helper::getCache();

		return $cache->exists( self::CACHE_KEY );
	}
}