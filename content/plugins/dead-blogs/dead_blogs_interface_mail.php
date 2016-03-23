<?php

function _dead_blogs_get_blog_info ($blog_id, $for_html_display = false)
{
    $blog = array();

    // grab various things from wp functions
    $blog_details = get_blog_details($blog_id);

    $blog['id']     = $blog_details->blog_id;
    $blog['name']   = $blog_details->blogname;
    $blog['path']   = $blog_details->path;
    $blog['url']    = $blog_details->siteurl;
    $blog['users']  = get_users(array('blog_id' => $blog_id, 'role' => 'administrator'));
    $blog['mail']   = get_blog_option($blog_id, 'admin_email');

    // user display list for the left-hand side
    $blog['user_display_list'] = array();

    if ($blog['users'] and is_array($blog['users']) and count($blog['users']) > 0)
        foreach ($blog['users'] as $user)
            $blog['user_display_list'][] = sprintf('%s (%s) (%s)', $user->display_name, $user->user_login, $user->user_email);
    else
        $blog['user_display_list'][] = $blog['mail'];

    // to address and cc addresses
    $blog['email_cc'] = array();

    if ($blog['users'] and is_array($blog['users']) and count($blog['users']) > 0)
        for ($i = 0; $i < count($blog['users']); $i++)
            if ($i == 0)
                $blog['email_to'] = $blog['users'][$i]->user_email;
            else
                $blog['email_cc'][] = $blog['users'][$i]->user_email;
    else
        $blog['email_to'] = $blog['mail'];


    if (isset($_REQUEST['subject']) and $_REQUEST['subject'] and isset($_REQUEST['body']) and $_REQUEST['body'])
    {
        // the search (and replace) for codes
        $admin_name = 'Blog Administrator';
        if ($blog['users'] and is_array($blog['users']) and count($blog['users']) > 0)
            $admin_name = $blog['users'][0]->display_name;

        $search     = array('$blogname', '$blogurl', '$adminname');
        $replace    = array($blog['name'], $blog['url'], $admin_name);

        if ($for_html_display)
        {
            $search[]   = "\n";
            $replace[]  = "<br/>\n";
        }

        $blog['email_subject']  = str_replace($search, $replace, stripslashes($_REQUEST['subject']));
        $blog['email_body']     = str_replace($search, $replace, stripslashes($_REQUEST['body']));
    }

    return $blog;
}

function dead_blogs_interface_mail_input ()
{
    global $dead_blogs_status_message, $dead_blogs_current_page;

    // check if the inputs are right, and if so, send emails and go back to main page
    if (
        isset($_REQUEST['blog_ids']) and is_array($_REQUEST['blog_ids']) and count($_REQUEST['blog_ids']) > 0 and
        isset($_REQUEST['subject']) and $_REQUEST['subject'] and
        isset($_REQUEST['body']) and $_REQUEST['body'] and
        isset($_REQUEST['confirmed']) and $_REQUEST['confirmed']
    )
    {
        // check nonce
            if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'dead_blogs_confirm_mail'))
                die('Request failed the Security Check.  Please try again.');

        // generate from address
            $url = get_bloginfo('url');
            $domain_matches = array();

            if(!preg_match('#https?://([^/]+)(?:/|$)#', $url, $domain_matches))
            {
                var_dump($url);
                var_dump($domain_matches);
                die('Could not grab domain name.  Please contact plugin owner with output from this page.');
            }

            $domain = $domain_matches[1];

        // do send
        // WP TODO: make this not CU-specific
            $success_counter = 0;
            foreach ((array)$_REQUEST['blog_ids'] as $blog_id)
            {
                $blog = _dead_blogs_get_blog_info($blog_id);

                $headers = '';

                //$headers .= sprintf("To: %s\r\n", $blog['email_to']);
                $headers .= sprintf("From: %s\r\n", "no-reply@$domain");

                if ($_REQUEST['replyto'])
                    $headers .= sprintf("Reply-To: %s\r\n", $_REQUEST['replyto']);

                $to = $blog['email_to'];

                if (count($blog['email_cc']) > 0)
                {
                    $headers .= sprintf("CC: %s\r\n", join(', ', $blog['email_cc']));
                    $to .= ', '.join(', ', $blog['email_cc']);
                }

                if (mail($to, $blog['email_subject'], $blog['email_body'], $headers))
                    $success_counter++;
            }
            unset($blog);

        // back to main page (with a notification)
            $dead_blogs_status_message = sprintf('<div class="updated" id="message"><p>%d out of %d emails sent.</p></div>', $success_counter, count($_REQUEST['blog_ids']));
            $dead_blogs_current_page = 'main';
    }
}

function dead_blogs_interface_mail_output ()
{
    if (
        isset($_REQUEST['blog_ids']) and is_array($_REQUEST['blog_ids']) and count($_REQUEST['blog_ids']) > 0 and
        isset($_REQUEST['subject']) and $_REQUEST['subject'] and
        isset($_REQUEST['body']) and $_REQUEST['body']
    )
    {
        dead_blogs_interface_mail_confirm_output();
    }
    else
    {
        dead_blogs_interface_mail_compose_output();
    }
}

function dead_blogs_interface_mail_confirm_output ()
{
    // get our list of blogs and their info
    $blogs = array();

    foreach ((array)$_REQUEST['blog_ids'] as $blog_id)
    {
        $blogs[] = _dead_blogs_get_blog_info($blog_id, true);
    }

    // and output
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>/dead_blogs.css"/>
<script type="text/javascript">
jQuery(window).load(function () {
    jQuery('.toggle_handle').click(function () {
        jQuery(this).find('.toggle_content').toggle();
    });

    jQuery('div#dead_blogs_email_left div.blog').hover(
        function () { jQuery(this).find('div.remove').show(); },
        function () { jQuery(this).find('div.remove').hide(); }
    );

    jQuery('div#dead_blogs_email_left div.blog').mouseenter(function () {
        jQuery('div#dead_blogs_email_left div.blog').removeClass('selected');
        jQuery(this).addClass('selected');

        jQuery('#dead_blogs_email_right .email_to').html(jQuery(this).find('.email_to').html());
        jQuery('#dead_blogs_email_right .email_cc').html(jQuery(this).find('.email_cc').html());
        jQuery('#dead_blogs_email_right .email_subject').html(jQuery(this).find('.email_subject').html());
        jQuery('#dead_blogs_email_right .email_body').html(jQuery(this).find('.email_body').html());
    });

    jQuery('div#dead_blogs_email_left div.blog div.remove').click(
        function () { jQuery(this).parent().remove(); }
    );
});
</script>

<div class="wrap">
<?php screen_icon('ms-admin'); ?>
<h2><?php _e('Email Dead Site Owners (Confirm)')?></h2>

<div id="debug_handle" class="toggle_handle">
Debug
<div id="debug" class="toggle_content">
** $_REQUEST **
<?php echo var_dump($_REQUEST) ?>

** $blogs **
<?php foreach ($blogs as $blog):?>
<?php echo $blog['name'] ?>

<?php endforeach ?>
</div></div> <!-- /debug and /debug_handle -->

<form method="post">
    <input type="hidden" name="page" value="dead-blogs"/>
    <input type="hidden" name="mode" value="mail"/>
    <input type="hidden" name="confirmed" value="1"/>
    <?php foreach ($blogs as $blog):?>
    <input type="hidden" name="blog_ids[]" value="<?php echo $blog['id'] ?>"/>
    <?php endforeach ?>
    <input type="hidden" name="subject" value="<?php echo htmlspecialchars(stripslashes($_REQUEST['subject'])) ?>"/>
    <input type="hidden" name="body" value="<?php echo htmlspecialchars(stripslashes($_REQUEST['body'])) ?>"/>
    <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('dead_blogs_confirm_mail') ?>"/>

    <div id="dead_blogs_email_left">
        <h3>You are going to email Admins for the following blogs:</h3>
        <?php foreach ($blogs as $blog):?>
        <div class="blog">
            <a href="<?php echo $blog['url'] ?>"><?php echo $blog['name'] ?> (<?php echo $blog['path'] ?>)</a><br/>

            <ul>
                <?php foreach($blog['user_display_list'] as $user_label):?>
                <li><?php echo $user_label ?></li>
                <?php endforeach ?>
            </ul>

            <div class="remove">remove</div>

            <div class="email_to"><?php echo $blog['email_to'] ?></div>
            <div class="email_cc"><?php echo join("<br/>\n", $blog['email_cc']) ?></div>
            <div class="email_subject"><?php echo $blog['email_subject'] ?></div>
            <div class="email_body"><?php echo $blog['email_body'] ?></div>
        </div>
        <?php endforeach ?>
    </div>
    <div id="dead_blogs_email_right">
        <p>Hover over the recipients on the left to see what the email will look like when they receive it.</p>

        <p><b>Note:</b> In the case of multiple administrators for a blog, one will be emailed and the others CC'd.</p>

        <h3>To</h3>
        <div class="email_to"></div>
        <h3>CC</h3>
        <div class="email_cc"></div>
        <h3>Subject</h3>
        <div class="email_subject"></div>
        <h3>Body</h3>
        <div class="email_body"></div>
        <h3>Reply To</h3>
        <div class="email_replyto"><?php echo $_REQUEST['replyto'] ?></div>

        <input class="submit" type="submit" value="Really Send Email(s)"/>
    </div>
</form>

</div> <!-- /wrap -->
    <?
}

function dead_blogs_interface_mail_compose_output ()
{
    // get our list of blogs and their info
    $blogs = array();

    if (isset($_REQUEST['id']))
    {
        $blogs[] = _dead_blogs_get_blog_info($_REQUEST['id']);
    }
    elseif (isset($_REQUEST['allblogs']) and is_array($_REQUEST['allblogs']) and count($_REQUEST['allblogs']) > 0)
    {
        foreach ((array)$_REQUEST['allblogs'] as $blog_id)
        {
            $blogs[] = _dead_blogs_get_blog_info($blog_id);
        }
    }
    elseif (isset($_REQUEST['blog_ids']) and is_array($_REQUEST['blog_ids']) and count($_REQUEST['blog_ids']) > 0)
    {
        foreach ((array)$_REQUEST['blog_ids'] as $blog_id)
        {
            $blogs[] = _dead_blogs_get_blog_info($blog_id);
        }
    }

    // and the output...
    ?>

<link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url(__FILE__) ?>/dead_blogs.css"/>
<script type="text/javascript">
jQuery(window).load(function () {
    jQuery('.toggle_handle').click(function () {
        jQuery(this).find('.toggle_content').toggle();
    });

    jQuery('div#dead_blogs_email_left div.blog').hover(
        function () { jQuery(this).find('div.remove').show(); },
        function () { jQuery(this).find('div.remove').hide(); }
    );

    jQuery('div#dead_blogs_email_left div.blog div.remove').click(
        function () { jQuery(this).parent().remove(); }
    );
});
</script>

<div class="wrap">
<?php screen_icon('ms-admin'); ?>
<h2><?php _e('Email Dead Site Owners')?></h2>

<div id="debug_handle" class="toggle_handle">
Debug
<div id="debug" class="toggle_content">
** $_REQUEST **
<?php echo var_dump($_REQUEST) ?>
** Blogs **
<?php foreach ($blogs as $blog):?>
<?php echo var_dump($blog) ?>

**
<?php endforeach ?>
</div></div> <!-- /debug and /debug_handle -->

<form method="post">
    <input type="hidden" name="page" value="dead-blogs"/>
    <input type="hidden" name="mode" value="mail"/>

    <div id="dead_blogs_email_left">
        <h3>You are going to email Admins for the following blogs:</h3>
        <?php foreach ($blogs as $blog):?>
        <div class="blog">
            <input type="hidden" name="blog_ids[]" value="<?php echo $blog['id'] ?>"/>

            <a href="<?php echo $blog['url'] ?>"><?php echo $blog['name'] ?> (<?php echo $blog['path'] ?>)</a><br/>

            <ul>
                <?php foreach($blog['user_display_list'] as $user_label):?>
                <li><?php echo $user_label ?></li>
                <?php endforeach ?>
            </ul>

            <div class="remove">remove</div>
        </div>
        <?php endforeach ?>
    </div>
    <div id="dead_blogs_email_right">
        <h3>Substitutions:</h3>
        <p>Within this email, you may put various codes which will be replaced with the correct information respective to the blog owner being emailed.  For instance, you might put "$blogname" which will get replaced with the blog's name (presumably a different name for each email).  The substitutions are as follows:</p>

        <table>
            <tr><th>Code</th><th>Substitution</th></tr>
            <tr><th>$blogname</th><td>the blog's name</td></tr>
            <tr><th>$blogurl</th><td>the blog's url</td></tr>
            <tr><th>$adminname</th><td>the administrator's name</td></tr>
        </table>

        <h3 class="input_label">Subject</h3>
        <input class="subject" type="text" name="subject" value="Subject"/>
        <h3 class="input_label">Body</h3>
        <textarea class="body" name="body">Body</textarea>
        <h3 class="input_label">Reply To</h3>
        <input class="replyto" type="text" name="replyto" value=""/>
        <input class="submit" type="submit" value="Send Email(s)"/>
    </div>
</form>

</div>

    <?
}

?>
