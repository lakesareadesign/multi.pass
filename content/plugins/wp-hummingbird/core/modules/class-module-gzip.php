<?php

class WP_Hummingbird_Module_GZip extends WP_Hummingbird_Module_Server {

	protected $transient_slug = 'gzip';

	public function analize_data() {
		$files = array(
			'HTML' => add_query_arg( 'avoid-minify', 'true', get_home_url() ),
			'JavaScript' => wphb_plugin_url() . 'core/modules/dummy/dummy-js.js',
			'CSS' => wphb_plugin_url() . 'core/modules/dummy/dummy-style.css',
		);

		$results = array();
		foreach ( $files as $type  => $file ) {

			// We don't use wp_remote, getting the content-encoding is not working
			if ( ! class_exists('SimplePie') )
				require_once( ABSPATH . WPINC . '/class-simplepie.php' );

			$result = new SimplePie_File( $file, 10, 5, null, $_SERVER['HTTP_USER_AGENT'] );

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
    <IfModule mod_setenvif.c>
        <IfModule mod_headers.c>
            SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ ^((gzip|deflate)\s*,?\s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
            RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding
        </IfModule>
    </IfModule>
    <IfModule mod_filter.c>
        AddOutputFilterByType DEFLATE "application/atom+xml" \
                                      "application/javascript" \
                                      "application/json" \
                                      "application/ld+json" \
                                      "application/manifest+json" \
                                      "application/rdf+xml" \
                                      "application/rss+xml" \
                                      "application/schema+json" \
                                      "application/vnd.geo+json" \
                                      "application/vnd.ms-fontobject" \
                                      "application/x-font-ttf" \
                                      "application/x-javascript" \
                                      "application/x-web-app-manifest+json" \
                                      "application/xhtml+xml" \
                                      "application/xml" \
                                      "font/eot" \
                                      "font/opentype" \
                                      "image/bmp" \
                                      "image/svg+xml" \
                                      "image/vnd.microsoft.icon" \
                                      "image/x-icon" \
                                      "text/cache-manifest" \
                                      "text/css" \
                                      "text/html" \
                                      "text/javascript" \
                                      "text/plain" \
                                      "text/vcard" \
                                      "text/vnd.rim.location.xloc" \
                                      "text/vtt" \
                                      "text/x-component" \
                                      "text/x-cross-domain-policy" \
                                      "text/xml"

    </IfModule>
    <IfModule mod_mime.c>
        AddEncoding gzip              svgz
    </IfModule>

</IfModule>';
	}

	public function get_litespeed_code() {
		return $this->get_apache_code();
	}

	public function get_iis_code() {
		return '';
	}

	public function get_iis_7_code() {
		return '';
	}

}