<?php
/*
 * Template Name: New Filter
 */
get_header();
?>

<div class="filter-custom-taxonomy-category">
    <?php
  
    $categories = get_terms(array(
        'taxonomy' => 'eggless-category',
        'hide_empty' => false,
        'parent' => 0
    ));?> 
    
    <!-- <a href="<?php echo get_site_url() ?>/" class="reset_btn">All</a> -->
     <?php

    foreach ($categories as $cat) :

        $eggless = new WP_Query(
            array(
                'post_type' => 'eggless',
                'showposts' => -1,
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy'  => 'eggless-category',
                        'terms'     => array($cat->slug),
                        'field'     => 'slug',
                    )
                )
            )
        ); ?>
        <a class="ftr" href="<?php echo $f=$cat->term_id?>">
            <?php echo ( $f=$cat->name);
             ?>   
        </a>

    <?php
    endforeach;
    ?>
</div>
<?php $url_take = $_GET['g'];
$cls_scroll = '';
if ($url_take != '') {
    $cls_scroll = 'filter_artist_scroll';
}
?>
<div class="fd" id='<?php echo $cls_scroll ?>'>
    <?php get_artist(); ?>
    <?php get_footer(); ?>