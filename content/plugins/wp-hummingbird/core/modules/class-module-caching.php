<?php

class WP_Hummingbird_Module_Caching extends WP_Hummingbird_Module_Server {

	protected $transient_slug = 'caching';

	public function analize_data() {

		$files = array(
			'javascript' => wphb_plugin_url() . 'core/modules/dummy/dummy-js.js',
			'css' => wphb_plugin_url() . 'core/modules/dummy/dummy-style.css',
			'media' => wphb_plugin_url() . 'core/modules/dummy/dummy-media.mp3',
			'images' => wphb_plugin_url() . 'core/modules/dummy/dummy-image.png',
		);

		$results = array();
		foreach ( $files as $type  => $file ) {

			$result = wp_remote_head( $file );
			if ( is_wp_error( $result ) ) {
				$headers = array();
			} else {
				$headers = $result['headers'];
			}

			$results[ $type ] = false;
			if ( isset( $headers['cache-control'] )
				&& preg_match( '/max\-age=([0-9]*)/', $headers['cache-control'], $matches )
			) {
				if ( isset( $matches[1] ) ) {
					$seconds = absint( $matches[1] );
					$results[ $type ] = $seconds;
				}
			}
		}

		return $results;
	}

	public static function apache_modules_loaded() {
		$sapi_name = '';
		$apache_modules = array();
		if ( function_exists( 'php_sapi_name' ) ) {
			$sapi_name = php_sapi_name();
		}

		if ( function_exists( 'php_sapi_name' ) ) {
			$apache_modules = apache_get_modules();
		}

		return in_array( 'mod_expires', $apache_modules );

	}

	public function get_nginx_code() {
		$options = wphb_get_settings();

		$assets_expiration = explode( '/', $options['caching_expiry_javascript'] );
		$assets_expiration = $assets_expiration[0];
		$css_expiration = explode( '/', $options['caching_expiry_css'] );
		$css_expiration = $css_expiration[0];
		$media_expiration = explode( '/', $options['caching_expiry_media'] );
		$media_expiration  = $media_expiration [0];
		$images_expiration = explode( '/', $options['caching_expiry_images'] );
		$images_expiration = $images_expiration[0];

		$code = '
location ~* \.(txt|xml|js)$ {
    expires %%ASSETS%%;
}

location ~* \.(css)$ {
    expires %%ASSETS%%;
}

location ~* \.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav|mp4|m4v|ogg|webm|aac)$ {
    expires %%MEDIA%%;
}

location ~* \.(jpg|jpeg|png|gif|swf|webp)$ {
    expires %%IMAGES%%;
}';

		$code = str_replace( '%%MEDIA%%', $media_expiration, $code );
		$code = str_replace( '%%IMAGES%%', $images_expiration, $code );
		$code = str_replace( '%%ASSETS%%', $assets_expiration, $code );
		$code = str_replace( '%%CSS%%', $css_expiration, $code );

		return $code;
	}

	public function get_apache_code() {

		$options = wphb_get_settings();

		$assets_expiration = explode( '/', $options['caching_expiry_javascript'] );
		$assets_expiration = $assets_expiration[1];
		$css_expiration = explode( '/', $options['caching_expiry_css'] );
		$css_expiration = $css_expiration[1];
		$media_expiration = explode( '/', $options['caching_expiry_media'] );
		$media_expiration  = $media_expiration [1];
		$images_expiration = explode( '/', $options['caching_expiry_images'] );
		$images_expiration = $images_expiration[1];

		$code = '
<IfModule mod_expires.c>
ExpiresActive On
ExpiresDefault A0

<FilesMatch "\.(txt|xml|js)$">
ExpiresDefault %%ASSETS%%
</FilesMatch>

<FilesMatch "\.(css)$">
ExpiresDefault %%CSS%%
</FilesMatch>

<FilesMatch "\.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav|mp4|m4v|ogg|webm|aac)$">
ExpiresDefault %%MEDIA%%
</FilesMatch>

<FilesMatch "\.(jpg|jpeg|png|gif|swf|webp)$">
ExpiresDefault %%IMAGES%%
</FilesMatch>
</IfModule>

<IfModule !mod_expires.c>
 <IfModule mod_headers.c>

  <FilesMatch "\.(txt|xml|js)$">
   Header set Cache-Control "max-age=%%ASSETS_HEAD%%"
  </FilesMatch>

  <FilesMatch "\.(css)$">
   Header set Cache-Control "max-age=%%CSS_HEAD%%"
  </FilesMatch>

  <FilesMatch "\.(flv|ico|pdf|avi|mov|ppt|doc|mp3|wmv|wav|mp4|m4v|ogg|webm|aac)$">
   Header set Cache-Control "max-age=%%MEDIA_HEAD%%"
  </FilesMatch>

  <FilesMatch "\.(jpg|jpeg|png|gif|swf|webp)$">
   Header set Cache-Control "max-age=%%IMAGES_HEAD%%"
  </FilesMatch>
 </IfModule>
</IfModule>';

		$code = str_replace( '%%MEDIA%%', $media_expiration, $code );
		$code = str_replace( '%%IMAGES%%', $images_expiration, $code );
		$code = str_replace( '%%ASSETS%%', $assets_expiration, $code );
		$code = str_replace( '%%CSS%%', $css_expiration, $code );

		$code = str_replace( '%%MEDIA_HEAD%%', ltrim( $media_expiration, 'A' ), $code );
		$code = str_replace( '%%IMAGES_HEAD%%', ltrim( $images_expiration, 'A' ), $code );
		$code = str_replace( '%%ASSETS_HEAD%%', ltrim( $assets_expiration, 'A' ), $code );
		$code = str_replace( '%%CSS_HEAD%%', ltrim( $css_expiration, 'A' ), $code );

		return $code;
	}

	public function get_iis_code() {
		return '';
	}

	public function get_iis_7_code() {
		return '';
	}

}