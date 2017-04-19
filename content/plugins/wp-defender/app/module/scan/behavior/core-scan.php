<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Module\Scan\Behavior;

use Hammer\Base\Behavior;
use Hammer\Helper\File_Helper;
use Hammer\Helper\Log_Helper;
use WP_Defender\Module\Scan\Component\Scan_Api;
use WP_Defender\Module\Scan\Model\Result_Item;

class Core_Scan extends Behavior {
	public function processItemInternal( $args, $current ) {
		$model = $args['model'];

		$status = Result_Item::STATUS_ISSUE;
		if ( ( $oid = Scan_Api::isIgnored( $current ) ) !== false ) {
			//if this is ignored, we just need to update the parent ID
			$item           = Result_Item::findByID( $oid );
			$item->parentId = $model->id;
			$item->save();

			return true;
		}

		$checksums = Scan_Api::getCoreChecksums();

		if ( ! is_array( $checksums ) ) {

		} else {
			$item           = new Result_Item();
			$item->parentId = $model->id;
			$item->type     = 'core';
			$item->status   = $status;
			if ( is_file( $current ) ) {
				//check if this is core or not
				$relPath = Scan_Api::convertToUnixPath( $current );
				if ( isset( $checksums[ $relPath ] ) && strcmp( md5_file( $current ), $checksums[ $relPath ] ) !== 0 ) {
					$item->raw = array(
						'type' => 'modified',
						'file' => $current
					);
					$id        = $item->save();
				} elseif ( ! isset( $checksums[ $relPath ] ) ) {
					$item->raw = array(
						'type' => 'unknown',
						'file' => $current
					);
					$id        = $item->save();
				}
			} elseif ( is_dir( $current ) ) {
				//check if this empty then do nothing
				$files = File_Helper::findFiles( $current, true, false );
				if ( count( $files ) ) {
					$item->raw = array(
						'type' => 'dir',
						'file' => $current
					);
					$id        = $item->save();
				}
			} else {
				//this is not exist anymore, just move on
				return null;
			}
		}

		return true;
	}
}