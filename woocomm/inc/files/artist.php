<?php

function get_artist()
{
    $take = $_GET['g'];

    $args = [
        'posts_per_page' => -1,
        'post_type'   => 'eggless',
        'post_status' => 'publish',
        'order' => 'ASC',
        'tax_query' => array('relation' => 'AND')
    ];

    if ($take != '') {
        $take_args  = array(
            'taxonomy' => 'eggless-category',
            'field'    => 'term_id',
            'terms' => $take,
        );
        array_push($args['tax_query'], $take_args);
    }

    $myposts = new WP_Query($args);
    if (!empty($myposts)) {
        while ($myposts->have_posts()) {
            $myposts->the_post();
            include(__DIR__ . "/../widgets/inc/egs.php");
        }
        wp_reset_query();
    }
    if (!$myposts->have_posts()) {
    ?>
        <div class="no_data">
            <div class="title_30">No Category Found!</div>
        </div>
<?php
    }
}