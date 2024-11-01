<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('admin_menu', 'spmpcl_shortcode_configration_submenu_page');

function spmpcl_shortcode_configration_submenu_page()
{
    add_submenu_page(
        'edit.php?post_type=spmpcl_portfolio',
        'shortcode configuration',
        'Shortcode Configuration',
        'manage_options',
        'shortcode_configuration',
        'spmpcl_shortcode_configuration_callback',
    );
}

function spmpcl_shortcode_configuration_callback()
{
    echo wp_kses_post("<h1>Shortcode Configuration</h1>");
?>
    <br />
    <div class="shortcode_configuration">

        <ol>
            <h3>
                <li><?php esc_html_e("Default Shortcode", 'smart-portfolio-manager'); ?></li>
            </h3>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid]</pre>
            </p>

            <h3>
                <li><?php esc_html_e("Control Number of Portfolio Per Page", 'smart-portfolio-manager'); ?></li>
            </h3>
            <p class="spm-shortcode_style">Options: -1 for all Portfolio</p>
            <p class="spm-shortcode_style">Default: 10 Portfolio</p>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid posts_per_page="6"]</pre>
            </p>

            <h3>
                <li><?php esc_html_e("Show/Hide Specific Category Terms", 'smart-portfolio-manager'); ?></li>
            </h3>
            <p class="spm-shortcode_style">Options: 1,2,3,4 (Comma Seprate ID)</p>
            <p class="spm-shortcode_style">Default: ""</p>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid category="10,20,30,40"]</pre>
            </p>
            <p>OR</p>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid terms="101,201,301,401"]</pre>
            </p>

            <h3>
                <li><?php esc_html_e("Post Order", 'smart-portfolio-manager'); ?></li>
            </h3>
            <p class="spm-shortcode_style">Options: ASC, DESC</p>
            <p class="spm-shortcode_style">Default: DESC</p>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid order="DESC"]</pre>
            </p>

            <h3>
                <li><?php esc_html_e("Post Orderby", 'smart-portfolio-manager'); ?></li>
            </h3>
            <p class="spm-shortcode_style">Options: menu_order, ID, title (for more info <a href="https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters" target="_blank">Visit Official Document</a></p>
            <p class="spm-shortcode_style">Default: menu_order</p>
            <p>
            <pre class="spm-shorcode_design">[spmpcl_post_grid orderby="menu_order"]</pre>
            </p>
        </ol>

    </div>
<?php
    return;
}
