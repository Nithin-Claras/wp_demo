<?php
/*
 * Template Name: Eggless
 */
get_header();
?>

<div class="banner_egls">
    <div class="image">
        <div class="bg_full" style="background-image: url('<?php echo get_template_directory_uri() ?>/assets/images/c1.jpg');"></div>
    </div>
</div>
<div class="title_100">POST CATEGORY FILTER DEMO </div>
<div class="fltr">
    <?php
    $terms = get_terms(array(
        'taxonomy' => 'eggless-category',
        'hide_empty' => false,
        'parent' => 0
    ));
    ?>
    <div class="field_group">
        <?php if (!empty($terms)) { ?>
            <select class="field_control" id="disciplines">
                <option value="">Category</option>
                <?php foreach ($terms as $term) { ?>
                    <option value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                <?php } ?>
            </select>
        <?php } ?>
    </div>
    <div class="samp">
        <a class="filter_button">Filter</a>
    </div>
</div>
<?php $url_take = $_GET['g']; 
$cls_scroll = '';
if ($url_take != '') {
    $cls_scroll = 'filter_artist_scroll';
}
?>
<div class="fd" id='<?php echo $cls_scroll ?>'>
<?php get_artist(); ?>
</div>
<?php get_footer(); ?>