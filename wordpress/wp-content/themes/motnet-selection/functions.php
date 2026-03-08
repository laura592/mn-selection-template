<?php
// Sicurezza
if (!defined('ABSPATH')) {
    exit;
}

// Disabilita Gutenberg ovunque
add_filter('use_block_editor_for_post', '__return_false', 100);
add_filter('use_block_editor_for_page', '__return_false', 100);
add_filter('gutenberg_can_edit_post_type', '__return_false', 100);
// Disabilita wpautop — distrugge l'HTML dei componenti (SVG, slider, ecc.)
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
add_action('init', function () {
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
});

// Pulisci commenti HTML segnaposto ma mantieni gli h1 come divisori stilizzati
add_filter('the_content', function ($content) {
    $content = preg_replace('/<!--\s*Exercise\s+\d+\s*-->/', '', $content);
    // Avvolgi gli h1 "Exercise N" in un wrapper per lo stile divisore
    $content = preg_replace(
        '/<h1>\s*(Exercise\s+\d+)\s*<\/h1>/',
        '<div class="exercise-divider"><h1 class="exercise-divider__title">$1</h1><span class="exercise-divider__accent"></span></div>',
        $content
    );
    return $content;
}, 1);

// Shortcode scritti come plain text nell'editor, eseguiti solo in frontend
remove_filter('the_content', 'do_shortcode', 11);
add_filter('the_content', 'do_shortcode', 99);


/* ---------------------------------------------------------------------------
 * ASSETS GLOBALI — CSS CONDIVISI
 * --------------------------------------------------------------------------- */

/* Google Fonts */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'mn-google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Work+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap',
        [],
        null
    );
}, 5);

add_action('wp_enqueue_scripts', function () {
    $css_dir = get_template_directory() . '/globals/css';
    $css_uri = get_template_directory_uri() . '/globals/css';

    if (!is_dir($css_dir)) {
        return;
    }

    foreach (glob($css_dir . '/*.css') as $file) {
        $handle = 'mn-global-' . sanitize_title(basename($file, '.css'));

        wp_enqueue_style(
            $handle,
            $css_uri . '/' . basename($file),
            [],
            filemtime($file)
        );
    }
});


// Caricamento automatico di QUALSIASI cartella dentro /components
add_action('wp_enqueue_scripts', function () {
    $components_dir = get_template_directory() . '/components';
    $components_uri = get_template_directory_uri() . '/components';

    if (!is_dir($components_dir)) {
        return;
    }

    foreach (glob($components_dir . '/*', GLOB_ONLYDIR) as $dir) {
        $slug = basename($dir);

        $css = "$dir/$slug.css";
        $js  = "$dir/$slug.js";
        $php = "$dir/$slug.php";

        if (file_exists($css)) {
            wp_enqueue_style(
                "mn-$slug",
                "$components_uri/$slug/$slug.css",
                [],
                filemtime($css)
            );
        }

        if (file_exists($js)) {
            wp_enqueue_script(
                "mn-$slug",
                "$components_uri/$slug/$slug.js",
                [],
                filemtime($js),
                true
            );
        }

        if (file_exists($php)) {
            require_once $php;
        }
    }
});

// Colonna ID in tutte le tabelle admin dei post

add_filter('manage_posts_columns', function ($columns) {
    $columns['post_id'] = 'ID';
    return $columns;
});

add_action('manage_posts_custom_column', function ($column, $post_id) {
    if ($column === 'post_id') {
        echo (int) $post_id;
    }
}, 10, 2);


add_filter('manage_media_columns', function ($columns) {
    $columns['media_id'] = 'ID';
    return $columns;
});

add_action('manage_media_custom_column', function ($column, $post_id) {
    if ($column === 'media_id') {
        echo (int) $post_id;
    }
}, 10, 2);


// add_action('admin_head', function () {
//     echo '<style>.column-post_id{font-weight:600}</style>';
// });