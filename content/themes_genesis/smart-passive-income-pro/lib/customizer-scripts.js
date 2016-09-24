/**
 * Smart Passive Income Pro.
 *
 * This file adds the required JS to the customizer for faster previewing.
 *
 * @package Smart Passive Income Pro
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */
(function($) {

    var primary = '#0e763c',
        secondary = '#b4151b',
        frontPage = '#3677aa';

    //* Update Primary color
    wp.customize( 'spi_primary_color', function( value ) {
        
        value.bind( function( newval ) {

            if ( $( '#spi-customizer-primary-preview' ).length == 0 ) {
                $( '<style type="text/css" id="spi-customizer-primary-preview"></style>' ).appendTo('head');
            }
            $( 'body' ).addClass( 'spi-customized' );

            var css  = 'a, \
                .spi-customized .entry-title a:focus, \
                .spi-customized .entry-title a:hover, \
                .spi-customized.js .menu-toggle:focus { \
                    color: ' + newval + '; \
                } \
                .spi-customized button, \
                .spi-customized input[type="button"], \
                .spi-customized input[type="reset"], \
                .spi-customized input[type="submit"], \
                .spi-customized .archive-pagination .active a, \
                .spi-customized .archive-pagination a:focus, \
                .spi-customized .archive-pagination a:hover, \
                .spi-customized.archive .content .entry-comments-link, \
                .spi-customized.single .content .entry-comments-link, \
                .spi-customized.page-template-page_blog .content .entry-comments-link,\
                .spi-customized .site-container a.button, \
                .spi-customized .color .more-link { \
                    background-color: ' + newval + '; \
                } \
                .spi-customized.archive .content .entry-comments-link:after, \
                .spi-customized.single .content .entry-comments-link:after, \
                .spi-customized.page-template-page_blog .content .entry-comments-link:after { \
                    border-left-color: ' + newval + '; \
                } \
                .spi-customized button, \
                .spi-customized input[type="button"], \
                .spi-customized input[type="reset"], \
                .spi-customized input[type="submit"], \
                .spi-customized.archive .content p.entry-meta .entry-comments-link > a, \
                .spi-customized.single .content p.entry-meta .entry-comments-link > a, \
                .spi-customized.page-template-page_blog .content p.entry-meta .entry-comments-link > a, \
                .spi-customized .site-container a.button, \
                .spi-customized .color .more-link { \
                    color: ' + spi_color_contrast( newval ) + '; \
                } \
                .spi-customized button:focus, \
                .spi-customized button:hover, \
                .spi-customized input:focus[type="button"], \
                .spi-customized input:focus[type="reset"], \
                .spi-customized input:focus[type="submit"], \
                .spi-customized input:hover[type="button"], \
                .spi-customized input:hover[type="reset"], \
                .spi-customized input:hover[type="submit"], \
                .spi-customized .site-container a.button:focus, \
                .spi-customized .site-container a.button:hover, \
                .spi-customized .color .more-link:focus, \
                .spi-customized .color .more-link:hover { \
                    background-color: ' + spi_color_brightness( newval, '+', 20 ) + '; \
                    color: ' + spi_color_contrast( newval ) + '; \
                } \
                .spi-customized .menu-toggle:focus, \
                .spi-customized .menu-toggle:hover { \
                    color: ' + spi_color_brightness( newval, '+', 20 ) + '; \
                }';

            $( "#spi-customizer-primary-preview" ).empty().append( css );

            if( primary === newval ) {
                $("#spi-customizer-primary-preview").empty();
            }
        });
    });

    //* Update the secondary color
    wp.customize( 'spi_secondary_color', function( value ) {
        value.bind( function( newval ) {
            if ( $( '#spi-customizer-secondary-preview' ).length == 0 ) {
                $( '<style type="text/css" id="spi-customizer-secondary-preview"></style>' ).appendTo('head');
            }
            $( 'body' ).addClass( 'spi-customized' );

            var css = '.spi-customized .after-entry .widget-title, \
                .spi-customized .footer-banner, \
                .spi-customized .front-page-1, \
                .spi-customized .genesis-nav-menu .sub-menu, \
                .spi-customized .nav-primary .genesis-nav-menu > li.current-menu-item:before, \
                .spi-customized .nav-primary .genesis-nav-menu > li:hover:before, \
                .spi-customized .nav-primary .genesis-nav-menu li.current-menu-item a, \
                .spi-customized .nav-primary, \
                .spi-customized .sidebar .enews-widget .widget-title, \
                .spi-customized .site-container button.sub-menu-toggle.sub-menu-toggle:focus, \
                .spi-customized .site-container button.sub-menu-toggle.sub-menu-toggle:hover, \
                .spi-customized .site-container .nav-primary .genesis-nav-menu > li a:focus, \
                .spi-customized .site-container .nav-primary .genesis-nav-menu > li a:hover { \
                    background-color: ' + newval + '; \
                } \
                .spi-customized .after-entry .widget-title, \
                .spi-customized .after-entry .widget-title a, \
                .spi-customized .after-entry .widget-title a:focus, \
                .spi-customized .after-entry .widget-title a:hover, \
                .spi-customized .color, \
                .spi-customized .color a, \
                .spi-customized .color p.entry-meta a, \
                .spi-customized .color p.entry-meta, \
                .spi-customized .color .entry-title a, \
                .spi-customized .color .menu a, \
                .spi-customized .color .menu li:after, \
                .spi-customized .color.widget-full .menu a, \
                .spi-customized .genesis-nav-menu .sub-menu a, \
                .spi-customized .genesis-nav-menu .sub-menu a:hover, \
                .spi-customized .nav-primary .genesis-nav-menu a, \
                .spi-customized .nav-primary .genesis-nav-menu > li.current-menu-item:before, \
                .spi-customized .nav-primary .genesis-nav-menu > li:hover:before, \
                .spi-customized .sidebar .enews-widget .widget-title, \
                .spi-customized .site-container button.sub-menu-toggle, \
                .spi-customized .site-container .nav-primary .genesis-nav-menu > li a:focus, \
                .spi-customized .site-container .nav-primary .genesis-nav-menu > li a:hover { \
                    color: ' + spi_color_contrast( newval ) + '; \
                } \
                .spi-customized .genesis-nav-menu .sub-menu a { \
                    border-color: ' + spi_color_brightness( newval, '-', 20 ) + '; \
                } \
                .spi-customized .site-container .nav-primary .genesis-nav-menu > li .sub-menu a:hover { \
                    background-color: ' + spi_color_brightness( newval, '-', 20 ) + '; \
                    color: ' + spi_color_contrast( newval ) + '; \
                }';

            if ( newval === '#ffffff' ) {
                css += 'body.spi-customized .site-container .color a.button, \
                body.spi-customized .site-container .color input[type="button"], \
                body.spi-customized .site-container .color input[type="reset"], \
                body.spi-customized .site-container .color input[type="submit"], \
                body.spi-customized .site-container .color .more-link { \
                    background-color: #ebebeb; \
                } \
                body.spi-customized .site-container .color a.button:focus, \
                body.spi-customized .site-container .color a.button:hover, \
                body.spi-customized .site-container .color input[type="button"]:focus, \
                body.spi-customized .site-container .color input[type="button"]:hover, \
                body.spi-customized .site-container .color input[type="reset"]:focus, \
                body.spi-customized .site-container .color input[type="reset"]:hover, \
                body.spi-customized .site-container .color input[type="submit"]:focus, \
                body.spi-customized .site-container .color input[type="submit"]:hover, \
                body.spi-customized .site-container .color .more-link:hover, \
                body.spi-customized .site-container .color .more-link:focus { \
                    background-color: ' + spi_color_brightness( '#ebebeb', '-', 20 ) + '; \
                }';
            }

            $( "#spi-customizer-secondary-preview" ).empty().append( css );

            if( secondary === newval ) {
                $("#spi-customizer-secondary-preview").empty();
            }
        });
    });

    //* Update the Front Page 2 Background
	wp.customize( 'spi_front_page_2_bg_image', function( value ) {
        value.bind( function( newval ) {
        	$( '.front-page-2' ).css( 'background-image', 'url(' + newval + ')' );
        });
    });

    //* Update the Front Page 3 Widget areas background color
    wp.customize( 'spi_home_widget_3_background', function( value ) {
        value.bind( function( newval ) {
            if ( $( '#spi-customizer-front-page' ).length == 0 ) {
                $( '<style type="text/css" id="spi-customizer-front-page"></style>' ).appendTo( 'head' );
            }
            $( 'body' ).addClass( 'spi-customized' );

            var css = '.spi-customized .front-page-3-a, \
                .spi-customized .front-page-3-b { \
                    background-color: ' + newval + '; \
                    color: ' + spi_color_contrast( newval ) + '; \
                } \
                .spi-customized .front-page-3-a a, \
                .spi-customized .front-page-3-a a:focus, \
                .spi-customized .front-page-3-a a:hover, \
                .spi-customized .front-page-3-a p.entry-meta, \
                .spi-customized .front-page-3-a p.entry-meta a, \
                .spi-customized .front-page-3-a p.entry-meta a:focus, \
                .spi-customized .front-page-3-a p.entry-meta a:hover, \
                .spi-customized .front-page-3-a .entry-title a, \
                .spi-customized .front-page-3-a .entry-title a:focus, \
                .spi-customized .front-page-3-a .entry-title a:hover, \
                .spi-customized .front-page-3-b a, \
                .spi-customized .front-page-3-b a:focus, \
                .spi-customized .front-page-3-b a:hover, \
                .spi-customized .front-page-3-b p.entry-meta, \
                .spi-customized .front-page-3-b p.entry-meta a, \
                .spi-customized .front-page-3-b p.entry-meta a:focus, \
                .spi-customized .front-page-3-b p.entry-meta a:hover, \
                .spi-customized .front-page-3-b .entry-title a, \
                .spi-customized .front-page-3-b .entry-title a:hover, \
                .spi-customized .front-page-3-b .entry-title a:focus { \
                    color: ' + spi_color_contrast( newval ) + '; \
                }';

            if ( newval === '#ffffff' ) {
                css += 'body.spi-customized .site-container .color a.button, \
                body.spi-customized .site-container .color input[type="button"], \
                body.spi-customized .site-container .color input[type="reset"], \
                body.spi-customized .site-container .color input[type="submit"], \
                body.spi-customized .site-container .color .more-link { \
                    background-color: #ebebeb; \
                } \
                body.spi-customized .site-container .color a.button:focus, \
                body.spi-customized .site-container .color a.button:hover, \
                body.spi-customized .site-container .color input[type="button"]:focus, \
                body.spi-customized .site-container .color input[type="button"]:hover, \
                body.spi-customized .site-container .color input[type="reset"]:focus, \
                body.spi-customized .site-container .color input[type="reset"]:hover, \
                body.spi-customized .site-container .color input[type="submit"]:focus, \
                body.spi-customized .site-container .color input[type="submit"]:hover, \
                body.spi-customized .site-container .color .more-link:hover, \
                body.spi-customized .site-container .color .more-link:focus { \
                    background-color: ' + spi_color_brightness( '#ebebeb', '-', 20 ) + '; \
                }';
            }

            $( '#spi-customizer-front-page' ).empty().append( css );

            if( frontPage === newval ) {
                $("#spi-customizer-front-page").empty();
            }
        });
    });

    //* Determine the contrast setting
    function spi_color_contrast( color ) {
    
        var hexcolor = color.replace( '#', '' );

        var red   = hexdec( hexcolor.substring( 0, 2 ) );
        var green = hexdec( hexcolor.substring( 2, 4 ) );
        var blue  = hexdec( hexcolor.substring( 4, 6 ) );

        var luminosity = ( ( red * 0.2126 ) + ( green * 0.7152 ) + ( blue * 0.0722 ) );

        return ( luminosity > 128 ) ? '#333333' : '#ffffff';

    }

    //* Helper function to generate hexdecimal
    function hexdec( hexString ) {
        hexString = (hexString + '').replace(/[^a-f0-9]/gi, '')
        return parseInt(hexString, 16)
    }

    //* Calculate Color Brightness
    function spi_color_brightness( color, op, change ) {

        var hexcolor = color.replace( '#', '' );

        var red   = hexdec( hexcolor.substring( 0, 2 ) );
        var green = hexdec( hexcolor.substring( 2, 4 ) );
        var blue  = hexdec( hexcolor.substring( 4, 6 ) );
    
        if ( '+' !== op && typeof( op ) != "undefined" && op !== null ) {
            red   = Math.max( 0, Math.min( 255, red - change ) );
            green = Math.max( 0, Math.min( 255, green - change ) );  
            blue  = Math.max( 0, Math.min( 255, blue - change ) );
        } else {
            red   = Math.max( 0, Math.min( 255, red + change ) );
            green = Math.max( 0, Math.min( 255, green + change ) );  
            blue  = Math.max( 0, Math.min( 255, blue + change ) );
        }

        var hex = 
            ("0" + parseInt( red, 10 ).toString(16)).slice(-2) +
            ("0" + parseInt( green, 10 ).toString(16)).slice(-2) +
            ("0" + parseInt( blue, 10 ).toString(16)).slice(-2);

        if ( hex === hexcolor && op === '+' ) {

            red   = Math.max( 0, Math.min( 255, red - change ) );
            green = Math.max( 0, Math.min( 255, green - change ) );  
            blue  = Math.max( 0, Math.min( 255, blue - change ) );

            hex = 
                ("0" + parseInt( red, 10 ).toString(16)).slice(-2) +
                ("0" + parseInt( green, 10 ).toString(16)).slice(-2) +
                ("0" + parseInt( blue, 10 ).toString(16)).slice(-2);

        }

        return '#' + hex;

    }

})(jQuery);