<?php

function get_event_ajax($cat_id = 0) {

	if (filter_input(INPUT_POST, 'limit')) {
		$limit = filter_input(INPUT_POST, 'limit');
	} else {
		$limit = 0;
	}

	if (filter_input(INPUT_POST, 'cat_id')) {
		$cat_id = filter_input(INPUT_POST, 'cat_id');
	}

	$ids = [];
	if (filter_input(INPUT_POST, 'search_text') != "") {
		global $wpdb;
		$yourPostTitle = strtoupper(filter_input(INPUT_POST, 'search_text'));
		$ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE UCASE(post_title) LIKE '%$yourPostTitle%' AND post_type = 'event' AND post_status='publish'");
	}

	$year = '';
	if (filter_input(INPUT_POST, 'year')) {
		$year = filter_input(INPUT_POST, 'year');
	}

	$country = '';
	if (filter_input(INPUT_POST, 'country')) {
		$country = filter_input(INPUT_POST, 'country');
	}

	$MetaQuery = [
        'relation' => 'AND'
    ];

    if (empty($year)) {
	    $today = date('Ymd');
	    $datewise = array(
	        'key'     => 'event_single_start_date',
	        'value'   => $today,
	        'compare' => '>=',
	    );
	    array_push($MetaQuery, $datewise);
	}

    if (!empty($country)) {
        $countries = array(
            'key'     => 'event_single_country',
            'value'   => $country,
            'compare' => '=',
        );
        array_push($MetaQuery, $countries);
    }

    if (!empty($year)) {
        $years = array(
        	'relation' => 'OR',
        	array(
	            'key'     => 'event_single_start_date',
	            'value'   => $year,
	            'compare' => 'LIKE'
	        ),
	        array(
	            'key'     => 'event_single_end_date',
	            'value'   => $year,
	            'compare' => 'LIKE'
	        )
        );
        array_push($MetaQuery, $years);
    }
	
	$args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => 6,
		'offset' => $limit,
        'meta_key' => 'event_single_start_date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
        'meta_query' => $MetaQuery,
        'tax_query' => array('relation' => 'AND')
    );

	if(!empty($ids)) {
		$args['post__in'] = $ids;
	}

	if ($cat_id != 0) {
        $newty = array(
            'taxonomy' => 'disciplines-category',
            'field' => 'term_id',
            'terms' => $cat_id
        );
        array_push($args['tax_query'], $newty);
    }

    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
    	while ($loop->have_posts()) {
            $loop->the_post();
            $img_id = get_post_thumbnail_id(get_the_ID());
            $mypost = get_post($post->ID);
			$txt = apply_filters('the_content', $mypost->post_content);

			$start_d = '';
			$start_datemonth = '';
			if(get_field('event_single_start_date')) {
				$start_date = get_field('event_single_start_date');
				$start_d = date('d', strtotime($start_date));
				$start_datemonth = date('M', strtotime($start_date));
			}

			$end_d = '';
			$end_datemonth = '';
			if(get_field('event_single_end_date')) {
				$end_date = get_field('event_single_end_date');
				$end_d = date('d', strtotime($end_date));
				$end_datemonth = date('M', strtotime($end_date));
			}
			
            ?>
            <div class="filter_block">
                <div class="_row">
                    <div class="_col">
                        <?php if($img_id > 0) { ?>
                            <div class="image">
                                <?php image_on_fly($img_id, array(1920, 'auto'), false); ?>
                            </div>
                        <?php } else { ?>
                            <div class="image">
                                <div class="bg_full" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/placeholder.png')"></div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="_col">
                        <div class="fil_title"><?php echo get_the_title(get_the_ID()); ?></div>
                        <div class="fil_flag">
                        	<?php if(get_field('event_single_flag')) { ?>
                        		<img src="<?php echo get_field('event_single_flag') ?>" alt="" />
                        	<?php } ?>
                        	<?php if(get_field('event_single_city') || get_field('event_single_country')) { ?>
                        		<span><?php echo get_field('event_single_city') ?> • <?php echo get_field('event_single_country') ?></span>
                        	<?php } ?>
                        </div>
                        <?php if ($txt) { ?>
                        	<div class="fil_desc"><?php echo $txt; ?></div>
                        <?php } ?>
                    </div>
                    <div class="_col">
                    	<?php if($start_d && $start_datemonth) { ?>
	                        <div class="date_month">
	                            <div class="d"><?php echo $start_d; ?></div>
	                            <div class="m"><?php echo $start_datemonth; ?></div>
	                        </div>
	                    <?php } ?>
	                    <?php if($end_d && $end_datemonth) { ?>
	                        <div class="date_month">
	                            <div class="d"><?php echo $end_d; ?></div>
	                            <div class="m"><?php echo $end_datemonth; ?></div>
	                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
          	<?php
    	} wp_reset_postdata();
    }
}
add_action("wp_ajax_get_event_ajax", "get_event_ajax");
add_action("wp_ajax_nopriv_get_event_ajax", "get_event_ajax");


function get_event_year_country() {
	
	$args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC'
    );

    $country = [];
    $year = [];

    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
    	while ($loop->have_posts()) {
            $loop->the_post();

            if(get_field('event_single_start_date')) {
				$start_date = get_field('event_single_start_date');
				$start_year = date('Y', strtotime($start_date));
				$year[$start_year] = $start_year;
			}

			if(get_field('event_single_end_date')) {
				$end_date = get_field('event_single_end_date');
				$end_year = date('Y', strtotime($end_date));
				$year[$end_year] = $end_year;
			}

            $country[get_field('event_single_country')] = get_field('event_single_country');

        } wp_reset_postdata();
    }

    ksort($year);

    $arr = [
    	'country' => $country,
    	'year' => $year
    ];

    return $arr;
}

function get_event_year_catpage($cat_id = 0) {
	
	$args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'order' => 'DESC',
        'tax_query' => array('relation' => 'AND')
    );

    if ($cat_id != 0) {
        $newty = array(
            'taxonomy' => 'disciplines-category',
            'field' => 'term_id',
            'terms' => $cat_id
        );
        array_push($args['tax_query'], $newty);
    }

    $year = [];

    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
    	while ($loop->have_posts()) {
            $loop->the_post();

            if(get_field('event_single_start_date')) {
				$start_date = get_field('event_single_start_date');
				$start_year = date('Y', strtotime($start_date));
				$year[$start_year] = $start_year;
			}

			if(get_field('event_single_end_date')) {
				$end_date = get_field('event_single_end_date');
				$end_year = date('Y', strtotime($end_date));
				$year[$end_year] = $end_year;
			}

        } wp_reset_postdata();
    }

    ksort($year);

    return $year;
}