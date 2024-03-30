<?php
get_header();
$term = get_queried_object();
if (!empty($term)) {
?>

    <?php if (get_field('catry_page_title', $term->taxonomy . '_' . $term->term_id)) { ?>
        <div class="tle"><?php echo get_field('catry_page_title', $term->taxonomy . '_' . $term->term_id); ?></div>
    <?php } ?>
    <div class="banner_egls">
        <div class="image">
            <div class="bg_full" style="background-image: url('<?php echo get_template_directory_uri() ?>/assets/images/scaled.jpg');"></div>
        </div>
    </div>
    <?php
    $eggless = get_field('egglezz_catgry', $term->taxonomy . '_' . $term->term_id);
    $args = array(
        'post_type' => 'eggless',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'order' => 'ASC',
        'tax_query' => array(
            array(
                'taxonomy' => 'eggless-category',
                'field' => 'id',
                'terms' => $eggless,
            ),
        ),
    );
    $tax_query = new WP_Query($args);
    if ($tax_query->have_posts()) {
    ?>
        <?php
        while ($tax_query->have_posts()) {
            $tax_query->the_post();
            $categories = get_the_terms(get_the_ID(), 'eggless-category');
            $event_category = !empty($categories) ? esc_html($categories[0]->name) : '';
        ?>
            <a href="<?php echo get_permalink(); ?>"><div class="egls_image"><?php echo get_the_post_thumbnail(); ?></a>
            <div><a href="<?php echo get_the_permalink($id); ?>" class="titles"><?php echo get_the_title(); ?></a></div>
            <div class="date"><?php echo get_the_date('F j, Y', $id); ?></div>
    <?php }
        wp_reset_query();
    } ?>
<?php
}?>