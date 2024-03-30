<?php

add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

add_filter('use_block_editor_for_post', '__return_false');

