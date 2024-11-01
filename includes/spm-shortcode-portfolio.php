<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_shortcode('spmpcl_post_grid', 'spmpcl_post_grid_shortcode');
add_filter('the_content', 'spmpcl_portfolio_fix_empty_paragraph');

if (!function_exists('spmpcl_post_grid_shortcode')) {
    function spmpcl_post_grid_shortcode($atts, $content = null)
    {
        $per_page = (get_option('posts_per_page', true)) ? get_option('posts_per_page', true) : 9;

        // Shortcode attr
        $shortcode_attributes = shortcode_atts(
            array(
                'initial'         => "-1",
                'post_type'       => SPMPCL_POST_TYPE,
                'posts_per_page'  => $per_page,
                'category'        => '',
                'terms'           => '',
                'orderby'         => 'menu_order date',
                'order'           => 'DESC',
            ),
            $atts
        );

        extract($shortcode_attributes);
        ob_start();
?>
        <div class="spmpcl_ajax_post_grid_wrap" data-ajax_post_grid='<?php echo esc_attr(json_encode($shortcode_attributes)); ?>'>
            <div class="spm-ajax-container">
                <div class="spm-filter-result">
                    <?php
                    return spmpcl_grid_data_display_output(spmpcl_grid_data_aeguments_shortcode($shortcode_attributes)); ?>
                </div>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }
}

// Get Args from Json Data
function spmpcl_grid_data_aeguments_shortcode($shortcode_json)
{
    if (isset($shortcode_json['posts_per_page'])) {
        $data['posts_per_page'] = intval($shortcode_json['posts_per_page']);
    }

    if (isset($shortcode_json['orderby'])) {
        $data['orderby'] = sanitize_text_field($shortcode_json['orderby']);
    }

    if (isset($shortcode_json['order'])) {
        $data['order'] = sanitize_text_field($shortcode_json['order']);
    }

    // Category Bind convert string to array
    $terms = '';
    if (isset($shortcode_json['category']) && !empty($shortcode_json['category'])) {
        $terms = explode(',', $shortcode_json['category']);
    } elseif (isset($shortcode_json['terms']) && !empty($shortcode_json['terms'])) {
        $terms = explode(',', $shortcode_json['terms']);
    }

    /*
    * Tax Query tax_query
    * array()
    */
    if (!empty($terms)) {
        $data['tax_query'] = [
            SPMPCL_POST_TAXONOMY => $terms,
        ];
    }
    return $data;
}

/*
*   Grid View Design Layout
*   args array()
*/
function spmpcl_grid_data_display_output($args = [])
{
    // Merges user defined arguments into defaults array.
    $args = wp_parse_args($args, [
        'post_type'       => SPMPCL_POST_TYPE,
        'post_status'     => 'publish',
        'paged'           => get_query_var('paged') ? get_query_var('paged') : 1, // retrieves value from query variable
        'posts_per_page'  => '',
        'orderby'         => '',
        'order'           => '',
        'tax_query' => [
            SPMPCL_POST_TAXONOMY => []
        ],
    ]);

    // Post Query Args
    $query_args = array(
        'post_type'   => SPMPCL_POST_TYPE,
        'post_status' => 'publish',
        'paged'       => $args['paged'],
    );

    // If json data found
    if (!empty($args['posts_per_page'])) {
        $query_args['posts_per_page'] = intval($args['posts_per_page']);
    }

    if (!empty($args['orderby'])) {
        $query_args['orderby'] = sanitize_text_field($args['orderby']);
    }

    if (!empty($args['order'])) {
        $query_args['order'] = sanitize_text_field($args['order']);
    }

    // Tax Query Var
    $tax_query = [];

    // Check tax query
    if (!empty($args['tax_query']) && is_array($args['tax_query'])) {
        foreach ($args['tax_query'] as $taxonomy => $terms) {
            if (!empty($terms)) {
                $tax_query[] = [
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ];
            }
        }
    }

    // Tax Query
    if (!empty($tax_query)) {
        $query_args['tax_query'] = $tax_query;
    }

    //post query
    $query = new WP_Query($query_args);

    if ($query->have_posts()) : ?>

        <div class="<?php echo esc_attr("spmpcl_post_grid spmpcl__col-3 spmpcl_design_layout_1"); ?>" data-args='<?php echo esc_attr(json_encode($args)); ?>'>

            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="spmpcl_grid_col">
                    <div class="spmpcl_single_grid">
                        <div class="spmpcl_thumb">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                        <div class="spmpcl_cont">
                            <h2 class="post-title wp-spm-title"><a href="<?php echo esc_attr(get_the_permalink()); ?>">
                                <?php echo esc_attr(get_the_title()); ?>
                            </a></h2>
                            <div class="spmpcl__excerpt">
                                <?php echo esc_attr(wp_trim_words(get_the_excerpt(), 15, null)); ?>
                            </div>
                            <a href="<?php echo esc_attr(get_the_permalink()); ?>" class="spm-readmore"><?php echo esc_html__('Read More »', 'smart-portfolio-manager'); ?></a>
                        </div>
                    </div>
                </div>
            <?php
            endwhile;
            ?>
        </div>
<?php
    else :
        esc_html_e('No Portfolio Found', 'smart-portfolio-manager');
    endif;
    wp_reset_query();
    return ob_get_clean();
}

function spmpcl_portfolio_fix_empty_paragraph($content)
{
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr($content, $array);
}
