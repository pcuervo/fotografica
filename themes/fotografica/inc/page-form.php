<?php

add_action( 'edit_page_form', 'my_second_editor' );
function my_second_editor() {
	// get and set $content somehow...
	wp_editor( $content, 'mysecondeditor' );
}