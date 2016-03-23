module.exports = function( grunt ) {
	'use strict';

	require('load-grunt-tasks')(grunt);

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		makepot: {
			options: {
				exclude: ['node_modules/.*'],
				domainPath: '/languages',
				type: 'wp-theme',
				processPot: function( pot, options ) {
					pot.headers['report-msgid-bugs-to'] = 'http://shaybocks.com/';
					pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
					pot.headers['last-translator'] = 'Shay Bocks (http://shaybocks.com)\n';
					pot.headers['language-team'] = 'Shay Bocks (http://shaybocks.com)\n';
					pot.headers['x-poedit-basepath'] = '.\n';
					pot.headers['x-poedit-language'] = 'English\n';
					pot.headers['x-poedit-country'] = 'UNITED STATES\n';
					pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
					pot.headers['x-poedit-keywordslist'] = '__;_e;__ngettext:1,2;_n:1,2;__ngettext_  noop:1,2;_n_noop:1,2;_c,_nc:4c,1,2;_x:1,2c;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;\n';
					pot.headers['x-textdomain-support'] = 'yes\n';
					return pot;
				}
			},
			files: {
				src: [ '**/*.php' ],
			}
		},

		addtextdomain: {
			options: {
				textdomain: 'foodiepro',
				updateDomains: ['all']
			},
			files: {
				src: [ '**/*.php', '!node_modules/**/*.php' ],
			}
		},

		version: {
			project: {
				src: [
					'package.json'
				]
			},
			functions: {
				options: {
					prefix: 'THEME_VERSION\'\,\\s+\''
				},
				src: [
					'functions.php'
				]
			},
			style: {
				options: {
					prefix: '\\s+\\*\\s+Version:\\s+'
				},
				src: [
					'style.css'
				]
			}
		},

		watch: {
			scripts: {
				files: [ '**/*.php' ],
				tasks: 'makepot',
				options: {
					spawn: false,
				}
			}
		}

	});

	grunt.registerTask('default', ['watch']);
	grunt.registerTask('build', ['addtextdomain', 'makepot']);

};
