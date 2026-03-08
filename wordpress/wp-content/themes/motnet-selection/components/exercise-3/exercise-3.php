<?php

/*
[exercise-3]
  [exercise-3-item
    ids="2256,2257,2258"
    subtitle="Lorem ipsum"
    title="Lorem ipsum"
    link-text="Read more"
    item-id="65"]
    <p>Fugiat aliqua commodo consequat…</p>
  [/exercise-3-item]
[/exercise-3]
*/



function exercise_3_shortcode($atts, $content = null) {
    
    $atts = shortcode_atts([
        'class' => '',
    ], $atts);

    if (strpos($content, '[exercise-3-wrapper]') === false) {
        $content = '[exercise-3-wrapper]' . $content . '[/exercise-3-wrapper]';
    }

    return '<div class="exercise-3 ' . esc_attr($atts['class']) . '">' .
        do_shortcode($content) .
    '</div>';
}
add_shortcode('exercise-3', 'exercise_3_shortcode');



function exercise_3_wrapper_shortcode($atts, $content = null) {
    return '<div class="exercise-3__wrapper">' . do_shortcode($content) . '</div>';
}
add_shortcode('exercise-3-wrapper', 'exercise_3_wrapper_shortcode');




function exercise_3_item_shortcode($atts, $content = null) {

    $atts = shortcode_atts([
        'ids' => '',
        'item-id' => '',
        'subtitle' => '',
        'subtitle-tag' => 'h3',
        'title' => '',
        'title-tag' => 'h2',
        'link' => '',
        'link-text' => '',
        'target' => '_self',
        'class' => ''
    ], $atts);

    if ($atts['item-id']) {
        if (!$atts['title']) $atts['title'] = get_the_title($atts['item-id']);
        if (!$atts['link'])  $atts['link']  = get_permalink($atts['item-id']);
        if (!$content)       $content       = get_the_excerpt($atts['item-id']);
    }



    $ids = array_filter(array_map('trim', explode(',', $atts['ids'])));

    if (empty($ids) && $atts['item-id']) {
        $thumb = get_post_thumbnail_id($atts['item-id']);
        if ($thumb) $ids = [$thumb];
    }

    ob_start(); ?>


    <section class="exercise-3__item <?= esc_attr($atts['class']) ?>">
        <div class="exercise-3__media" data-slider>
            <?php foreach ($ids as $id): ?>
                <?php
                $url = wp_get_attachment_url($id);
                if (!$url) continue;
                ?>
                <div class="exercise-3__slide">
                    <img src="<?= esc_url($url) ?>" alt="">
                </div>
            <?php endforeach; ?>

            <?php if (count($ids) > 1): ?>
                <button class="nav prev" type="button" aria-label="Previous">
                    <svg viewBox="0 0 12.324 21.82" xmlns="http://www.w3.org/2000/svg"><g transform="translate(10.91 20.406) rotate(180)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"><line x2="9.496" y1="9.496"/><line transform="translate(0 9.496)" x2="9.496" y2="9.496"/></g></svg>
                </button>
                <button class="nav next" type="button" aria-label="Next">
                    <svg viewBox="0 0 12.324 21.82" xmlns="http://www.w3.org/2000/svg"><g transform="translate(10.91 20.406) rotate(180)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"><line x2="9.496" y1="9.496"/><line transform="translate(0 9.496)" x2="9.496" y2="9.496"/></g></svg>
                </button>
                <div class="dots"></div>
            <?php endif; ?>
        </div>

        <div class="exercise-3__content">
            <?php if ($atts['subtitle']): ?>
                <<?= esc_html($atts['subtitle-tag']) ?>><?= esc_html($atts['subtitle']) ?></<?= esc_html($atts['subtitle-tag']) ?>>
            <?php endif; ?>

            <?php if ($atts['title']): ?>
                <<?= esc_html($atts['title-tag']) ?>><?= esc_html($atts['title']) ?></<?= esc_html($atts['title-tag']) ?>>
            <?php endif; ?>

            <?php if ($content): ?>
                <div class="text"><?= wpautop($content) ?></div>
            <?php endif; ?>

            <?php if ($atts['link-text'] && $atts['link']): ?>
                <a href="<?= esc_url($atts['link']) ?>" target="<?= esc_attr($atts['target']) ?>" class="btn">
                    <?= esc_html($atts['link-text']) ?>
                </a>
            <?php endif; ?>
        </div>
    </section>

    
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-3-item', 'exercise_3_item_shortcode');