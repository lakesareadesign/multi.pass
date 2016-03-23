<div class="wrap">
<h2>Blog &amp; User</h2>

<!--
<?php if (isset($_GET['msg'])) { ?>
	<div class="message updated fade"><p><?php echo $_GET['msg'];?></p></div>
<?php } ?>
-->

<form action="users.php" method="post">
<input type="hidden" name="bau_add" id="bau_add" value="" />

<div id="bau_tabs">

	<ul>
			<li><a href="#bau_add_new_users"><?php _e('Add New Users', 'bau'); ?></a></li>
			<li><a href="#bau_add_existing_users"><?php _e('Add Existing Users', 'bau'); ?></a></li>
			<li><a href="#bau_add_blogs"><?php _e('Create Blogs', 'bau'); ?></a></li>
	</ul>

	<!--
	********************* Add new user *********************
	-->
	<div id="bau_add_new_users" class="bau_root">
	<?php if ($show_add_new_users) { ?>
		<p> <strong><?php _e( 'Create Multiple Users and Add Them to This Blog', 'bau' ); ?></strong> </p>
		<p> <?php _e( 'Fill out the details below to easily create multiple users and add them to this blog.', 'bau' ); ?> </p>
		<p> <?php _e( 'You can create as many users as you want at one time and new users will be emailed their usernames and passwords automatically. By default, you will see fields for 5 users - if you need more, <strong>simply click the "Add more" button.</strong>', 'bau' ); ?> </p>
		<?php if ($show_add_existing_users) { ?>
			<p> <?php _e( 'To add users that have already been created, please use the <a href="#" id="bau_switch_to_add_existing_users">Add Existing Users functionality here</a>.', 'bau' ); ?> </p>
		<?php } ?>
		<p> <?php _e( "To add new users, simply <strong>enter the username</strong> you'd like to give them (choose carefully as usernames cannot be changed), their email address and - should you so choose - a password for them.", 'bau' ); ?> </p>
		<p> <?php _e( 'Try to use <strong>unique usernames</strong> as this will make the process a lot quicker for you. An easy way to do this is to add numbers and letters after a regular name - for example, "James" at "King Heath School" in year 10 could be "jameskh10".', 'bau' ); ?></p>
		<p> <?php _e( 'If your users do not have email addresses you can use <a href="#" class="bau_gmail_dialog_help">this Gmail method</a> to easily add them.', 'bau' ); ?> </p>
		<p> <?php _e( 'You may also <strong>select the level</strong> that you wish them to access to the site - you can find out more about different level of access <a href="#" class="bau_roles_dialog_help">here</a>.', 'bau' ); ?> </p>
		<p> <?php _e( 'If you do not enter a password a <strong>random</strong> one will be generated for them.', 'bau' ); ?> </p>
		<p> <?php _e( 'All new users will receive an email containing their new username, password and login link. We recommend you use a <strong>preset password</strong> if using an educational email address in case the login email is blocked.', 'bau' ); ?> </p>
		<div class="bau_container"></div>
		<div class="bau_item" style="display:none">
			<h4></h4>
			<p><label><?php _e('Username', 'bau');?></label> <input type="text" size="50" name="bau_user[__count__][username]" /> <span class="bau_required"><?php _e('Required', 'bau');?></span></p>
			<p><label><?php _e('User Email', 'bau');?></label> <input type="text" size="50" name="bau_user[__count__][email]" /> <span class="bau_required"><?php _e('Required', 'bau');?></span></p>
			<p><label><?php _e('User Password', 'bau');?></label> <input type="text" size="50" name="bau_user[__count__][password]" /></p>
			<p>
				<label><?php _e('User Role', 'bau');?></label>
				<select name="bau_user[__count__][role]">
					<?php wp_dropdown_roles(); ?>
				</select>
			</p>
		</div> <!-- .bau_item -->
		<input type="button" class="bau_add_item button" value="<?php _e('Add more', 'bau');?>" />
	<?php } else { ?>
		<p><?php _e('This feature has been disabled by the administrator of your network.')?></p>
	<?php } ?>
	</div>

	<!--
	********************* Add Existing user *********************
	-->
	<div id="bau_add_existing_users" class="bau_root">
	<?php if ($show_add_existing_users) { ?>
		<p> <strong><?php _e( 'Add Existing Users to This Blog', 'bau' ); ?></strong> </p>
		<p><?php _e( 'This tool allows you to add existing users on this site to your blog.', 'bau' ); ?></p>
		<?php if ($show_add_new_users) { ?>
			<p><?php _e( 'To add new users that have not already been created, please use the <a href="#" id="bau_switch_to_add_new_users">Add New Users funcitonality here</a>.', 'bau' ); ?></p>
		<?php } ?>
		<!--
		<p> To add new users, simply <strong>enter each user's email or username</strong> and <strong>select a role</strong> for them on this blog - you can find out more about different level of access <a href="#" class="bau_roles_dialog_help">for different roles here</a>. </p>
		<p> Please try to use <strong>unique usernames</strong> as this will make the process a lot quicker for you. An easy way to do this is to add numbers and letters after a regular name - for example, "James" at "King Heath School" in year 10 could be "jameskh10". </p>
		-->
		<div class="bau_container"></div>
		<div class="bau_item" style="display:none">
			<h4></h4>
			<p><label><?php _e('User email or username', 'bau');?></label> <input type="text" size="50" name="bau_user[__count__][username]" /> <span class="bau_required"><?php _e('Required', 'bau');?></span></p>
			<p>
				<label><?php _e('User Role', 'bau');?></label>
				<select name="bau_user[__count__][role]">
					<?php wp_dropdown_roles(); ?>
				</select>
			</p>
		</div> <!-- .bau_item -->
		<input type="button" class="bau_add_item button" value="<?php _e('Add more', 'bau');?>" />
	<?php } else { ?>
		<p><?php _e('This feature has been disabled by the administrator of your network.')?></p>
	<?php } ?>
	</div>

	<!--
	********************* Add blog *********************
	-->
	<div id="bau_add_blogs" class="bau_root">
	<?php if ($show_add_blogs) { ?>
		<p> <?php _e( '<strong>Add Multiple Blogs and Users</strong>', 'bau' ); ?> </p>
		<p> <?php _e( 'Fill out the details below to easily create multiple users and blogs and add yourself as admin to them (if you wish).', 'bau' ); ?> </p>
		<p> <?php _e( 'You can <strong>create as many users and blogs</strong> as you want at one time. New users will be emailed their usernames and passwords automatically. By default, you will see fields for 5 users and blogs - if you need more, simply <strong>click the "Add more" button.</strong>', 'bau' ); ?> </p>
		<p> <?php _e( 'Try to use <strong>unique usernames</strong> and <strong>blog URLs</strong> as this will make the process a lot quicker for you. An easy way to do this is to add numbers and letters after a regular name - for example, "James" at "King Heath School" in year 10 could be "jameskh10".', 'bau' ); ?> </p>
		<p> <?php _e( 'Choose carefully as usernames and blog URLs <strong>cannot be changed</strong> once they are created.', 'bau' ); ?> </p>
		<p> <?php _e( 'If your users do not have email addresses you can use <a href="#" class="bau_gmail_dialog_help">this Gmail method</a> to add your users!', 'bau' ); ?> </p>
		<p> <?php _e( 'If you leave the blog title blank and the <strong>title will be the same as the username</strong>. You can change this at any time in Settings > General', 'bau' ); ?> </p>
		<p> <?php _e( "Let's begin:", 'bau' ); ?> </p>

		<div class="bau_pre_container">
			<p> <em><?php _e( 'These settings get applied to all of the blogs and users created below.', 'bau' ); ?></em> </p>

			<table cellpadding="0" cellspacing="0">
			<tr>
			<td valign="bottom">
				<p>
				<strong><?php _e( 'Step 1', 'bau' ); ?></strong><br />
				<label><?php _e('Choose a role for your new users on <strong>their</strong> blog', 'bau');?></label>
				</p>
			</td>
			<td valign="bottom">
				<div class="bau_help">
					<div class="bau_help_window" title="<?php _e('New user Role on NEW blog', 'bau');?>">
						<h5><?php _e('New user Role on NEW blog', 'bau');?></h5>
						<p><?php _e( 'This is where you decide what the <em>newly created users</em> will be able to do on their newly created blog.', 'bau' ); ?></p>
						<p><?php _e( '<a href="#" class="bau_roles_dialog_help">Learn more about user roles</a>', 'bau' ); ?></p>
					</div>
				</div>
			</td>
			<td valign="bottom">

				<select name="bau_new_blog_user_role">
					<?php wp_dropdown_roles(); ?>
				</select>
				<span class="bau_required"><?php _e('Required', 'bau');?></span>
			</td>
			</tr>

			<tr>
			<td valign="bottom">
				<p>
				<strong><?php _e( 'Step 2', 'bau' ); ?></strong><br />
				<label><?php _e('Choose a role for your new user on <strong>this</strong> blog', 'bau');?></label>
				</p>
			</td>
			<td valign="bottom">
				<div class="bau_help">
					<div class="bau_help_window" title="<?php _e('New user Role on THIS blog', 'bau');?>">
						<h5><?php _e('New user Role on THIS blog', 'bau');?></h5>
						<p><?php _e( 'This is where you decide what the <em>newly created users</em> will be able to do on <strong><em>this</em></strong> blog.', 'bau' ); ?></p>
						<p><?php _e( '<a href="#" class="bau_roles_dialog_help">Learn more about user roles</a>', 'bau' ); ?></p>
					</div>
				</div>
			</td>
			<td valign="bottom">
				<select name="bau_this_blog_user_role">
					<?php wp_dropdown_roles(); ?>
				</select>
				<span class="bau_required"><?php _e('Required', 'bau');?></span>
			</td>
			</tr>

			<tr>
			<td valign="bottom">
				<p>
				<strong><?php _e( 'Step 3', 'bau' ); ?></strong><br />
				<label><?php _e('Choose <strong>your</strong> role on the new blog', 'bau');?></label>
				</p>
			</td>
			<td valign="bottom">
				<div class="bau_help">
					<div class="bau_help_window" title="<?php _e('My role on NEW blog', 'bau');?>">
						<h5><?php _e('My role on NEW blog', 'bau');?></h5>
						<p><?php _e( 'This is where you decide what <em>you</em> will be able to do on the newly created blog.', 'bau' ); ?></p>
						<p><?php _e( '<a href="#" class="bau_roles_dialog_help">Learn more about user roles</a>', 'bau' ); ?></p>
					</div>
				</div>
			</td>
			<td valign="bottom">
				<select name="bau_new_blog_my_role">
					<option value=""><?php _e('No role', 'bau');?></option>
					<?php wp_dropdown_roles(); ?>
				</select>
				<span class="bau_required"><?php _e('Required', 'bau');?></span>
			</td>
			</tr>

			<?php if (function_exists('supporter_ads') && $supporter_ad_free_remaining > 0) { ?>
			<tr>
			<td valign="bottom">
				<p>
				<strong>Step 4</strong><br />
				<label><?php printf(__('Upgrade and remove ads on new blog:<br /> <small>(you have %d blogs left)</small>', 'bau'), $supporter_ad_free_remaining);?></label>
				</p>
			</td>
			<td valign="bottom"></td>
			<td valign="bottom">
				<input type="checkbox" name="bau_new_blog_upgrade" value="1" />
			</td>
			</tr>
			<?php $step = 5; ?>
			<?php } else $step = 4;?>
		</table>
		</div>

		<p><strong>Step <?php echo $step;?></strong><br /><?php _e( '<strong>Add</strong> your users and blogs', 'bau' ); ?></p>
		<div class="bau_container"></div>
		<div class="bau_item" style="display:none">
			<h4></h4>
			<p>
				<label><?php _e('Username', 'bau');?></label>
				<input type="text" size="50" name="bau_user[__count__][username]" />
				<span class="bau_inline_help"><?php _e( 'This will be the name used to log in, try to use something that will be unique - e.g. jamesqt3.', 'bau' ); ?></span>
				<span class="bau_inline_help"><?php _e( 'For existing users, leave this form blank and just enter the user email below.', 'bau' ); ?></span>
			</p>
			<p>
				<label><?php _e('User Email', 'bau');?></label>
				<input type="text" size="50" name="bau_user[__count__][email]" />
				 <span class="bau_inline_help"><span class="bau_required"><?php _e('Required', 'bau');?></span> - <?php _e( "if a user already exists with this email address, that user will be added to the blog you're creating.", 'bau' ); ?></span>
			</p>
			<p>
				<label><?php _e('User Password', 'bau');?></label>
				<input type="text" size="50" name="bau_user[__count__][password]" />
				<span class="bau_inline_help"><?php _e( 'Leave this blank for a random password to be automaticaly generated and emailed to the user.', 'bau' ); ?></span>
			</p>
			<p>
				<label><?php _e('Blog URL', 'bau');?></label>
				<input type="text" size="50" name="bau_user[__count__][blog_url]" />
				<span class="bau_inline_help"><span class="bau_required"><?php _e('Required', 'bau');?></span> - <?php _e( 'you must fill this in for a blog to be created.', 'bau' ); ?></span>
				<span class="bau_inline_help"><?php _e( 'Try to choose something unique - e.g. myblog1aq will create http://myblog1aq.domain.com.', 'bau' ); ?></span>
			</p>
			<p>
				<label><?php _e('Blog Title', 'bau');?></label>
				<input type="text" size="50" name="bau_user[__count__][blog_title]" />
				<span class="bau_inline_help"><?php _e( 'This will appear as the title and can easily be changed later on - e.g. My School Blog.', 'bau' ); ?></span>
			</p>

			<?php if ( $display_templates ): ?>
				<p>
					<label><?php _e('Template', 'bau');?></label>
					<?php $blog_templates->get_template_dropdown( 'bau_user[__count__][template]', true ); ?>
				</p>
			<?php endif; ?>
<!--
			<p>
				<label><?php _e('Add me as Admin', 'bau');?></label>
				<input type="checkbox" name="bau_user[__count__][add_me_as_admin]" /><br style="clear:left" />
				<span class="bau_inline_help">This will add you as co-administrator of the blog so you can log into it and edit settngs / make posts.</span>
			</p>
-->

		</div> <!-- .bau_item -->
		<input type="button" class="bau_add_item button" value="<?php _e('Add more', 'bau');?>" />
	<?php } else { ?>
		<p><?php _e('This feature has been disabled by the administrator of your network.')?></p>
	<?php } ?>
	</div>

</div> <!-- #bau_tabs -->

<div title="Gmail + trick" id="bau_gmail_dialog_help" style="display:none;">
	<h4><?php _e( 'Gmail + trick', 'bau' ); ?></h4>
	<p><?php _e( 'You can create as many unique email addresses as you want by simply adding &quot;+&quot; character to your email username, followed by something unique. All messages sent to this address will end up in your one Gmail inbox.', 'bau' ); ?></p>
	<h5><?php _e( 'How to use Gmail + Trick', 'bau' ); ?></h5>
	<p><?php _e( 'All you need to do is create one gmail account like <code>mathiscool@gmail.com</code> or <code>room16@gmail.com</code>.', 'bau' ); ?></p>
	<p><?php _e( 'Gmail ignores any letters and numbers you add after a + sign and sends all emails to your one gmail account while our system thinks each is unique email.', 'bau' ); ?></p>
	<h6><?php _e( 'Example', 'bau' ); ?></h6>
	<p><?php _e( 'You might use <code>mathiscool+jameskh10@gmail.com</code>, <code>mathiscool+davesskh10@gmail.com</code> and so on for creating their usernames and gmail will send all emails to the one gmail account <code>mathiscool@gmail.com</code>', 'bau' ); ?></p>
	<img src="<?php echo BAU_PLUGIN_URL;?>/img/gmail_trick_1.png" />
</div>
<div title="WordPress user roles" id="bau_roles_dialog_help" style="display:none">
	<h4><?php _e( 'WordPress user roles', 'bau' ); ?></h4>
	<p><?php _e( 'There are five pre-defined Roles: Administrator, Editor, Author, Contributor and Subscriber. Each Role is allowed to perform a set of tasks called Capabilities. ', 'bau' ); ?></p>
	<p><?php _e( 'The Administrator Role is allowed to perform all possible Capabilities. Each of the other Roles has a decreasing number of allowed Capabilities.', 'bau' ); ?></p>
	<h5><?php _e( 'Summary of Roles', 'bau' ); ?></h5>
	<ul>
		<li><?php _e( "<em>Administrator</em> - Somebody who has access to all the administration features", 'bau' ); ?></li>
		<li><?php _e( "<em>Editor</em> - Somebody who can publish and manage posts and pages as well as manage other users' posts, etc.", 'bau' ); ?></li>
		<li><?php _e( "<em>Author</em> - Somebody who can publish and manage their own posts", 'bau' ); ?></li>
		<li><?php _e( "<em>Contributor</em> - Somebody who can write and manage their posts but not publish them", 'bau' ); ?></li>
		<li><?php _e( "<em>Subscriber</em> - Somebody who can only manage their profile", 'bau' ); ?></li>
	</ul>
	<div><small><?php _e( 'From <a target="_blank" href="http://codex.wordpress.org/Roles_and_Capabilities">WordPress Codex</a>', 'bau' ); ?></small></div>
	<img src="<?php echo BAU_PLUGIN_URL;?>/img/user_roles_1.jpg" width="450" />
</div>

<div id="bau-progress-bar-dialog" style="display:none" title="<?php _e('Please, wait...', 'bau');?>">
	<div id="bau-progress-bar"></div>
	<input type="hidden" id="bau-progress-total" value="0" />
	<input type="hidden" id="bau-progress-errors" value="0" />
</div>

<p class="submit"><input id="bau-submit" name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Submit'); ?>" /></p>
</form>

</div> <!-- wrap -->

<script type="text/javascript">
(function ($) {
$(function () {

var $_oldPanel = false;
var _updateMessage = '';

function cleanUpOldItems () {
	if (!$_oldPanel || !$_oldPanel.length) return false;
	$_oldPanel.find(".bau_item:visible").remove();
}

function resetProgressDialog () {
	if ($("#bau-progress-bar").is(":data(progressbar)")) $("#bau-progress-bar").progressbar("value", 0);
	$("#bau-progress-total").val(0);
	$("#bau-progress-errors").val(0);
	$("#bau-progress-bar-dialog .updated, #bau-progress-bar-dialog .error").remove();
}

function handleSelection ($tab) {
	resetProgressDialog();
	$(".bau-error-output").remove();
	var panel = false;
	switch ($tab.attr('id')) {
		case 'bau_add_new_users': panel = 'add_new'; break;
		case 'bau_add_existing_users': panel = 'add_existing'; break;
		case 'bau_add_blogs': panel = 'add_blog'; break;
		default: break;
	}
	if (!panel) return false;
	$("#bau_add").val(panel);
}

function selectTab ($tab) {
	switch ($tab.attr('id')) {
		//case 'bau_add_new_users': $("#bau_tabs").tabs("select", 0); break;
		case 'bau_add_new_users': $("#bau_tabs").tabs("option", "active", 0); break;
		//case 'bau_add_existing_users': $("#bau_tabs").tabs("select", 1); break;
		case 'bau_add_existing_users': $("#bau_tabs").tabs("option", "active", 1); break;
		//case 'bau_add_blogs': $("#bau_tabs").tabs("select", 2); break;
		case 'bau_add_blogs': $("#bau_tabs").tabs("option", "active", 2); break;
	}
	setTimeout(function () { $(document).trigger('bau-tab_selected'); }, 100);
}

// Add items
function addItem ($me) {
	var $parent = $me.parents('.bau_root');
	if (!$parent.length) return false;

	var $copy = $parent.find(".bau_item:not(:visible):first");
	if (!$copy.length) return false;

	var $container = $parent.find(".bau_container");
	if (!$container.length) return false;

	for(var i=0; i<5; i++) {
		var $new = $copy.clone();
		var count = $parent.find(".bau_item").length - 1;
		$new
			.find("input, select").each(function () {
				var name = $(this).attr('name');
				$(this)
					.attr('name', name.replace(/__count__/, count))
					.val('')
					.find('option:first')
						.attr('selected', true)
				;
			}).end()
			.find("h4").text(
				(count+1) + ': '
			)
		;
		$new.css('display', 'block');
		$container.append($new);
	}
	return false;
}

$("#bau_tabs").tabs({
	activate: function (e, ui) {
		cleanUpOldItems();
		$_oldPanel = $(ui.newPanel);
		handleSelection($_oldPanel);
		addItem($_oldPanel.find(".bau_add_item"));
		setTimeout(function () { $(document).trigger('bau-tab_selected'); }, 100);
	}
});

// "Add more" handler
$(".bau_add_item").click(function () { addItem($(this)); });

// Clean up items used for copying
$('form').submit(function () {
	$(this).find("input, select").each(function () {
		if ($(this).attr('name').match(/__count__/)) $(this).remove();
	});
});

// AJAX processing handler
$("#bau-submit").click(function (e) {
	e.preventDefault();
	var $parent = $('.bau_root:visible');
	if (!$parent.length) return false;

	// Reset old output
	$(".bau-error-output").remove();

	// Fill in basics
	var req = {"action": "bau_process", "bau_add": $("#bau_add").val()};

	// Fill in extra fields
	$parent.find('.bau_pre_container input, .bau_pre_container select').each(function () {
		if ("checkbox" == $(this).attr("type") && !$(this).is(":checked")) return true;
		req[$(this).attr('name')] = $(this).val();
	});

	// Show progress bar
	$("#bau-progress-bar").progressbar({
		"change": function () {
			if (100 != $("#bau-progress-bar").progressbar("value")) return false;
			var count = parseInt($("#bau-progress-total").val());
			var errorCount = parseInt($("#bau-progress-errors").val());
			var className = (count) ? "updated" : "error";
			var errorMsg = (errorCount) ? '<div class="error"><p>There was ' + errorCount + ' error(s)</p></div>' : '';
			var msg = count ? count + ' ' + _updateMessage + '<br />' + '<a href="users.php">Show users</a>' : 'Nothing was added';
			$("#bau-progress-bar-dialog").append(
				'<div class="' + className + '"><p>' +
					msg +
				'</p></div>' +
				errorMsg
			);
		}
	});
	$("#bau-progress-bar-dialog").dialog({
		"width": 600,
		"modal": true,
		"beforeClose": function () {
			if (100 != $("#bau-progress-bar").progressbar("value")) return false;
		},
		"close": function () {
			resetProgressDialog();
		}
	});
	var step = 100 / ($parent.find(".bau_item:visible").length);
	var total = 0;
	var totalErrors = 0;

	// Submit one row at the time
	$parent.find(".bau_item:visible").each(function () {
		var $me = $(this);
		var reqCopy = $.extend(true, reqCopy, req); // We're actually submitting a copy
		var proceedAfterValidation = true
		$me.find('input, select').each(function () {
			var name = $(this).attr('name');
			var value = $(this).val();
			if ('add_existing' != $("#bau_add").val()) { // Check only for non-existent users
				if (name.match(/username/) || name.match(/blog_url/)) {
					// Check for alphanumeric characters
					var ret = true;
					if (value.match(/[^a-zA-Z0-9]/)) {
						var clean = value.toLowerCase().replace(/[^a-zA-Z0-9]/g, '');
						proceedAfterValidation = confirm(
							"We found non-alphanumeric characters in '" + value + "'. " +
							"If you proceed, your entry will be changed to '" + clean + "'. \n" +
							"Do you want to proceed?"
						);
					}
					if (!proceedAfterValidation) return false; // Break processing loop for this item
				}
			}
			reqCopy[name] = value;
		});
		if (!proceedAfterValidation) {
			$("#bau-progress-bar").progressbar("value", 100);
			//$("#bau-progress-bar-dialog").dialog("close");
			return false; // Skip this item and continue
		}
		// Make a request
		$.post(ajaxurl, reqCopy, function (data) {
			var pval = $("#bau-progress-bar").progressbar("value");
			var status;
			var msg;
			try {
				msg = data.msg;
				status = parseInt(data.status);
			} catch (e) {
				msg = 'Error';
				status = false;
			}
			if (status <= 0) {
				if (status < 0) {
					$me.append('<div class="bau-error-output error">' + msg + '</div>');
					totalErrors += 1;
					$("#bau-progress-errors").val(totalErrors);
				}
				$("#bau-progress-bar").progressbar("value", pval+step);
				return false;
			}
			_updateMessage = msg;
			$me.find('input, select')
				.val('')
				.find('option:first')
					.attr('selected', true)
			;
			total += 1;
			$("#bau-progress-total").val(total);
			$("#bau-progress-bar").progressbar("value", pval+step);
		});
	});

	return false;
});

// Help and UI
setTimeout(function () {
	$("#bau_status_message.updated").hide('slow');
}, 6000);
$("#bau_switch_to_add_existing_users").click(function () {
	if ($("#bau_add_existing_users").length) $("#bau_tabs").tabs("select", 1);
	return false;
});
$("#bau_switch_to_add_new_users").click(function () {
	if ($("#bau_add_new_users").length) $("#bau_tabs").tabs("select", 0);
	return false;
});
$(".bau_gmail_dialog_help").click(function () {
	$("#bau_gmail_dialog_help").dialog({
		"modal": true,
		"width": 600
	});
	return false;
});
$(".bau_roles_dialog_help").click(function () {
	$("#bau_roles_dialog_help").dialog({
		"modal": true,
		"width": 600
	});
	return false;
});
$(".bau_help")
	.attr("title", "<?php _e("Click here for help", "bau");?>")
	.click(function() {
		$(this).find('.bau_help_window').clone(true).dialog({
			"modal": true,
			"width": 600
		});
	});
;

// Initialize
if ($("#<?php echo $tab_id;?>").length) {
	$_oldPanel = $("#<?php echo $tab_id;?>");
	selectTab($_oldPanel);
	handleSelection($_oldPanel);
} else {
	$_oldPanel = $(".bau_root:first");
	handleSelection($_oldPanel);
}
addItem($_oldPanel.find(".bau_add_item"));

});
})(jQuery);
</script>