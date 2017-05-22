# Aspire Theme


## Installation Instructions

1. Upload the Genesis Sample theme folder via FTP to your wp-content/themes/ directory. (The Genesis parent theme needs to be in the wp-content/themes/ directory as well.)
2. Go to your WordPress dashboard and select Appearance.
3. Activate the Aspire theme.
4. Inside your WordPress dashboard, go to Genesis > Theme Settings and configure them to your liking.  To set up the theme like the demo, please visit http://appfinite.com/tutorials-and-resources/


## Theme Support

Please visit http://appfinite.com/forums for theme support.





## CHANGELOG

= 1.2 =

functions.php
	* Added WooCommerce Gallery Options (Zoom, Lightbox, and Slider)
	* Updated/Fixed the code that displays the Featured Image on Single Pages (Now disabled by default) 
	* Updated WooCommerce Custom CSS link

Woocommerce.css - Improved the Overall Look and Feel for the WooCommerce Shop/Plugin.  Includes buttons, backgrounds, cart, checkout, etc.

style.css - Made improvements throughout the stylesheet 
	* Fixed the Frontpage background images to scale better on Desktop as well as Mobile Devices
	* Fixed issues with Front Page 1 background image.  Now shows properly on Desktop & Mobile
	* Fixed Jittery/Jumpy Movement when scrolling from the top of the page (Sticky Menu )
	* Links/buttons now show more consistent color/sizing throughout the theme
	* Slight adjustment to the Portfolio Titles, Buttons, and Images
	* Removed the 1800px Front Page Background Image Media Queries
	* Adjusted the Header display (Desktop & Mobile)
	
home.js 
	* Commented out the "Image Section height" which was causing the Front Page 1 Background image to zoom and stutter on scroll (mobile devices)
	
output.php
	* Added more background/link color options for the Customizer
	* Added a WooCommerce section so that WooCommerce buttons and background colors can also be controlled by the default theme color set in the Customizer.
	