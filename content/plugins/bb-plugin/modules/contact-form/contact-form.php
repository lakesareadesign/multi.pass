<?php

/**
 * @class FLHtmlModule
 */
class FLContactFormModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct()
	{
		parent::__construct(array(
			'name'           	=> __('Contact Form', 'fl-builder'),
			'description'    	=> __('A very simple contact form.', 'fl-builder'),
			'category'       	=> __('Advanced Modules', 'fl-builder'),
			'editor_export'  	=> false,
			'partial_refresh'	=> true
		));

		add_action('wp_ajax_fl_builder_email', array($this, 'send_mail'));
		add_action('wp_ajax_nopriv_fl_builder_email', array($this, 'send_mail'));
	}
    
	/**
	 * @method send_mail
	 */
	static public function send_mail($params = array()) {
    
    global $fl_contact_from_name, $fl_contact_from_email;

		// Get the contact form post data

		$subject = (isset($_POST['subject']) ? $_POST['subject'] : __('Contact Form Submission', 'fl-builder'));
		$mailto = (isset($_POST['mailto']) ? $_POST['mailto'] : null);
    
		$fl_contact_from_email = (isset($_POST['email']) ? $_POST['email'] : null);
		$fl_contact_from_name = (isset($_POST['name']) ? $_POST['name'] : null);
		
		add_filter('wp_mail_from', 'FLContactFormModule::mail_from');
		add_filter('wp_mail_from_name', 'FLContactFormModule::from_name');
        
		// Build the email
		$template = "";

		if (isset($_POST['name']))  $template .= "Name: $_POST[name] \r\n";
		if (isset($_POST['email'])) $template .= "Email: $_POST[email] \r\n";
		if (isset($_POST['phone'])) $template .= "Phone: $_POST[phone] \r\n";

		$template .= __('Message', 'fl-builder') . ": \r\n" . $_POST['message'];

		// Double check the mailto email is proper and send
		if ($mailto) {
			wp_mail($mailto, $subject, $template);
			die('1');
		} else {
			die($mailto);
		}
	}
	
	static public function mail_from($original_email_address) {
		global $fl_contact_from_email;
		return ($fl_contact_from_email != '') ? $fl_contact_from_email : $original_email_address;
	}

	static public function from_name($original_name) {
		global $fl_contact_from_name;
		return ($fl_contact_from_name != '') ? $fl_contact_from_name : $original_name;
	}
	
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLContactFormModule', array(
	'general'       => array(
		'title'         => __('General', 'fl-builder'),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'mailto_email'     => array(
						'type'          => 'text',
						'label'         => __('Send To Email', 'fl-builder'),
						'default'       => '',
						'placeholder'   => __('example@mail.com', 'fl-builder'),
						'help'          => __('The contact form will send to this e-mail', 'fl-builder'),
						'preview'       => array(
							'type'          => 'none'
						)
					),
					'name_toggle'   => array(
						'type'          => 'select',
						'label'         => __('Name Field', 'fl-builder'),
						'default'       => 'show',
						'options'       => array(
							'show'      => __('Show', 'fl-builder'),
							'hide'      => __('Hide', 'fl-builder'),
						)
					),
					'subject_toggle'   => array(
						'type'          => 'select',
						'label'         => __('Subject Field', 'fl-builder'),
						'default'       => 'hide',
						'options'       => array(
							'show'      => __('Show', 'fl-builder'),
							'hide'      => __('Hide', 'fl-builder'),
						)
					),
					'email_toggle'   => array(
						'type'          => 'select',
						'label'         => __('Email Field', 'fl-builder'),
						'default'       => 'show',
						'options'       => array(
							'show'      => __('Show', 'fl-builder'),
							'hide'      => __('Hide', 'fl-builder'),
						)
					),
					'phone_toggle'   => array(
						'type'          => 'select',
						'label'         => __('Phone Field', 'fl-builder'),
						'default'       => 'hide',
						'options'       => array(
							'show'      => __('Show', 'fl-builder'),
							'hide'      => __('Hide', 'fl-builder'),
						)
					)
				)
			),
			'success'       => array(
				'title'         => __( 'Success', 'fl-builder' ),
				'fields'        => array(
					'success_action' => array(
						'type'          => 'select',
						'label'         => __( 'Success Action', 'fl-builder' ),
						'options'       => array(
							'none'          => __( 'None', 'fl-builder' ),
							'show_message'  => __( 'Show Message', 'fl-builder' ),
							'redirect'      => __( 'Redirect', 'fl-builder' )
						),
						'toggle'        => array(
							'show_message'       => array(
								'fields'        => array( 'success_message' )
							),
							'redirect'      => array(
								'fields'        => array( 'success_url' )
							)
						),
						'preview'       => array(
							'type'             => 'none'  
						)
					),
					'success_message' => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'rows'          => 8,
						'default'       => __( 'Thanks for your message! We’ll be in touch soon.', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none'  
						)
					),
					'success_url'  => array(
						'type'          => 'link',
						'label'         => __( 'Success URL', 'fl-builder' ),
						'preview'       => array(
							'type'             => 'none'  
						)
					)
				)
			)
		)
	)    
));

