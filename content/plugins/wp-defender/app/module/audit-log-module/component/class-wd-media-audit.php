<?php

/**
 * Author: Hoang Ngo
 */
class WD_Media_Audit extends WD_Event_Abstract {
	const ACTION_UPLOADED = 'uploaded';
	protected $type = 'media';

	public function get_hooks() {
		return array(
			'add_attachment'     => array(
				'args'         => array( 'post_ID' ),
				'level'        => self::LOG_LEVEL_INFO,
				'event_type'   => $this->type,
				'action_type'  => self::ACTION_UPLOADED,
				'text'         => sprintf( __( "%s uploaded a file: \"%s\" to Media Library", wp_defender()->domain ), '{{wp_user}}', '{{file_path}}' ),
				'program_args' => array(
					'file_path'  => array(
						'callable' => 'get_post_meta',
						'params'   => array(
							'{{post_ID}}',
							'_wp_attached_file',
							true
						),
					),
					'mime_type' => array(
						'callable' => array( 'WD_Audit_API', 'get_mime_type' ),
						'params'   => array(
							'{{post_ID}}'
						)
					)
				),
				'context'      => '{{mime_type}}'
			),
			'attachment_updated' => array(
				'args'         => array( 'post_ID' ),
				'level'        => self::LOG_LEVEL_INFO,
				'action_type'  => WD_Audit_API::ACTION_UPDATED,
				'event_type'   => $this->type,
				'text'         => sprintf( __( "%s updated a file: \"%s\" from Media Library", wp_defender()->domain ), '{{wp_user}}', '{{file_path}}' ),
				'program_args' => array(
					'file_path' => array(
						'callable' => 'get_post_meta',
						'params'   => array(
							'{{post_ID}}',
							'_wp_attached_file',
							true
						),
					),
					'mime_type' => array(
						'callable' => array( 'WD_Audit_API', 'get_mime_type' ),
						'params'   => array(
							'{{post_ID}}'
						)
					)
				),
				'context'      => '{{mime_type}}'
			),
			'delete_attachment'  => array(
				'args'         => array( 'post_ID' ),
				'level'        => self::LOG_LEVEL_INFO,
				'action_type'  => WD_Audit_API::ACTION_DELETED,
				'event_type'   => $this->type,
				'text'         => sprintf( __( "%s deleted a file: \"%s\" from Media Library", wp_defender()->domain ), '{{wp_user}}', '{{file_path}}' ),
				'program_args' => array(
					'file_path' => array(
						'callable' => 'get_post_meta',
						'params'   => array(
							'{{post_ID}}',
							'_wp_attached_file',
							true
						),
					),
					'mime_type' => array(
						'callable' => array( 'WD_Audit_API', 'get_mime_type' ),
						'params'   => array(
							'{{post_ID}}'
						)
					)
				),
				'context'      => '{{mime_type}}'
			),
		);
	}

	public function dictionary() {
		return array(
			self::ACTION_UPLOADED => __( "Uploaded", wp_defender()->domain )
		);
	}
}