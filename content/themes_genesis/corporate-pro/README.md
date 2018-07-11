# Corporate Pro Theme

A feature packed, clean and professional Genesis child theme with built in support for Gutenberg, AMP and more.. Demo - [https://demo.seothemes.com/corporate-pro](https://demo.seothemes.com/corporate-pro)


## Features

#### Gutenberg Support
Built in support for the new WordPress editor which allows you to utilize all of the latest features.

#### AMP Ready
Easily setup Accelerated Mobile Pages to make your website lightning fast on mobile devices.

#### One Click Demo Import
Setup your theme just like how you see it in the demo in less than 5 minutes

#### Custom Colors
Corporate Pro provides custom color settings with transparency options giving you even more control over your theme's colors

#### SEO Slider
We built an entirely new plugin for this theme because all the other slider plugins weren't SEO friendly enough

#### WooCommerce
Fully integrated with the world's most popular WordPress eCommerce plugin WooCommerce

#### Genesis Simple FAQ
Easily add frequently asked questions with the Genesis Simple FAQs plugin

#### Transparent Header
Change the look of the site-header from the Customizer. Choose from either transparent or default

#### Sticky Header
Enable a sticky header that stays in the viewport on scroll from the Customizer

#### Accessibility
Accessibility friendly content that can be navigated with ease using the keyboard

#### Templates & Layouts
Custom page templates and layouts provide plenty of options for displaying your content

#### Portfolio
Showcase your projects in style using the Display Posts Shortcode


## Recommendations

* PHP > 7.0
* WordPress > 4.8
* Genesis Framework > 2.4
* Node.js > 6.9
* Gulp.js > 3.9 


## Installation

1. Upload and install Genesis
2. Upload, install and activate Corporate Pro
3. Install and activate recommended plugins
4. *Important* Delete unwanted existing posts, pages, comments & widgets
5. Import sample.xml from Tools > Import
6. Import widgets.wie from Tools > Widget Importer & Exporter


## Renaming

The following instructions require the use of a text editor with search and replace functionality. You will need to perform a search and replace on all files in the theme folder. If using NPM, the theme should be renamed before running `npm install`. You do not want to edit any files in the `node_modules` directory.

1. Search and replace `corporate-pro` with your theme text domain.
2. Search and replace `corporate_` with your theme function prefix.
3. Search and replace `Corporate Pro` with your theme name.

You can also use the Gulp [rename](#additional-commands) task included with the theme.


## Customization

1. Go to Appearance > Customize > Site Identity to upload a logo
2. Go to Appearamce > Customize > Header Media to upload hero image or video
3. Go to Appearance > Customize > Menus to create menus
4. Go to Appearance > Customize > Static Front Page and configure to your liking
5. Go to Appearance > Customize > Site Layout and configure to your liking
6. Go to Genesis > Theme Settings to enable Breadcrumbs on pages


## Widget Areas

* Header Right
* Primary Sidebar
* After Entry
* Before Header
* Before Footer
* Front page (default 9) 
* Footer (default 4)


## Structure

```shell
theme/  
├── assets/
│   ├── fonts/
│   ├── images/
│   ├── scripts/
│   │   ├── min/
│   │   │   ├── customize.min.js
│   │   │   ├── menus.min.js
│   │   │   └── theme.min.js
│   │   ├── customize.js
│   │   ├── menus.js
│   │   └── theme.js
│   └── styles/
│   │   │   ├── customize.min.css
│   │   │   ├── style.min.css
│   │   │   ├── style.min.css.map
│   │   │   └── woocommerce.min.css
│   │   ├── _common.scss
│   │   ├── _content.scss
│   │   ├── _defaults.scss
│   │   ├── _footer.scss
│   │   ├── _header.scss
│   │   ├── _home.scss
│   │   ├── _layout.scss
│   │   ├── _menus.scss
│   │   ├── _plugins.scss
│   │   ├── _print.scss
│   │   ├── _reset.scss
│   │   ├── _sidebars.scss
│   │   ├── _utilities.scss
│   │   ├── style.scss
│   │   └── woocommerce.scss
├── includes/
│   ├── colors.php
│   ├── customize.php
│   ├── defaults.php
│   ├── general.php
│   ├── helpers.php
│   ├── hero.php
│   ├── plugins.php
│   ├── rgba.php
│   └── widgets.php
├── languages/
│   └── corporate-pro.pot
├── templates/
│   ├── page-boxed.php
│   ├── page-builder.php
│   ├── page-contact.php
│   └── page-landing.php
├── .csscomb.json
├── .editorconfig
├── .gitignore
├── .jsbeautifyrc
├── 404.php
├── CHANGELOG.md
├── customizer.dat
├── front-page.php
├── functions.php
├── gulpfile.js
├── LICENSE.md
├── map.json
├── package-lock.json
├── package.json
├── README.md
├── sample.xml
├── screenshot.png
├── settings.json
├── style.css
└── widgets.wie
```


## Development

Corporate Pro uses [Gulp](http://gulpjs.com/) as a build tool and [npm](https://www.npmjs.com/) to manage front-end packages.

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
* `gulp` — (Default task) runs all of the above tasks.


#### Additional commands

* `gulp translate` — Scan the theme and create `corporate-pro.pot` POT file.
* `gulp zip` — Package theme into zip file for distribution, ignoring `node_modules`.
* `gulp bump` - Bumps version number in all files. See options in example below.
  - `--major` version when you make incompatible API changes
  - `--minor` version when you add functionality in a backwards-compatible manner
  - `--patch` version when you make backwards-compatible bug fixes
  - `--to` allows you to define a custom version number, e.g. `gulp bump --to 0.1.0`
* `gulp rename` - Rename theme Title, Text Domain and Function Prefix.
  - `--to` name for your theme e.g: `gulp rename --to your-theme-name`


### Using Browsersync

To use Browsersync you need to update the proxy URL in `gulpfile.js` to reflect your local development hostname.

If your local development URL is `my-site.dev`, update the file to read:

```javascript
...
  proxy: 'my-site.dev',
...
```

By default, BrowserSync is configured to use an SSL certificate for local development. If using a Non-HTTPS local site, remove the HTTPS BrowserSync configuration and uncomment the HTTP settings.


## Support

Please visit https://seothemes.com/support/ for theme support.


## Customizations

Please visit https://seothemes.com/custom-development/ for theme customizations.


## Authors

- **Lee Anthony** - [SEO Themes](https://seothemes.com/)

See also the list of [contributors](https://github.com/seothemes/corporate-pro/graphs/contributors) who participated in this project.


## License

This project is licensed under the GNU General Public License - see the LICENSE.md file for details.


## Acknowledgments

A shout out to anyone who's code was used:

- Gary Jones
- Tim Jensen
- Craig Watson
- Bill Erickson
- Sridhar Katakam
- Chinmoy Paul
- Nathan Rice
- Calvin Koepke
- Jen Baumann
- Brian Gardner
- Robin Cornett
