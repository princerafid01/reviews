<?php

/**
 * Trigger This file on plugin uninstall
 * 
 * @package RafidoPlugin
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die();
}

// Clear Database Stored data
// $books = get_post([
//     'post_type' => 'book',
//     'numberposts' =>  -1
// ]);

// foreach ($books as $book) {
//     wp_delete_post($book->ID , true);
// }


// Access The database via Sql
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type='book'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id from wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id from wp_posts)");