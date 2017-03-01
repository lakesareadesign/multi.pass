<?php

/**
 * Autolinks module contains code from SEO Smart Links plugin
 * (http://wordpress.org/extend/plugins/seo-automatic-links/ and http://www.prelovac.com/products/seo-smart-links/)
 * by Vladimir Prelovac (http://www.prelovac.com/).
 */

// you can override this in wp-config.php to enable blog-by-blog settings in multisite
if ( !defined( 'WDS_SITEWIDE' ) ) define( 'WDS_SITEWIDE', true );

// you can override this in wp-config.php to enable more posts in the sitemap, but you may need alot of memory
if ( ! defined( 'WDS_SITEMAP_POST_LIMIT' ) ) define( 'WDS_SITEMAP_POST_LIMIT', 1000 );

// you can override this in wp-config.php to enable more BuddyPress groups in the sitemap, but you may need alot of memory
if ( ! defined( 'WDS_BP_GROUPS_LIMIT' ) ) define( 'WDS_BP_GROUPS_LIMIT', 200 );

// you can override this in wp-config.php to enable more BuddyPress profiles in the sitemap, but you may need alot of memory
if ( ! defined( 'WDS_BP_PROFILES_LIMIT' ) ) define( 'WDS_BP_PROFILES_LIMIT', 200 );

// You can override this value in wp-config.php to allow more or less time for caching SEOmoz results
if ( ! defined( 'WDS_EXPIRE_TRANSIENT_TIMEOUT' ) ) define( 'WDS_EXPIRE_TRANSIENT_TIMEOUT', 3600);

// You can override this value in wp-config.php to allow for longer or shorter minimum autolink requirement
if ( ! defined( 'WDS_AUTOLINKS_DEFAULT_CHAR_LIMIT' ) ) define( 'WDS_AUTOLINKS_DEFAULT_CHAR_LIMIT', 3 );

// Suppress redundant canonicals?
if ( ! defined( 'WDS_SUPPRESS_REDUNDANT_CANONICAL' ) ) define( 'WDS_SUPPRESS_REDUNDANT_CANONICAL', false );

// Char counting defines
if ( ! defined( 'WDS_TITLE_LENGTH_CHAR_COUNT_LIMIT' ) ) define( 'WDS_TITLE_LENGTH_CHAR_COUNT_LIMIT', 65 );
if ( ! defined( 'WDS_METADESC_LENGTH_CHAR_COUNT_LIMIT' )) define( 'WDS_METADESC_LENGTH_CHAR_COUNT_LIMIT', 160 );

// Debugging defines.
if ( ! defined( 'WDS_SITEMAP_SKIP_IMAGES' ) ) define( 'WDS_SITEMAP_SKIP_IMAGES', false );
if ( ! defined( 'WDS_SITEMAP_SKIP_TAXONOMIES' ) ) define( 'WDS_SITEMAP_SKIP_TAXONOMIES', false );
if ( ! defined( 'WDS_SITEMAP_SKIP_SE_NOTIFICATION' ) ) define( 'WDS_SITEMAP_SKIP_SE_NOTIFICATION', false );
if ( ! defined( 'WDS_SITEMAP_SKIP_ADMIN_UPDATE' ) ) define( 'WDS_SITEMAP_SKIP_ADMIN_UPDATE', false );

if ( ! defined( 'WDS_EXPERIMENTAL_FEATURES_ON' ) ) define( 'WDS_EXPERIMENTAL_FEATURES_ON', false );
if ( ! defined( 'WDS_ENABLE_LOGGING' ) ) define( 'WDS_ENABLE_LOGGING', false );

/**
 * Setup plugin path and url.
 */
define( 'WDS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'WDS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) . 'includes/' );
define( 'WDS_PLUGIN_URL', plugin_dir_url( __FILE__ ) . 'includes/' );