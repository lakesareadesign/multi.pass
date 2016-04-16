<?php
/* { Module: photocrati-galleria } */

define('NGG_PRO_GALLERIA', 'photocrati-galleria');

class M_Galleria extends C_Base_Module
{
	static $localized_galleries = array();

	function define($context = FALSE)
	{
		parent::define(
            NGG_PRO_GALLERIA,
			'Galleria',
			'Provides support for displaying galleries using Galleria Themes',
            '0.14',
			'http://www.nextgen-gallery.com',
			'Photocrati Media',
			'http://www.photocrati.com',
			$context
		);
	}

	function _register_hooks()
	{
		add_action('wp_enqueue_scripts', array($this, 'register_galleria'), 9);
	}

	function register_galleria()
	{
		wp_register_script(
			'ngg_galleria',
			C_Router::get_instance()->get_static_url(NGG_PRO_GALLERIA . '#galleria-1.4.2.js'),
			array('jquery'),
			'1.4.2'
		);
	}

	function get_type_list()
	{
		return array('A_Galleria_Controller' => 'adapter.galleria_controller.php');
	}

	function _register_adapters()
	{
        $this->get_registry()->add_adapter('I_Display_Type_Controller', 'A_Galleria_Controller', NGG_PRO_GALLERIA);
	}

	static function enqueue_entities($displayed_gallery, $limit = 0, $size_name = 'full', $thumbnail_size_name = 'thumb')
	{
		if (in_array($displayed_gallery->id(), self::$localized_galleries))
			return;

		self::$localized_galleries[] = $displayed_gallery->id();

		$llm = C_Lightbox_Library_Manager::get_instance();

		$ds = $displayed_gallery->display_settings;
		if (!empty($ds['override_thumbnail_settings'])
		&&  $ds['override_thumbnail_settings'])
		{
			$dynthumbs  = C_Dynamic_Thumbnails_Manager::get_instance();
			$dyn_params = array(
				'width'  => $ds['thumbnail_width'],
				'height' => $ds['thumbnail_height'],
				'crop'   => true
			);
			$thumbnail_size_name = $dynthumbs->get_size_name($dyn_params);
		}

		if (!empty($ds['override_image_settings'])
		&&  $ds['override_image_settings']
		&&  !empty($ds['override_image_size_name']))
			$size_name = $ds['override_image_size_name'];

		// Localize the gallery images for startup performance
		$llm->_add_script_data(
			'ngg_common',
			'galleries.gallery_' . $displayed_gallery->id() . '.images_list',
			apply_filters(
				'ngg_pro_lightbox_images_queue',
				self::format_entities(
					$displayed_gallery->get_entities($limit),
					$size_name,
					$thumbnail_size_name
				)
			),
			FALSE
		);

		$llm->_add_script_data(
			'ngg_common',
			'galleries.gallery_' . $displayed_gallery->id() . '.images_list_limit',
			$limit,
			FALSE
		);

		$llm->_add_script_data(
			'ngg_common',
			'galleries.gallery_' . $displayed_gallery->id() . '.images_list_count',
			$displayed_gallery->get_entity_count(),
			FALSE
		);
	}

	static function format_entities($entities = array(), $size_name = 'full', $thumbnail_size_name = 'thumb')
	{
		$retval = array();
		if (!empty($entities))
		{
			$storage = C_Gallery_Storage::get_instance();
			foreach ($entities as $entity) {
				if (isset($entity->is_gallery) && !$entity->is_gallery)
					continue;
				if (isset($entity->is_album) && !$entity->is_album)
					continue;

				$size       = $storage->get_image_dimensions($entity, $size_name);
				$thumb_size = $storage->get_image_dimensions($entity, $thumbnail_size_name);

				$parts      = M_NextGen_PictureFill::prepare_picture_element($entity, $size_name);
				$full_parts = M_NextGen_PictureFill::prepare_picture_element($entity, 'full');

				$retval[] = array(
					'image'            => $storage->get_image_url($entity, $size_name),
					'srcsets'          => $parts['srcsets_unfiltered'],
					'use_hdpi'         => $parts['use_hdpi'],
					'title'            => $entity->alttext,
					'description'      => $entity->description,
					'image_id'         => $entity->{$entity->id_field},
					'thumb'            => $storage->get_image_url($entity, $thumbnail_size_name),
					'width'            => $size['width'],
					'height'           => $size['height'],
					'full_image'       => $storage->get_image_url($entity, 'full'),
					'full_use_hdpi'    => $full_parts['use_hdpi'],
					'full_srcsets'     => $full_parts['srcsets_unfiltered'],
					'thumb_dimensions' => array(
						'width'  => $thumb_size['width'],
						'height' => $thumb_size['height']
					)
				);
			}
		}

		return $retval;
	}
}

new M_Galleria();
