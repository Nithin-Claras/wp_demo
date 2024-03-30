<?php

if (have_rows('widget_content')) {
   while (has_sub_field('widget_content')) {
       $field = get_row_layout();
        include ( $field . '.php' );
    }
}
?>