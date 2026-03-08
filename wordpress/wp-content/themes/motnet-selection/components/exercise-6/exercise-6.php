<?php
/*
===============================================================================
EXERCISE 6 — ALTERNATING MEDIA / TEXT LIST
===============================================================================

[exercise-6 title="Elit occaecat ipsum" text="Intro text here"]

  [exercise-6-item
    image-id="24"
    subtitle="Lorem ipsum"
    title="Lorem ipsum"
    link-text="Read more"
    link="#"]
    <p>Fugiat aliqua commodo consequat reprehenderit…</p>
  [/exercise-6-item]

  [exercise-6-item
    image-id="25"
    subtitle="Lorem ipsum"
    title="Lorem ipsum"
    link-text="Read more"
    link="#"]
    <p>Fugiat aliqua commodo consequat reprehenderit…</p>
  [/exercise-6-item]

[/exercise-6]
*/

/* ---------------------------------------------------------------------------
 * [exercise-6] — WRAPPER
 * --------------------------------------------------------------------------- */
function exercise_6_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'class' => '',
        'title' => '',
        'text'  => '',
    ], $atts);

    if (trim($content) === '') return '';

    ob_start(); ?>
    <section class="exercise-6 <?= esc_attr($atts['class']) ?>">
        <div class="exercise-6__container container">

            <?php if ($atts['title'] || $atts['text']): ?>
                <header class="exercise-6__header">
                    <?php if ($atts['title']): ?>
                        <h2 class="exercise-6__title"><?= esc_html($atts['title']) ?></h2>
                    <?php endif; ?>
                    <?php if ($atts['text']): ?>
                        <div class="exercise-6__intro"><?= wpautop($atts['text']) ?></div>
                    <?php endif; ?>
                </header>
            <?php endif; ?>

            <div class="exercise-6__list">
                <?= do_shortcode($content) ?>
            </div>

        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-6', 'exercise_6_shortcode');

/* ---------------------------------------------------------------------------
 * [exercise-6-item]
 * --------------------------------------------------------------------------- */
function exercise_6_item_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'class'     => '',
        'image-id'  => '',
        'image-ids' => '',
        'subtitle'  => '',
        'title'     => '',
        'link'      => '',
        'link-text' => '',
    ], $atts);

    if (trim($content) === '') return '';

    // Collect image IDs: support both single image-id and multiple image-ids
    $ids = [];
    if ($atts['image-ids']) {
        $ids = array_filter(array_map('trim', explode(',', $atts['image-ids'])));
    } elseif ($atts['image-id']) {
        $ids = [$atts['image-id']];
    }
    if (empty($ids)) return '';

    $is_slider = count($ids) > 1;

    ob_start(); ?>
    <article class="exercise-6__item <?= esc_attr($atts['class']) ?>">
        <div class="exercise-6__item-media<?= $is_slider ? ' exercise-6__slider' : '' ?>"<?= $is_slider ? ' data-ex6-slider' : '' ?>>
            <?php foreach ($ids as $id): ?>
                <?php $img = wp_get_attachment_url((int)$id); if (!$img) continue; ?>
                <div class="exercise-6__slide">
                    <img src="<?= esc_url($img) ?>" alt="">
                </div>
            <?php endforeach; ?>

            <?php if ($is_slider): ?>
                <button class="exercise-6__arrow exercise-6__arrow--prev" type="button" aria-label="Previous">
                    <svg viewBox="0 0 12.324 21.82" xmlns="http://www.w3.org/2000/svg"><g transform="translate(10.91 20.406) rotate(180)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"><line x2="9.496" y1="9.496"/><line transform="translate(0 9.496)" x2="9.496" y2="9.496"/></g></svg>
                </button>
                <button class="exercise-6__arrow exercise-6__arrow--next" type="button" aria-label="Next">
                    <svg viewBox="0 0 12.324 21.82" xmlns="http://www.w3.org/2000/svg"><g transform="translate(10.91 20.406) rotate(180)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"><line x2="9.496" y1="9.496"/><line transform="translate(0 9.496)" x2="9.496" y2="9.496"/></g></svg>
                </button>
            <?php endif; ?>
        </div>

        <div class="exercise-6__item-content">
            <?php if ($atts['subtitle']): ?>
                <p class="exercise-6__item-subtitle"><?= esc_html($atts['subtitle']) ?></p>
            <?php endif; ?>

            <?php if ($atts['title']): ?>
                <h3 class="exercise-6__item-title"><?= esc_html($atts['title']) ?></h3>
            <?php endif; ?>

            <div class="exercise-6__item-text">
                <?= wpautop($content) ?>
            </div>

            <?php if ($atts['link'] && $atts['link-text']): ?>
                <a href="<?= esc_url($atts['link']) ?>" class="exercise-6__item-link">
                    <?= esc_html($atts['link-text']) ?>
                </a>
            <?php endif; ?>
        </div>
    </article>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-6-item', 'exercise_6_item_shortcode');
