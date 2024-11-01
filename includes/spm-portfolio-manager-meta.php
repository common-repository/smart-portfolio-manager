<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/* Fire meta box setup function on the portfolio editor screen. */

add_action('load-post.php', 'spmpcl_post_meta_boxes_setup');
add_action('load-post-new.php', 'spmpcl_post_meta_boxes_setup');

/* Meta box setup function. */
function spmpcl_post_meta_boxes_setup()
{
    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action('add_meta_boxes', 'spmpcl_android_project_url_meta_box');

    /* Save post meta on the 'save_post' hook. */
    add_action('save_post_spmpcl_portfolio', 'spmpcl_save_project_url_meta_value', 10, 2);
}

/*
1. Meta Box for Project URL (Android and iOS)
*/
// add meta box for links
function spmpcl_android_project_url_meta_box()
{
    add_meta_box(
        'android_project_url',
        'Project URL (Play Store and Apps Store)',
        'spmpcl_android_project_url_meta_box_fields',
        SPMPCL_POST_TYPE,
        'normal',
        'high'
    );

    add_meta_box(
        'portfolio_extra_meta',
        'Portfolio Extra Field',
        'spmpcl_portfolio_extra_meta_box_fields',
        SPMPCL_POST_TYPE,
        'normal',
        'high'
    );

    add_meta_box(
        'ash_porfolio_image_box',
        'Portfolio Images',
        'spmpcl_portfolio_media_upload_meta_box_field',
        SPMPCL_POST_TYPE,
        'normal',
        'high'
    );

    add_meta_box(
        'spmpcl_portfolio_feature_box',
        esc_html(__('App Features', 'myplugin_textdomain')),
        'spmpcl_dynamic_portfolio_feature_box',
        SPMPCL_POST_TYPE,
        'normal',
        'high'
    );
}

//add meta box fields

function spmpcl_portfolio_extra_meta_box_fields($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'spmpcl_portfolio_meta_box_nonce');
?>
    <table class="form-table" role="presentation">
        <tbody>
            <tr class="user-first-name-wrap">
                <th><label for="languages"><?php esc_html_e("Languages", 'smart-portfolio-manager'); ?></label></th>
                <td><input class="regular-text" type="text" name="technology_language" required="required" id="technology_language" placeholder="PHP, Laravel, React Js" value="<?php echo esc_attr(get_post_meta($post->ID, 'technology_language', true)); ?>" size="30" /></td>
            </tr>

            <tr class="user-first-name-wrap">
                <th><label for="client_name"><?php esc_html_e("Client Name", 'smart-portfolio-manager'); ?></label></th>
                <td><input class="regular-text" type="text" name="portfolio_client_name" id="portfolio_client_name" placeholder="client name" value="<?php echo esc_attr(get_post_meta($post->ID, 'portfolio_client_name', true)); ?>" size="30" /></td>
            </tr>
        </tbody>
    </table>
<?php
}

function spmpcl_android_project_url_meta_box_fields($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'spmpcl_portfolio_meta_box_nonce');
    wp_enqueue_script('spm-portfolio-admin-script');
    wp_enqueue_script('spm-multi-upload-medias-script');
?>

    <table class="form-table" role="presentation">
        <tbody>
            <tr class="user-first-name-wrap">
                <th><label for="portfolio_type"><?php esc_html_e("Portfolio Type", 'appaspect') ?></label></th>
                <td>
                    <select name="portfolio_project_type" id="application_portfolio_type" onchange="HandleProfilioType(this.value);">
                        <option value="application" <?php selected(get_post_meta($post->ID, 'portfolio_project_type', true), "application"); ?>>Application</option>
                        <option value="website" <?php selected(get_post_meta($post->ID, 'portfolio_project_type', true)); ?>>Website</option>
                    </select>
                </td>
            </tr>
            <tr class="user-first-name-wrap" id="spmpcl_app_portfolio">
                <th><label for="project_url"><?php esc_html_e("Anroid Play Store URL", 'smart-portfolio-manager'); ?></label></th>
                <td><input class="regular-text" type="text" name="android_project_url" id="android_project_url" placeholder="Enter Anroid Play Store URL" value="<?php echo esc_url(get_post_meta($post->ID, 'android_project_url', true)); ?>" size="30" /></td>
            </tr>

            <tr class="user-first-name-wrap" id="spmpcl_ios_portfolio">
                <th><label for="project_url"><?php esc_html_e("iOS Apps Store URL", 'smart-portfolio-manager'); ?></label></th>
                <td><input class="regular-text" type="text" name="ios_project_url" id="ios_project_url" placeholder="Enter iOS Apps Store URL" value="<?php echo esc_url(get_post_meta($post->ID, 'ios_project_url', true)); ?>" size="30" /></td>
            </tr>

            <tr class="user-first-name-wrap" id="portfolio_website_url">
                <th><label for="website_url"><?php esc_html_e("Website URL", 'smart-portfolio-manager'); ?></label></th>
                <td><input class="regular-text" type="text" name="website_project_url" id="website_project_url" placeholder="Enter Website URL" value="<?php echo esc_url(get_post_meta($post->ID, 'website_project_url', true)); ?>" size="30" /></td>
            </tr>

        </tbody>
    </table>
<?php
}

function spmpcl_portfolio_media_upload_meta_box_field($post)
{
    wp_nonce_field(plugin_basename(__FILE__), 'spmpcl_portfolio_meta_box_nonce');
    $banner_img = get_post_meta($post->ID, 'spmpcl_project_portfolio_img', true);
?>

    <table cellspacing="10" cellpadding="10">
        <tr>
            <td>These images can be shown using the "Project Images Slider" module.</td><br />
        </tr>
        <tr>
            <td>
                <?php echo spmpcl_multi_media_uploader_field('spmpcl_project_portfolio_img', esc_html($banner_img)); ?>
            </td>
        </tr>
    </table>

<?php
}

function spmpcl_multi_media_uploader_field($name, $value = '')
{
    $image      = '">Add Media';
    $image_str  = '';
    $image_size = 'full';
    $display    = 'none';
    $value      = explode(',', $value);

    if (!empty($value)) {
        foreach ($value as $values) {
            if ($image_attributes = wp_get_attachment_image_src($values, $image_size)) {
                $image_str .= '<li data-attechment-id=' . esc_html($values) . '><a href="' . esc_url($image_attributes[0]) . '" target="_blank"><img src="' . esc_url($image_attributes[0]) . '" /></a><i class="dashicons dashicons-no delete-img"></i></li>';
            }
        }
    }

    if ($image_str) {
        $display = 'inline-block';
    }

    return '<div class="spm-multi-upload-medias"><ul>' . $image_str . '</ul><a href="#" style="margin-right:10px" class="spm-wc_multi_upload_image_button button button-primary' . $image . '</a><input type="hidden" class="attechments-ids ' . $name . '" name="' . $name . '" id="' . $name . '" value="' . esc_attr(implode(',', $value)) . '" /><a href="#" class="spmpcl_wc_multi_remove_image_button button" style="display:inline-block;display:' . $display . '">Remove media</a></div>';
}

/* Prints the box content */
function spmpcl_dynamic_portfolio_feature_box()
{
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'spmpcl_portfolio_meta_box_nonce');
?>
    <div id="meta_inner">
        <?php
        //get the saved meta as an array
        $feature = get_post_meta($post->ID, 'spmpcl_portfolio_feature', true);

        $c = 0;
        if ($feature && count($feature) > 0) {
            foreach ($feature as $features) {
                if (isset($features['title']) || isset($features['description'])) {
                    printf('
				<p>
					<b><label for="feature_title">Title:</label></b> 
					<input class="regular-text" type="text" name="spmpcl_portfolio_feature[%1$s][title]" value="%2$s" required="required" />
					<b><label for="feature_desc">Description:</label></b> 
					<input class="regular-text" type="text" name="spmpcl_portfolio_feature[%1$s][description]" value="%3$s" required="required" />
					<span class="remove-feature-app button"><span class="dashicons dashicons-trash"></span>%4$s</span></p>', esc_html($c), esc_html($features['title']), esc_html($features['description']), esc_html(__('Remove Feature', 'smart-portfolio-manager')));
                    $c = $c + 1;
                }
            }
        }

        ?>
        <span id="append-spm-feature"></span>
        <span class="spm-add-feature button button-primary"><?php esc_html_e('Add Feature'); ?></span>

        <script>
            var $ = jQuery.noConflict();
            $(document).ready(function() {
                var count = <?php echo esc_js($c); ?>;
                $(".spm-add-feature").click(function() {
                    count = count + 1;
                    $('#append-spm-feature').append('<p> <b><label for="feature_title">Title: </label></b> <input class="regular-text" type="text" name="spmpcl_portfolio_feature[' + count + '][title]" value="" required="required" /> <b><label for="feature_desc">Description: </label></b> <input class="regular-text" type="text" name="spmpcl_portfolio_feature[' + count + '][description]" value="" required="required" /><span class="remove-feature-app button"><span class="dashicons dashicons-trash"></span>Remove Feature</span></p>');
                    return false;
                });
                // The live() method was deprecated in jQuery version 1.7, and removed in version 1.9. Use the on() method instead.
                $(document).on('click', '.remove-feature-app', function() {
                    $(this).parent().remove();
                });
            });
        </script>
    </div>
<?php
}

function spmpcl_save_project_url_meta_value($post_id, $post)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // print_r(json_encode($_POST['spmpcl_portfolio_feature'])); exit();
    // print_r($_POST['spmpcl_portfolio_feature']); exit();

    /* Verify the nonce before proceeding. */
    if (isset($_REQUEST['spmpcl_portfolio_meta_box_nonce'])) {
        if (!wp_verify_nonce(sanitize_text_field($_POST['spmpcl_portfolio_meta_box_nonce']), plugin_basename(__FILE__))) {
            return;
        }
    } else {
        return;
    }

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id)) {
        return $post_id;
    }

    if (isset($_POST['portfolio_project_type'])) {
        update_post_meta($post_id, 'portfolio_project_type', sanitize_text_field($_POST['portfolio_project_type']));
    }

    if (isset($_POST['android_project_url'])) {
        update_post_meta($post_id, 'android_project_url', sanitize_url($_POST['android_project_url']));
    }
    if ($_POST['android_project_url'] == null) {
        delete_post_meta($post_id, 'android_project_url', sanitize_url($_POST['android_project_url']));
    }

    if (isset($_POST['ios_project_url'])) {
        update_post_meta($post_id, 'ios_project_url', sanitize_url($_POST['ios_project_url']));
    }
    if ($_POST['ios_project_url'] == null) {
        delete_post_meta($post_id, 'ios_project_url', sanitize_url($_POST['ios_project_url']));
    }

    if (isset($_POST['website_project_url'])) {
        update_post_meta($post_id, 'website_project_url', sanitize_url($_POST['website_project_url']));
    }
    if ($_POST['website_project_url'] == null) {
        delete_post_meta($post_id, 'website_project_url', sanitize_url($_POST['website_project_url']));
    }

    if (isset($_POST['technology_language'])) {
        update_post_meta($post_id, 'technology_language', sanitize_text_field($_POST['technology_language']));
    }
    if ($_POST['technology_language'] == null) {
        delete_post_meta($post_id, 'technology_language', sanitize_text_field($_POST['technology_language']));
    }

    if (isset($_POST['portfolio_client_name'])) {
        update_post_meta($post_id, 'portfolio_client_name', sanitize_text_field($_POST['portfolio_client_name']));
    }
    if ($_POST['portfolio_client_name'] == null) {
        delete_post_meta($post_id, 'portfolio_client_name', sanitize_text_field($_POST['portfolio_client_name']));
    }

    if (isset($_POST['spmpcl_project_portfolio_img'])) {
        update_post_meta($post_id, 'spmpcl_project_portfolio_img', sanitize_text_field($_POST['spmpcl_project_portfolio_img']));
    }
    if ($_POST['spmpcl_project_portfolio_img'] == null) {
        delete_post_meta($post_id, 'spmpcl_project_portfolio_img', sanitize_text_field($_POST['spmpcl_project_portfolio_img']));
    }

    if (isset($_POST['spmpcl_portfolio_feature'])) {
        update_post_meta($post_id, 'spmpcl_portfolio_feature', map_deep( $_POST['spmpcl_portfolio_feature'], 'sanitize_text_field' ));
    } else {
        delete_post_meta($post_id, 'spmpcl_portfolio_feature');
    }
}


