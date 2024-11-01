<?php

/**
 * Uninstall Smart Portfolio Manager
 *
 * Uninstalling Smart Portfolio Manager Post, Postmeta, Taxonomy.
 *
 * @version 1.0.0
 */

defined('WP_UNINSTALL_PLUGIN') || exit;

if (!defined('SPMPCL_POST_TYPE')) {
    define('SPMPCL_POST_TYPE', 'spmpcl_portfolio');
}

global $wpdb;

$wpdb->query( $wpdb->prepare( "DELETE p, pm FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta pm ON pm.post_id = p.ID WHERE p.post_type = %s", SPMPCL_POST_TYPE ) );

$results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy LIKE 'spmpcl_portfolio_category'", ARRAY_A);

foreach ($results as $row) {
    $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}terms WHERE term_id = %s", $row['term_id'] ) );
    $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}term_relationships WHERE term_taxonomy_id = %s", $row['term_taxonomy_id'] ) );
}

$wpdb->query("DELETE FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy LIKE 'spmpcl_portfolio_category'");

wp_cache_flush();
