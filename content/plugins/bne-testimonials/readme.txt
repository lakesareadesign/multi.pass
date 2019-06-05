=== BNE Testimonials ===
Author URI: http://www.bnecreative.com
Contributors: bluenotes
Tags: testimonials, testimonial widget, random testimonials, flexslider, feedback, reviews
Requires at least: 4.7
Tested up to: 5.2.1
Stable tag: 2.0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Display testimonials and reviews on any page or widget area as list or slider. Upgrade to PRO for additional layouts, themes, submission form, API, ratings and schema.org markup.


== Description ==

BNE Testimonials makes it easy to add Testimonials and Reviews to any Page using a shortcode or in a sidebar (widget area) using the provided widgets. Each testimonial includes a title, image, tagline, website URL, and message. You can also separate your testimonials into different groups (categories). BNE Testimonials will inherit the styling from your theme - just install and get to work adding your testimonials and reviews!

= Display your testimonials as a List: =
Shortcode: [bne_testimonials layout="list"]
Testimonials will be shown vertically as a traditional list.

= Display your testimonials as a Slider =
Shortcode: [bne_testimonials layout="slider"]
Testimonials will be shown in a rotating slider. To remove the styling of the slider, include theme="simple" as a shortcode option.


= Pro Features Include =
We have a PRO version of BNE Testimonials on our [website](http://www.bnecreative.com/products/testimonials-wordpress-pro/ "BNE Testimonials PRO"). Features include:

* API Access: Display testimonials on multiple WordPress websites from a single source.
* Yelp, Google Places, and Facebook Reviews: Use their API to bring in reviews and display them on your website using any of the layouts
* Aggregated Review Badges for Yelp, Google, Facebook, and Custom branding. Automatically calculates your rating and total testimonials published. 
* Additional Layouts: Masonry Grid and Thumbnail Slider
* Additional Themes: Bubble and Cards
* Shortcode Generator
* Custom styling
* 5 Star Ratings
* Truncated (shorten) text
* Schema.org tags and meta for online search
* Front-end submission form with email notification
* Pagination for list and masonry layouts
* Automatic updates to new versions
* Numerous filters/hooks for developers
* Priority support

[View the PRO Demo](http://demo.bnecreative.com/testimonial-pro/ "BNE Testimonials PRO Demo")

= Why Do I Need Testimonials on my Website? =
Testimonials are a great way to strengthen your brand and reliability with new customers.

* Testimonials help potential customers get to know that you are a trustworthy business.
* Testimonials give you the opportunity to point out specific features or compelling reasons why a customer should buy from you.
* Testimonials, when used effectively, are a great tool to increase conversions rates on your website!
	


== Installation ==

1. Upload the "bne-testimonials" folder to the "/wp-content/plugins/" directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. A new menu item will be added called "Testimonials."
4. Add "[bne_testimonials]" to a post/page or use the available widgets in a sidebar.



== Frequently Asked Questions ==


= What options are there for the shortcodes? =
You can view all available options to add to the shortcode that changes the default behavior by viewing the help page in the Testimonials Admin menu.

= Is there support? =
Of course, but it is limited for the free version. We do not provide customizations or modifications beyond what the plugin currently provides. If you find any bugs or cannot get our plugin to work, please let us know so that we can look into it. Code is never perfect but it is poetry and there is always room for improvement.

= Can you add feature X and Y? =
Possible, but most likely not in the free version. If you would like to see new features added, check out the [pro version](http://www.bnecreative.com/products/testimonials-wordpress-pro/ "PRO version of BNE Testimonials") first. Perhaps your wanted feature is already there.


== Screenshots ==

1. Testimonial Post List Admin Screen
2. Testimonial Post Edit Admin Screen
3. Testimonial Slider Layout
4. Testimonial List Layout
5. Testimonial Image Styles




== Changelog ==

= 2.0.4 May 25, 2019 =
* Update CMB2 Library to v2.6.0
* Fix Widgets not displaying the widget title.
* Fix "1" showing when image is set to false while using the testimonial widgets.


= 2.0.3 November 6, 2018 =
* Notice!! v1.x Legacy Shortcodes and Widgets (migration step 2 of 3). [bne_testimonials_list] and [bne_testimonials_slider] were depreciated back on June 16, 2017, and will now output their newer default versions [bne_testimonials layout="list"] and [bne_testimonials layout="slider"]. If not already, please update these to the newer versions. The frontend notice displays for admins only.
* Fix: Setting name="false" would output a "1".


= 2.0.2 August 6, 2018 =
* Notice!! v1.x Legacy shortcodes which are [bne_testimonials_list] and [bne_testimonials_slider] were depreciated back on June 16, 2017 and will soon output their newer default versions. If you have not already, please update these to their newer variants as they will be completely removed in a future update.
* Code cleanup and optimization.

= 2.0.1 July 15, 2018 =
* Update CMB2 Library to v2.4.2
* Compatibility with PHP v7.2
* Fix: Legacy widget slider to enqueue inline JS in the footer after flexslider.js.


= 2.0 June 16, 2017 =
* Complete re-write matching the code base and structure of the pro version.
* Added information about new featured included in the pro version on the admin help page.
* [bne_testimonials_list] and [bne_testimonials_slider] shortcodes are now depreciated but will still work. Use the new unified shortcode going forward, [bne_testimonials]


= 1.7.5 September 5, 2016 =
* Fix: Featured Thumbnail metabox description was being thrown on other post types.


= 1.7.4 August 10, 2016 =
* Fix: depreciated notice for the list and slider widgets and PHP 7.



= 1.7.3 ( December 14, 2015 ) =
* House keeping
* Update admin help page with new information about the PRO version.


= 1.7.2 ( August 19, 2015 ) =
* Fix: Compatibility with WordPress 4.3 and the now depreciated PHP 4 style constructor.


= 1.7.1.1 ( April 23, 2015 ) =
* Security: Add additional sanitization checks on output. This is just a precaution due to recent events with other plugins/themes regarding the XSS vulnerability.


= 1.7.1 ( March 7, 2015 ) =
* Fix: flexslider.js with mobile firefox
* Tweak: Cleaned up help admin page.
* Note: Update branding from Bluenotes Entertainment to BNE Creative ( Why? http://www.bnecreative.com/blog/introducing-bne-creative/ )



= 1.7.0 ( February 7, 2015 ) =
* IMPORTANT CHANGE #1: The flexslider html div is now called bne-flexslider. This was done to prevent theme's or other plugins who also use flexslider to not throw their css onto our instance of flexslider and vice versa. Note because of this, any custom CSS edits you may have done to specifically ".bne-testimonial-slider.flexslider {...}" will need to be adjusted to match the new schema. If you used, ".bne-testimonial-slider" only, then you should be fine.
* IMPORTANT CHANGE #2: If you find the Testimonial Slider Widget is not working after this update, this is because a new option was added, see Animation Speed below. To fix this, simply delete the widget and re-add it so that the new option is recognized.
* Updated internal flexslider.js to v2.2.2
* New: Added Animation Speed option to slider shortcode, Ex: [bne_testimonials_slider animation_speed="500"] and to slider widget options.
* New: Now localization Ready!
* Fix: Attempt to address a random issue with mobile safari and the slider (flexslider) stalling when a scrolling event has not finished.
* Tweak: Cleanup CSS
* Tweak: Admin menu icon now uses the default dashicon call within register_post_type() instead of using css to output the icon.
* Note #1: Support is only provided for WP 3.8+.



= 1.6.4 (August 27, 2014) =
* Fix: An issue would arise on the testimonial post list where if an image was placed in the editor the table columns would shift. Changed to using get_the_excerpt here.
* Add: Sanitize the data output of the website url and tagline fields.
* Compatibility Check: Works great in WP 4.0


= 1.6.3 (May 25, 2014) =
* Removed html tag limitations on get_the_content. All html tags and styles will now output normally from the visual/text editor.
* Replaced default admin messages when published/editing a testimonial.
* Adjusted featured image support for themes that don't provide or limit certain post types from using it.



= 1.6.2 (April 22, 2014) =
* Updated Help page to announce PRO version of BNE Testimonials.
* IMPORTANT NOTICE: Filter name "bne_testimonial_single_structure" is now "bne_testimonials_single_structure". This matches the pro version of the same filter name. If you have used this filter to adjust the testimonial structure output, you need also reflect this name change in your custom function used.
* BNE Testimonials is now hosted on the WP Plugin repository! Therefore, we removed our private update function. All future updates will be delivered from WordPress.org.


= 1.6.1 (March 13, 2014) =
* Fix: Corrected an issue within the flexslider.js v2.2 if the slider animation is set to fade and smoothHeight is set to true. What happened is that all slides would retain the inline css of "display:block" even though that particular slide was not an active slide.


= 1.6 (December 27, 2013) =
* Added: Testimonial Title, Featured Image, Tagline/Website URL and Content can now be filtered with your own functions.
* Added: Testimonial Single structure that organizes the above content areas can now be filtered to change their placement or to create your own single  testimonial template.
* Added: Missing Name parameter for list shortcode
* Removed: "If Function Exist" statements were removed since they wouldn't have worked as the plugin is called prior to your theme's functions file... silly me...


= 1.5 (December 6, 2013) =
* Added: <img> tags will now output from the WP editor.
* Moved: Enqueue CSS and JS into their own functions and called via the shortcode/widget for greater placement compatibility in a page/sidebar or theme template file. To prevent the CSS file from being placed into the bottom of the body, it is now enqueued globally... small drawback for validation and flexibility.
* Added: "If Function Exist" statements for CSS/JS, and content output functions.
* Added: Thumbnail support check for themes that do not already provide this.
* Added: 4 filters to the shortcode and widget testimonials to allow greater customization: "bne_testimonials_list_above", "bne_testimonials_list_below", "bne_testimonials_list_single_above", "bne_testimonials_list_single_below", "bne_testimonials_slider_above", "bne_testimonials_slider_below", "bne_testimonials_slider_single_above", and "bne_testimonials_slider_single_below".
* Added: WP 3.8 Menu icon Compatibility (dashicons).
* Updated: flexslider.js to v2.2 (v2.1 is still there for legacy)
* Better organization of plugin functions and code.


= 1.4 (October 31, 2013) =
* Added "speed" parameter to the slider shortcode and slider widget. This determines the speed of the slideshow cycling, in milliseconds. Default is 7000.
* Added optional css option to list and slider widgets which was previously added to the shortcode versions in the previous update.
* Added new Testimonial Order type, "title". You can now display your testimonials in order of publish date, random, or alphabetical.
* Added order_direction parameter for list/slider shortcodes and corresponding option for the list/slider widgets. This goes with the Testimonial Order setting (date, name, random) to display your order query in Ascending or Descending order.
* Added lightbox rel parameter for list/slider shortcodes and a rel option for the list/slider widgets. This allows for the use of an already installed lightbox either from another plugin or from your theme which uses the rel attribute.
* Added a function to create a random ID to be applied to each testimonial slider. This allows multiple sliders on a page to use their own flexslider API based on their ID. This is mostly relevant for the new speed option so each slider can have it own speed setting without effecting the other.
* Arranged the widget options into formatted sections.


= 1.3.1 (Sept 24, 2013) =
* Added an empty class shortcode parameter to target individual list/slider testimonials for easy css customizations.
* Removed an extra comma that was placed on the list shortcode markup.


= 1.3 (Sept 12, 2013) =
* Changed: The get_the_content "hack" with a better and a much simpler one that strips everything out except the following post tags: b, strong, i, em, a, br, h1, h2, h3. The prevents other plugins from throwing in their filtered items such as, social icons, onto every testimonial entry.
* Changed: The list and slider shortcodes into their own included files.
* Added: Featured Image frame styles with their corresponding shortcode/widget attributes: square (default), circle, flat-square, flat-circle.
* Updated the help page.
* Cleaned up and organized code.


= 1.2.2 (Aug 27, 2013) =
* Further Accommodate some random theme styles.
* Allow the taxonomy to be filterable in the Show all Post Edit Screen.


= 1.2.1 (Aug 8, 2013) =
* Accommodate some random theme styles that uses flexslider.


= 1.2 (Aug 4, 2013) =
* Added Custom Taxonomies (Categories)
* Added a category="" parameter into both shortcodes and Widgets as a dropdown option.
* Adjusted the title tags to h4 for widgets and h3 for shortcodes.
* Updated help.php with new info.
* Enabled the auto update class. All future updates can be pulled using the WordPress update API.


= 1.1 (July 31, 2013) =
* Added List and Slider Widget Options.
* Corrected some typos.
* Adjusted the .bne-testimonial-slider-wrapper. Made “testimonial” singular.
* Adjusted the .bne-testimonial-list-wrapper.  Made “testimonial” singular.
* Added auto update class

= 1.0 =
* This is the first release.