<?php
/*
 * Template Name: first
 */
get_header();
?>
<div class="ctry_1">This is Category 1</div>


<?php

$postId = 22;
$args = array(
    "fields" => "all",
    "order" => "ASC", //direction
    "orderby" => "name", //attribute to order by
);
$categoryObjects = wp_get_post_categories($postId, $args);
$tax_query = new WP_Query($args);


wp_reset_query();
?>