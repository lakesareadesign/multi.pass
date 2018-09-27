<?php
namespace FLCacheClear;
class Pagely {

	static function run() {
		if ( class_exists( '\PagelyCachePurge' ) ) {
			\PagelyCachePurge::purgeAll();
		}
	}
}
