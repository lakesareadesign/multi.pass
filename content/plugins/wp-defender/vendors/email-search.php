<?php
/**
 * Author: Hoang Ngo
 */

namespace WP_Defender\Vendors;
class Email_Search extends \WD_Component {
	public $receipts = array();
	public $id = '';

	public function add_hooks() {
		//this should add in init
		$this->add_action( 'wp_ajax_wd_username_search', 'ajax_search_user' );
		$this->add_action( 'wp_ajax_add_receipt', 'add_receipt' );
		$this->add_action( 'wp_ajax_remove_receipt', 'remove_receipt' );
		$this->add_action( 'admin_footer', 'scripts' );
	}

	public function remove_receipt() {
		if ( ! \WD_Utils::check_permission() ) {
			return;
		}
		$id = \WD_Utils::http_post( 'user', $_POST );
		if ( $id ) {
			do_action( 'wd_remove_receipt_' . $this->id, $id );
			die;
		}
	}

	public function add_receipt() {
		if ( ! \WD_Utils::check_permission() ) {
			return;
		}
		$user = \WD_Utils::http_post( 'user', $_POST );
		if ( $user ) {
			do_action( 'wd_add_receipt_' . $this->id, $user );
		}
	}

	public function ajax_search_user() {
		if ( ! \WD_Utils::check_permission() ) {
			return;
		}
		$args    = array(
			'search'         => '*' . \WD_Utils::http_post( 'term' ) . '*',
			'search_columns' => array( 'user_login' ),
			'number'         => 10,
			'exclude'        => $this->receipts,
			'orderby'        => 'user_login',
			'order'          => 'ASC'
		);
		$query   = new \WP_User_Query( $args );
		$results = array();
		foreach ( $query->get_results() as $row ) {
			$results[] = array(
				'id'    => $row->user_login,
				'label' => '<span class="name title">' . esc_html( \WD_Utils::get_full_name( $row->user_email ) ) . '</span> <span class="email">' . esc_html( $row->user_email ) . '</span>',
				'thumb' => \WD_Utils::get_avatar_url( get_avatar( $row->user_email ) )
			);
		}
		echo json_encode( $results );
		exit;
	}

	public function render() {
		?>
		<div class="email-receipts">
			<div class="receipts-list intro">
				<?php foreach ( $this->receipts as $id ): ?>
					<?php $user = get_user_by( 'id', $id ) ?>
					<?php if ( is_object( $user ) ): ?>
						<div class="email-receipt">
							<?php echo get_avatar( $user->ID, 30 ) ?>
							<span><?php echo esc_html( \WD_Utils::get_display_name( $user->ID ) ) ?></span>&nbsp;
							<?php if ( get_current_user_id() == $user->ID ): ?>
								<span class="badge">
								<?php esc_html_e( "You", wp_defender()->domain ) ?>
							</span>
							<?php endif; ?>
							<a data-id="<?php echo esc_attr( $user->ID ) ?>" class="wd-remove-recipient"
							   href="#"><?php esc_html_e( "Remove", wp_defender()->domain ) ?></a>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="inline">
				<input type="search" name="term" id="wd-username-search"/>
			</div>
			<button type="submit" disabled id="add-receipt"
			        class="button button-secondary"><?php _e( "Add", wp_defender()->domain ) ?>
			</button>
		</div>
		<?php
	}

	public function scripts() {
		?>
		<script type="text/javascript">
			jQuery(function ($) {
				var typingTimer;                //timer identifier
				var doneTypingInterval = 1000;  //time in ms, 5 second for example
				var $input = $("#wd-username-search");

				//on keyup, start the countdown
				$input.on('keyup', function () {
					clearTimeout(typingTimer);
					typingTimer = setTimeout(doneTyping, doneTypingInterval);
				});

				//on keydown, clear the countdown
				$input.on('keydown', function () {
					clearTimeout(typingTimer);
				});

				//user is "finished typing," do something
				function doneTyping() {
					//do something
					var that = $input;
					var value = that.val();
					if (value.length > 2) {
						$.ajax({
							type: 'POST',
							url: ajaxurl,
							data: {
								'action': 'wd_username_search',
								'id': '<?php echo $this->id ?>',
								'term': value
							},
							beforeSend: function () {
								that.trigger('progress:start');
							},
							success: function (data) {
								data = $.parseJSON(data);
								that.trigger('progress:stop');
								that.trigger('results:show', [data]);
							}
						})
					}

					$("#wd-username-search").on('item:select', function () {
						$(this).closest('.email-receipts').find('button').removeAttr('disabled')
					})
				}

				$('#add-receipt').click(function () {
					var that = $(this);
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'add_receipt',
							'id': '<?php echo $this->id ?>',
							user: $("#wd-username-search").val()
						},
						beforeSend: function () {
							that.attr('disabled', 'disabled')
						},
						success: function (data) {
							var user_row = $('<div class="email-receipt"/>');
							user_row.append($('<img/>').attr({
								src: data.avatar,
								width: '30'
							}));
							user_row.append($('<span/>').html(data.name));
							if (data.is_current) {
								user_row.append($('<span/>').addClass('badge').html('<?php esc_html_e( "You", wp_defender()->domain ) ?>'))
							}
							user_row.append($('<a/>').attr({
								'data-id': data.user_id,
								'class': 'wd-remove-recipient',
								'href': '#'
							}).html('<?php esc_html_e( "Remove", wp_defender()->domain ) ?>'))
							$('.receipts-list').append(user_row);
							$("#wd-username-search").trigger('results:clear');
							$("#wd-username-search").val('');
						}
					})
					return false;
				})
				$('body').on('click', '.wd-remove-recipient', function (e) {
					e.preventDefault();
					var that = $(this);
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'remove_receipt',
							'id': '<?php echo $this->id ?>',
							user: that.data('id')
						},
						beforeSend: function () {
							that.attr('disabled', 'disabled')
						},
						success: function (data) {
							that.closest('div').remove();
						}
					})
				})
			})
		</script>
		<?php
	}
}