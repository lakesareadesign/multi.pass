<?php

/**
 * @author: Hoang Ngo
 */
class WD_Scan_Widget extends WD_Controller {
	protected $template = 'layouts/scan_widget';

	public function display() {
		if ( WD_Utils::get_dev_api() == false ) {
			$this->template = false;
			$this->render( 'widgets/scan/scan-subscribe', array(), true );

			return;
		}

		$model = WD_Scan_Api::get_active_scan();
		if ( is_object( $model ) ) {
			$this->template = false;

			return $this->render( 'widgets/scan/scan_active', array(
				'model' => $model
			), true );
		}

		$model = WD_Scan_Api::get_last_scan();
		if ( is_object( $model ) ) {
			$res = array(
				'count'           => 0,
				'core_integrity'  => 0,
				'vulndb'          => 0,
				'file_suspicious' => 0
			);

			foreach ( $model->get_results() as $item ) {
				if ( $item instanceof WD_Scan_Result_Core_Item_Model ) {
					$res['core_integrity'] += 1;
				} elseif ( $item instanceof WD_Scan_Result_VulnDB_Item_Model ) {
					$res['vulndb'] += 1;
				} elseif ( $item instanceof WD_Scan_Result_File_Item_Model ) {
					$res['file_suspicious'] += 1;
				}
			}

			$res['count'] = $res['core_integrity'] + $res['vulndb'] + $res['file_suspicious'];

			return $this->render( 'widgets/scan/scan_result', array(
				'model' => $model,
				'res'   => $res
			), true );
		}
		$this->template = false;

		return $this->render( 'widgets/scan/no_scan', array(), true );
	}
}