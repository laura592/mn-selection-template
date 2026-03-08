<?php
// MU-Plugin: Force remove wpautop from the_content
add_action("init", function() {
    remove_filter("the_content", "wpautop");
    remove_filter("the_excerpt", "wpautop");
}, 0);
add_action("wp", function() {
    remove_filter("the_content", "wpautop");
}, 0);
