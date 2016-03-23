<?php

class WP_Hummingbird_Model {

	private static $instance = null;

	public static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new self();

		return self::$instance;
	}

	public function __construct() {
		global $wpdb;

		$wpdb->wphb_chart = $wpdb->prefix . 'minification_chart';

		// Get the correct character collate
		if ( ! empty($wpdb->charset) )
			$this->db_charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$this->db_charset_collate .= " COLLATE $wpdb->collate";
	}

	public function create_minification_chart_table() {
		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE $wpdb->wphb_chart (
				ID bigint(20) unsigned NOT NULL auto_increment,
				data_hash varchar(60) NOT NULL DEFAULT '',
				group_hash varchar(60) NOT NULL DEFAULT '',
				url varchar(255) NOT NULL DEFAULT '',
				src varchar(255) NOT NULL DEFAULT '',
  				position varchar(100) NOT NULL default '',
  				type varchar(20) NOT NULL DEFAULT '',
				PRIMARY KEY  (ID),
				UNIQUE KEY data_hash (data_hash),
				KEY data_url (url)
			      ) $this->db_charset_collate;";

		dbDelta($sql);
	}


	public function insert_chart_src( $hash, $url, $src, $position, $type) {
		global $wpdb;

		$data_hash = md5( $hash . $url . $src );

		$query = $wpdb->prepare(
			"INSERT IGNORE INTO {$wpdb->wphb_chart}
			(group_hash, data_hash, url, src, position, type)
			VALUES
			(%s, %s, %s, %s, %s, %s);",
			$hash, $data_hash, $url, $src, $position, $type
		);

		$wpdb->query( $query );
	}

	public function delete_chart_group( $hash_or_id ) {
		global $wpdb;

		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM $wpdb->wphb_chart WHERE ( group_hash = %s OR ID = %d );",
				$hash_or_id,
				$hash_or_id
			)
		);
	}


	public function delete_chart() {
		global $wpdb;

		$wpdb->query( "DELETE FROM $wpdb->wphb_chart" );
	}

	public function get_chart_data( $url ) {
		global $wpdb;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $wpdb->wphb_chart WHERE url = %s",
				$url
			),
			ARRAY_A
		);

		return $results;
	}

	/**
	 * Get chart data for a given group Hash
	 *
	 * @param string $group_hash
	 *
	 * @return array
	 */
	public function get_chart_group_data( $group_hash ) {
		global $wpdb;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $wpdb->wphb_chart WHERE group_hash = %s OR ID = %d",
				$group_hash,
				$group_hash
			)
		);

		return $results;
	}

	/**
	 * Get all chart URLs
	 *
	 * @return array
	 */
	public function get_chart_urls() {
		global $wpdb;

		$results = $wpdb->get_col(
			"SELECT DISTINCT(url) FROM $wpdb->wphb_chart"
		);

		return $results;
	}



}