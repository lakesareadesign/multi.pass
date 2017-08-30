# Studio Pro Theme

Studio Pro is a slick & colorful theme for creative agencies. It features stunning background videos and colorful gradient overlays for a truly unique design. Including infinite layout possibilities, color schemes, Google Fonts and customizer options. Easily create a filterable masonry portfolio, widgetized pages, lightbox galleries, a masonry blog or even a WooCommerce store. With all these features Studio Pro is still lightweight and optimized to the highest level.


## Features

* Custom gradient color schemes
* Hero image or video
* Lightbox gallery support
* WooCommerce integration
* Masonry portfolio with isotope filters
* Testimonials section
* Fully responsive and mobile first


## Requirements

* PHP > 5.6
* WordPress > 4.7
* Genesis Framework > 2.0
* Node.js > 6.9
* Gulp.js > 3.9


## Installation

1. Upload and install Genesis
2. Upload, install and activate Studio Pro
3. Install and activate recommended plugins
4. *Important* Delete unwanted existing posts, pages, comments & widgets
5. Import sample.xml from Tools > Import
6. Import widgets.wie from Tools > Widget Importer & Exporter


## Customization

1. Go to Appearance > Customize > Site Identity to upload a logo
2. Go to Appearamce > Customize > Header Media to upload hero image or video
3. Go to Appearance > Customize > Menus to create menus
4. Go to Appearance > Customize > Static Front Page and configure to your liking
5. Go to Appearance > Customize > Site Layout and configure to your liking
6. Go to Genesis > Theme Settings to enable Breadcrumbs on pages


## Widget Areas

* Before header
* Header right
* Primary sidebar
* Before footer
* Front page (dynamic)
* Footer (dynamic)


## Structure

```shell
theme/
├── assets/
│   ├── fonts/
│   ├── images/
│   ├── scripts/
│   └── styles/
├── includes/
│   ├── customize.php
│   ├── defaults.php
│   ├── helpers.php
│   ├── hero.php
│   ├── output.php
│   ├── plugins.php
│   ├── sidebars.php
│   └── woocommerce.php
├── languages/
│   └── studio-pro.pot
├── templates/
│   ├── page-builder.php
│   ├── page-contact.php
│   ├── page-landing.php
│   └── page-masonry.php
├── .editorconfig
├── archive-portfolio.php
├── CHANGELOG.md
├── front-page.php
├── functions.php
├── gulpfile.js
├── package.json
├── README.md
├── sample.xml
├── screenshot.png
├── style.css
└── widgets.wie
```


## Development

Studio Pro uses [Gulp](http://gulpjs.com/) as a build tool and [npm](https://www.npmjs.com/) to manage front-end packages. To load minified stylesheet on the front-end, add the following snippet inside the `studio_enqueue_scripts_styles` function in functions.php.

```php
// Remove default stylesheet.
wp_deregister_style( 'studio-pro' );
wp_dequeue_style( 'studio-pro' );

// Load minified child theme stylesheet.
wp_register_style( 'studio-pro', get_stylesheet_directory_uri() . '/assets/styles/min/style.min.css', array(), CHILD_THEME_VERSION );
wp_enqueue_style( 'studio-pro' );
```

Using the minified stylesheet changes the file path which will break the loading of icon fonts. To fix this, edit the `assets/styles/_fonts.scss` file and change `assets/` in the font URL's to `../../`. This is also the path you should use if loading any assets such as fonts or images in your theme.


### Install dependencies

From the command line on your host machine, navigate to the theme directory then run `npm install`:

```shell
# @ themes/your-theme-name/
$ npm install
```

You now have all the necessary dependencies to run the build process.


### Build commands

* `gulp styles` — Compile, autoprefix and minify Sass files.
* `gulp scripts` — Minify javascript files.
* `gulp images` — Compress and optimize images.
* `gulp watch` — Compile assets when file changes are made, start Browsersync
* `gulp` — Default task - runs all of the above tasks.


#### Additional commands

* `gulp i18n` — Scan the theme and create a POT file.
* `gulp zip` — Package theme into zip file for distribution.


### Using Browsersync

To use Browsersync you need to update the proxy URL on line 299 of `gulpfile.js` to reflect your local development hostname.

If your local development URL is `my-site.dev`, update the file to read:

```javascript
...
  proxy: 'my-site.dev',
...
```


## Support

Please visit https://seothemes.com/support/ for theme support.
