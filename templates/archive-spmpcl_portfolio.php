<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

$query = new WP_Query(
    array(
        'post_type' => SPMPCL_POST_TYPE,
        'posts_per_page' => -1
    )
);
?>
<div class="spm-primary">
    <div class="spmpcl_ajax_post_grid_wrap">
        <div class="asr-ajax-container">
            <div class="asrafp-filter-result">
                <div class="spmpcl_post_grid spmpcl__col-3 spmpcl_layout_1">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="spmpcl_grid_col">
                            <div class="spmpcl_single_grid">
                                <div class="spmpcl_thumb">
                                    <?php the_post_thumbnail('full'); ?>
                                </div>
                                <div class="spmpcl_cont">
                                    <a href="<?php echo esc_attr(get_the_permalink()); ?>">
                                        <h2 class="spmpcl__title"><?php echo esc_attr(get_the_title()); ?></h2>
                                    </a>
                                    <div class="spmpcl__excerpt">
                                        <?php echo esc_attr(wp_trim_words(get_the_excerpt(), 15, null)); ?>
                                    </div>
                                    <a href="<?php echo esc_attr(get_the_permalink()); ?>" class="spm-readmore"><?php echo esc_html__('Read More »', 'smart-portfolio-manager'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>