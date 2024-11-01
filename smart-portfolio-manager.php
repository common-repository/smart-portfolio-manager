<?php
/*
* Plugin Name: Smart Portfolio Manager - Product Catalog Listing
* Plugin URI: https://appaspectshop.com/
* Description: Fully Responsive and Mobile Friendly Portfolio for WordPress to showcase Your portfolio in Grid view.
* Author: AppAspect
* Version: 1.0.0
* Author URI: https://appaspect.com/
* Tag: resposive smart portfolio, smart portfolio, Custom Post Type, portfolio layout, grid layout portfolio, smart portfolio plugin, smart portfolio gallery, smart portfolio slider, responsive portfolio, portfolio showcase, wp portfolio
* Text Domain: smart-portfolio-manager
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
include_once(ABSPATH . 'wp-admin/includes/plugin.php');

define('SPMPCL_PLUGIN_VERSION', '1.0.0');

if (!defined('SPMPCL_PLUGIN_PATH')) {
    define('SPMPCL_PLUGIN_PATH', plugin_dir_url(__FILE__));
}

if (!defined('SPMPCL_POST_TYPE')) {
    define('SPMPCL_POST_TYPE', 'spmpcl_portfolio');
}

if (!defined('SPMPCL_POST_TAXONOMY')) {
    define('SPMPCL_POST_TAXONOMY', 'spmpcl_portfolio_category');
}

/*
* Hook 'init' action so that the function
*/
add_action('init', 'spmpcl_register_portfolio_custom_post_type', 0);

// Creating Custom Post Type
if (!function_exists('spmpcl_register_portfolio_custom_post_type')) {
    function spmpcl_register_portfolio_custom_post_type()
    {
        if (post_type_exists(SPMPCL_POST_TYPE)) {
            return;
        }

        $labels = array(
            'name'                => esc_html(_x('Portfolio', 'Post Type General Name', 'smart-portfolio-manager')),
            'singular_name'       => esc_html(_x('Portfolio', 'Post Type Singular Name', 'smart-portfolio-manager')),
            'menu_name'           => esc_html(__('Portfolio', 'smart-portfolio-manager')),
            'parent_item_colon'   => esc_html(__('Parent Portfolio', 'smart-portfolio-manager')),
            'all_items'           => esc_html(__('All Portfolio', 'smart-portfolio-manager')),
            'view_item'           => esc_html(__('View Portfolio', 'smart-portfolio-manager')),
            'add_new_item'        => esc_html(__('Add New Portfolio', 'smart-portfolio-manager')),
            'add_new'             => esc_html(__('Add New', 'smart-portfolio-manager')),
            'edit_item'           => esc_html(__('Edit Portfolio', 'smart-portfolio-manager')),
            'update_item'         => esc_html(__('Update Portfolio', 'smart-portfolio-manager')),
            'search_items'        => esc_html(__('Search Portfolio', 'smart-portfolio-manager')),
            'not_found'           => esc_html(__('Not Found', 'smart-portfolio-manager')),
            'not_found_in_trash'  => esc_html(__('Not found in Trash', 'smart-portfolio-manager')),
        );

        $args = array(
            'label'               => esc_html(__('Portfolio', 'smart-portfolio-manager')),
            'description'         => esc_html(__('Portfolio', 'smart-portfolio-manager')),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields',),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-portfolio',
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'           => true,
            'taxonomies'          => array(SPMPCL_POST_TAXONOMY),
        );

        // Registers a post type.
        register_post_type(SPMPCL_POST_TYPE, $args);

        // Creates or modifies a taxonomy object
        register_taxonomy(SPMPCL_POST_TAXONOMY, [SPMPCL_POST_TYPE], [
            'label'              => esc_html(__('Portfolio Category', 'smart-portfolio-manager')),
            'hierarchical'       => true,
            'rewrite'            => ['slug' => 'spmpcl-portfolio-category'],
            'show_admin_column'  => true,
            'show_in_rest'       => true,
            'show_ui'            => true,
            'query_var'          => true,
            'labels' => [
                'singular_name'     => esc_html(__('Portfolio Category', 'smart-portfolio-manager')),
                'all_items'         => esc_html(__('All Portfolio Categorys', 'smart-portfolio-manager')),
                'edit_item'         => esc_html(__('Edit Portfolio Category', 'smart-portfolio-manager')),
                'view_item'         => esc_html(__('View Portfolio Category', 'smart-portfolio-manager')),
                'update_item'       => esc_html(__('Update Portfolio Category', 'smart-portfolio-manager')),
                'add_new_item'      => esc_html(__('Add New Portfolio Category', 'smart-portfolio-manager')),
                'new_item_name'     => esc_html(__('New Portfolio Category Name', 'smart-portfolio-manager')),
                'search_items'      => esc_html(__('Search Portfolio Categorys', 'smart-portfolio-manager')),
                'parent_item'       => esc_html(__('Parent Portfolio Category', 'smart-portfolio-manager')),
                'parent_item_colon' => esc_html(__('Parent Portfolio Category:', 'smart-portfolio-manager')),
                'not_found'         => esc_html(__('No Genres found', 'smart-portfolio-manager')),
            ]
        ]);

        register_taxonomy_for_object_type(SPMPCL_POST_TAXONOMY, SPMPCL_POST_TYPE);
        flush_rewrite_rules();
    }
}

/**
 * Display a custom taxonomy dropdown filter post in admin
 */
add_action('restrict_manage_posts', 'spmpcl_filter_post_type_by_taxonomy');

if (!function_exists('spmpcl_filter_post_type_by_taxonomy')) {
    function spmpcl_filter_post_type_by_taxonomy()
    {
        global $typenow;

        $post_type = SPMPCL_POST_TYPE;
        $taxonomy  = SPMPCL_POST_TAXONOMY;

        if ($typenow == $post_type) {
            $selected      = isset($_GET[$taxonomy]) ? sanitize_text_field($_GET[$taxonomy]) : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => sprintf(esc_html(__('Show all %s', 'smart-portfolio-manager')), $info_taxonomy->label),
                'taxonomy'        => $taxonomy,
                'name'            => $taxonomy,
                'orderby'         => 'name',
                'selected'        => $selected,
                'show_count'      => true,
                'hide_empty'      => true,
            ));
        };
    }
}

/**
 * Filter posts by taxonomy in admin
 */
add_filter('parse_query', 'spmpcl_convert_id_to_term_in_query');

if (!function_exists('spmpcl_convert_id_to_term_in_query')) {
    function spmpcl_convert_id_to_term_in_query($query)
    {
        global $pagenow;

        $post_type = SPMPCL_POST_TYPE;
        $taxonomy  = SPMPCL_POST_TAXONOMY;
        $q_vars    = &$query->query_vars;

        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }
}

add_action('wp_enqueue_scripts', 'spmpcl_enqueue_style');
function spmpcl_enqueue_style()
{
    // script
    wp_register_script('spm-caurosel-min', SPMPCL_PLUGIN_PATH . 'jquery/spm-carousel.min.js', array('jquery'), '8.4.6', false);
    wp_register_script('spm-carousel-slider-script', SPMPCL_PLUGIN_PATH . 'jquery/spm-carousel-slider-script.js', array('jquery'), '1.0.0', true);
    wp_register_script('spm-lightbox-scripts', SPMPCL_PLUGIN_PATH . 'jquery/spm-lightbox.js', array('jquery'), '2.11.3', false);

    // style
    wp_enqueue_style('spm-carousel-themes', SPMPCL_PLUGIN_PATH . 'css/spm-swipwe.min.css', [], time(), 'screen');
    wp_enqueue_style('smart-portfolio-manager-css', SPMPCL_PLUGIN_PATH . 'css/spm-awesome-portfolio-styles.css', [], time(), 'screen');
    wp_register_style('spm-lightbox-css', SPMPCL_PLUGIN_PATH . 'css/spm-lightbox.min.css', [], time(), 'screen');
}

add_action('admin_enqueue_scripts', 'spmpcl_portfolio_enqueue_script');
function spmpcl_portfolio_enqueue_script()
{
    // script
    wp_register_script('spm-portfolio-admin-script', SPMPCL_PLUGIN_PATH . 'jquery/spm-portfolio-admin-script.js', array('jquery'), '1.0.0', true);
    wp_register_script('spm-multi-upload-medias-script', SPMPCL_PLUGIN_PATH . 'jquery/spm-multi-upload-medias-script.js', array('jquery'), '1.0.0', true);

    // style
    wp_enqueue_style('smart-portfolio-manager-admin-css', SPMPCL_PLUGIN_PATH . 'css/spm-awesome-portfolio-admin-styles.css', [], time(), 'screen');
}

require plugin_dir_path(__FILE__) . 'includes/spm-portfolio-manager-meta.php';
require plugin_dir_path(__FILE__) . 'includes/spm-shortcode-portfolio.php';
require plugin_dir_path(__FILE__) . 'includes/spm-howto_use-refreance.php';

add_filter('single_template', 'spmpcl_portdolio_single_template');
if (!function_exists('spmpcl_portdolio_single_template')) {
    function spmpcl_portdolio_single_template($single_template)
    {
        global $post;

        $file = dirname(__FILE__) . '/templates/single-' . $post->post_type . '.php';

        if (file_exists($file) && get_post_type($post) == SPMPCL_POST_TYPE) {
            $single_template = $file;
        }
        return $single_template;
    }
}

add_filter('archive_template', 'spmpcl_custom_post_type_archive_template');
if (!function_exists('spmpcl_custom_post_type_archive_template')) {
    function spmpcl_custom_post_type_archive_template($archive_template)
    {
        global $post;
        $plugin_root_dir = dirname(__FILE__) . '/templates/archive-' . $post->post_type . '.php';

        if (is_archive() && get_post_type($post) == SPMPCL_POST_TYPE) {
            $archive_template = $plugin_root_dir;
        }
        return $archive_template;
    }
}
