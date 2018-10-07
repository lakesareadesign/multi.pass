<?php
/**
 * A list of themes. For now they will be sorted outside this file,
 * but as the list grows we might want to start organizing this list
 * The type should be free, premium, or bonus
 */
return array(
   'theme-two' => array(
      'folder' => 'theme-two',
      'title' => 'Theme Two',
      'type' => 'free',
      'supports' => array('flex', 'responsive', 'nivo', 'coin'),
      'tags' => array('modern', 'clean', 'arrows', 'minimalist'),
      'description' => __('Description TBC', 'ml-slider'),
      'images' => array('danny-howe-361436-unsplash.jpg', 'etienne-beauregard-riverin-48305-unsplash.jpg', 'luca-bravo-198062-unsplash.jpg')
   ),
	'theme-one' => array(
		'folder' => 'theme-one',
		'title' => 'Theme One',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('modern', 'clean', 'arrows', 'minimalist'),
		'description' => __('Description TBC', 'ml-slider'),
		'images' => array('danny-howe-361436-unsplash.jpg', 'etienne-beauregard-riverin-48305-unsplash.jpg', 'manki-kim-269196-unsplash.jpg')
	),
	'architekt' => array(
		'folder' => 'architekt',
		'title' => 'The Architekt',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('modern', 'clean', 'arrows', 'minimalist'),
		'description' => __('A modern, minimalist theme for showcasing your beautiful pictures.', 'ml-slider'),
		'images' => array('danny-howe-361436-unsplash.jpg', 'etienne-beauregard-riverin-48305-unsplash.jpg', 'luca-bravo-198062-unsplash.jpg')
	),
    'simply-dark' => array(
		'folder' => 'simply-dark',
		'title' => 'Simply Dark',
        'type' => 'free',
        'supports' => array('flex', 'responsive', 'nivo', 'coin'),
        'tags' => array('dark', 'minimalist', 'custom captions'),
		'description' => __('A modern, clean no-frills design that was build to blend in with most themes.', 'ml-slider'),
		'images' => array(
			array(
				'filename' => 'etienne-beauregard-riverin-48305-unsplash.jpg',
				'caption' => 'Here is an example of a slide with a caption.',
				'title' => 'About Us',
				'alt' => 'A photo of our office',
				'description' => 'A description is also possible'
			),
			array(
				'filename' => 'danny-howe-361436-unsplash.jpg',
				'caption' => '<h2>Captions can have<br><span style="font-size:130%">HTML</span></h2>.'
			),
			array(
				'filename' => 'norbert-levajsics-203627-unsplash.jpg',
				'caption' => ''
			),
			array(
				'filename' => 'yoann-siloine-532511-unsplash.jpg',
				'caption' => ''
			),
		),
		'instructions' => 'Optionally you can add some special instructions for the user to follow. You can also use <strong>HTML</strong>'
   	),
	'theme-seven' => array(
		'folder' => 'theme-seven',
		'title' => 'Theme Seven',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('TBC'),
		'description' => __('TBC', 'ml-slider'),
		'images' => array('wabi-jayme-578762-unsplash.jpg', 'manki-kim-269196-unsplash.jpg', 'danny-howe-361436-unsplash.jpg')
   	),
   	'theme-five' => array(
		'folder' => 'theme-five',
		'title' => 'Theme Five',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('TBC'),
		'description' => __('TBC', 'ml-slider'),
		'images' => array('wabi-jayme-578762-unsplash.jpg', 'manki-kim-269196-unsplash.jpg', 'danny-howe-361436-unsplash.jpg')
	),
   	'theme-four' => array(
		'folder' => 'theme-four',
		'title' => 'Theme Four',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('TBC'),
		'description' => __('TBC', 'ml-slider'),
		'images' => array('wabi-jayme-578762-unsplash.jpg', 'manki-kim-269196-unsplash.jpg', 'danny-howe-361436-unsplash.jpg')
   	),
   	'theme-three' => array(
		'folder' => 'theme-three',
		'title' => 'Theme Three',
		'type' => 'free',
		'supports' => array('flex', 'responsive', 'nivo'),
		'tags' => array('TBC'),
		'description' => __('TBC', 'ml-slider'),
		'images' => array('wabi-jayme-578762-unsplash.jpg', 'manki-kim-269196-unsplash.jpg', 'danny-howe-361436-unsplash.jpg')
	),
	'nivo-light' => array(
		'folder' => 'nivo-light',
		'title' => 'Nivo Light',
		'type' => 'free',
		'supports' => array('nivo'),
		'tags' => array('nivo only'),
		'description' => __('The Nivo Light theme.', 'ml-slider')
	),
	'nivo-bar' => array(
		'folder' => 'nivo-bar',
		'title' => 'Nivo Bar',
		'type' => 'free',
		'supports' => array('nivo'),
		'tags' => array('nivo only'),
		'description' => __('The Nivo Bar theme.', 'ml-slider')
	),
	'nivo-dark' => array(
		'folder' => 'nivo-dark',
		'title' => 'Nivo Dark',
		'type' => 'free',
		'supports' => array('nivo'),
		'tags' => array('nivo only'),
		'description' => __('The Nivo Dark theme.', 'ml-slider')
	)
);
