<?php

class WP_Hummingbird_Module_GZip extends WP_Hummingbird_Module_Server {

	protected $transient_slug = 'gzip';

	public function analize_data() {
		$files = array(
			'text/html' => add_query_arg( 'avoid-minify', 'true', get_home_url() ),
			'text/javascript' => wphb_plugin_url() . 'core/modules/dummy/dummy-js.js',
			'text/css' => wphb_plugin_url() . 'core/modules/dummy/dummy-style.css',
		);

		$results = array();
		foreach ( $files as $type  => $file ) {

			// We don't use wp_remote, getting the content-encoding is not working
			if ( ! class_exists('SimplePie') )
				require_once( ABSPATH . WPINC . '/class-simplepie.php' );

			$result = new SimplePie_File( $file, 10, 5, null, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.109 Safari/537.36' );
			$headers = $result->headers;
			if ( empty( $headers ) ) {
				$results[ $type ] = false;
			}
			elseif ( isset( $headers['content-encoding'] ) && $headers['content-encoding'] == 'gzip' ) {
				$results[ $type ] = true;
			}
			else {
				$results[ $type ] = false;
			}


		}

		return $results;
	}

	public function get_nginx_code() {
		return '
# Enable Gzip compression
gzip          on;

# Compression level (1-9)
gzip_comp_level     5;

# Don\'t compress anything under 256 bytes
gzip_min_length     256;

# Compress output of these MIME-types
gzip_types
    application/atom+xml
    application/javascript
    application/json
    application/rss+xml
    application/vnd.ms-fontobject
    application/x-font-ttf
    application/x-javascript
    application/x-web-app-manifest+json
    application/xhtml+xml
    application/xml
    font/opentype
    image/svg+xml
    image/x-icon
    text/css
    text/plain
    text/javascript
    text/x-component;

# Disable gzip for bad browsers
gzip_disable  "MSIE [1-6]\.(?!.*SV1)";';
	}

	public function get_apache_code() {
		return '
<IfModule mod_deflate.c>
    # Compress HTML, CSS, JavaScript, Text, XML and fonts
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/vnd.ms-fontobject
    AddOutputFilterByType DEFLATE application/x-font
    AddOutputFilterByType DEFLATE application/x-font-opentype
    AddOutputFilterByType DEFLATE application/x-font-otf
    AddOutputFilterByType DEFLATE application/x-font-truetype
    AddOutputFilterByType DEFLATE application/x-font-ttf
    AddOutputFilterByType DEFLATE application/x-javascript
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE font/opentype
    AddOutputFilterByType DEFLATE font/otf
    AddOutputFilterByType DEFLATE font/ttf
    AddOutputFilterByType DEFLATE image/svg+xml
    AddOutputFilterByType DEFLATE image/x-icon
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/javascript
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/xml

    # Remove browser bugs (only needed for really old browsers)
    BrowserMatch ^Mozilla/4 gzip-only-text/html
    BrowserMatch ^Mozilla/4\.0[678] no-gzip
    BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
    Header append Vary User-Agent
</IfModule>';
	}

	public function get_iis_code() {
		return '';
	}

	public function get_iis_7_code() {
		return '';
	}

}