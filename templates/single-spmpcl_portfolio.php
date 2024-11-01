<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();

$id = get_the_ID();

$android_url      = get_post_meta($id, 'android_project_url', true);
$ios_url          = get_post_meta($id, 'ios_project_url', true);
$website_url      = get_post_meta($id, 'website_project_url', true);
$technology_tools = get_post_meta($id, 'technology_language', true);
$client_name      = get_post_meta($id, 'portfolio_client_name', true);
$application_type = get_post_meta($id, 'portfolio_project_type', true);

$banner_img = get_post_meta($id, 'spmpcl_project_portfolio_img', true);
$feature    = get_post_meta($id, 'spmpcl_portfolio_feature', true);
$categories = get_the_terms($id, SPMPCL_POST_TAXONOMY);

wp_enqueue_style('spm-lightbox-css');
wp_enqueue_style('spm-carousel-themes');

wp_enqueue_script('spm-caurosel-min');
wp_enqueue_script('spm-carousel-slider-script');
wp_enqueue_script('spm-lightbox-scripts');

?>
    <div class="wp-spm-container">
        <div class="wp-spm-first-section">
            <?php
            if (has_post_thumbnail($id)) :
                echo wp_kses_post(get_the_post_thumbnail($id, 'full'));
            endif;
            ?>
            <div class="wp-spm-content wp-spm-content-details">
                    <?php if ($categories) {
                        foreach ($categories as $cd) {
                            echo wp_kses_post('<span class="wp-spm-category-name">' . $cd->name . '</span>');
                        }
                    } ?>
              <h1><?php echo esc_attr(get_the_title()); ?></h1>
              <p><?php echo wp_kses_post(get_the_content()); ?></p>
                <?php
                if (!empty($technology_tools)) {
                    echo wp_kses_post("<p class='wp-spm-tech-details'><strong>Technology: </strong>" . $technology_tools . "</p>");
                }
                if (!empty($client_name)) {
                    echo wp_kses_post("<p class='wp-spm-tech-details'><strong>Client: </strong>" . $client_name . "</p>");
                } ?>
              <div class="wp-spm-link-btn">
                    <?php if ($application_type == "application") {
                        if (!empty($android_url)) {
                            echo wp_kses_post(sprintf('<a href="%s" target="_blank"><img src="%s" alt="android app url"></a>', esc_url($android_url), plugin_dir_url(__DIR__) . 'images/googleplay-e1580102567906.png'));
                        }
                        if (!empty($ios_url)) {
                            echo wp_kses_post(sprintf('<a href="%s" target="_blank"><img src="%s" alt="iOS app url"></a>', esc_url($ios_url), plugin_dir_url(__DIR__) . 'images/appstore-e1580102545311.png'));
                        }
                    } else {
                        if (!empty($website_url)) {
                            echo wp_kses_post("<a class='spm-readmore' href=" . esc_url($website_url) . " target='_blank'>View Website >></a>");
                        }
                    } ?>
              </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Feature Section -->
    <?php if ($feature) : ?>
    <div class="wp-spm-container">
        <div class="wp-spm-section-title">
            <h1><?php esc_html_e("App Features", 'smart-portfolio-manager'); ?></h1>
            <h4>Below are the some of the major features inside the app, check it out for more information</h4>
        </div>
        <div class="wp-spm-grid-container wp-spm-first-section">
            <?php
            foreach ($feature as $key => $features) { ?>
            <?php if ($features['title'] && $features['description']) : ?>
            <div class="wp-spm-grid-item">
                <div class="wp-spm-content wp-spm-expand-collaps">
                  <button class="wp-spm-collapsible"><?php echo esc_attr($features['title']); ?></button>
                    <div class="wp-spm-content">
                      <p><?php echo esc_attr($features['description']); ?></p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php } ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($banner_img)) {
        $banner_img = explode(',', $banner_img); ?>
        <div class="wp-spm-container">
            <div class="wp-spm-section-title">
                <h1><?php esc_html_e("App Screenshots", 'smart-portfolio-manager'); ?></h1>
              </div>
            <div class="swiper spm-portfolio-gallary">
                <div class="swiper-wrapper">
                    <?php
                    foreach ($banner_img as $attachment_id) { ?>
                        <div class="swiper-slide">
                            <a class="demo" href="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>" data-lightbox="gallery">
                                <img class="img" src="<?php echo esc_url(wp_get_attachment_url($attachment_id)); ?>" alt="">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    <?php } ?>
    
<?php get_footer(); ?>