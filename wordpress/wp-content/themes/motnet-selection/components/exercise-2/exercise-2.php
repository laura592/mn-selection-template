<?php


function exercise_2_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'class' => '',
    ], $atts);

    if (strpos($content, '[exercise-2-wrapper]') === false) {
        $content = '[exercise-2-wrapper]' . $content . '[/exercise-2-wrapper]';
    }

    return '<section class="exercise-2 ' . esc_attr($atts['class']) . '">' .
        do_shortcode($content) .
    '</section>';
}
add_shortcode('exercise-2', 'exercise_2_shortcode');




function exercise_2_wrapper_shortcode($atts, $content = null) {
    return '<div class="exercise-2__wrapper">' . do_shortcode($content) . '</div>';
}
add_shortcode('exercise-2-wrapper', 'exercise_2_wrapper_shortcode');




function exercise_2_item_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'url'          => '',
        'poster'       => '',
        'title'        => '',
        'title-tag'    => 'h2',
        'subtitle'     => '',
        'subtitle-tag' => 'h3',
        'class'        => '',
    ], $atts);

    if (!$atts['url']) {
        return '';
    }

    $url = esc_url($atts['url']);
    // Add parameters to hide Vimeo controls
    $separator = (strpos($url, '?') !== false) ? '&' : '?';
    $embed_url = $url . $separator . 'background=1&autoplay=1&loop=0&byline=0&title=0&controls=0';

    // Get poster image
    $poster_url = '';
    if ($atts['poster']) {
        $poster_url = wp_get_attachment_url((int) $atts['poster']);
    }

    ob_start(); ?>
    <div class="exercise-2__item <?= esc_attr($atts['class']) ?>">

        <?php if ($atts['subtitle']): ?>
            <<?= esc_html($atts['subtitle-tag']) ?> class="exercise-2__subtitle">
                <?= esc_html($atts['subtitle']) ?>
            </<?= esc_html($atts['subtitle-tag']) ?>>
        <?php endif; ?>

        <?php if ($atts['title']): ?>
            <<?= esc_html($atts['title-tag']) ?> class="exercise-2__title">
                <?= esc_html($atts['title']) ?>
            </<?= esc_html($atts['title-tag']) ?>>
        <?php endif; ?>

        <div class="exercise-2__video" data-video-url="<?= esc_attr($embed_url) ?>">
            <?php if ($poster_url): ?>
                <img class="exercise-2__poster" src="<?= esc_url($poster_url) ?>" alt="">
            <?php else: ?>
                <div class="exercise-2__poster exercise-2__poster--placeholder"></div>
            <?php endif; ?>
            <button class="exercise-2__play" type="button" aria-label="Play video">
                <svg viewBox="0 0 64 48" xmlns="http://www.w3.org/2000/svg">
                    <rect width="64" height="48" rx="8" fill="#0D2141"/>
                    <polygon points="26,14 26,34 44,24" fill="#FFFFFF"/>
                </svg>
            </button>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-2-item', 'exercise_2_item_shortcode');
