<?php

function exercise_5_shortcode($atts) {
    $atts = shortcode_atts([
        'ids'          => '',
        'titles'       => '',
        'descriptions' => '',
        'class'        => '',
    ], $atts);

    $ids = array_filter(array_map('trim', explode(',', $atts['ids'])));
    if (empty($ids)) return '';

    $titles = $atts['titles'] ? explode('|', $atts['titles']) : [];
    $descriptions = $atts['descriptions'] ? explode('|', $atts['descriptions']) : [];

    ob_start(); ?>
    <div class="exercise-5 <?= esc_attr($atts['class']) ?>" data-exercise-5>

        <?php foreach ($ids as $i => $id): ?>
            <?php
            $url = wp_get_attachment_url($id);
            if (!$url) continue;
            $title = isset($titles[$i]) ? trim($titles[$i]) : '';
            $desc  = isset($descriptions[$i]) ? trim($descriptions[$i]) : '';
            ?>
            <div class="exercise-5__item" data-index="<?= (int) $i ?>">
                <div class="exercise-5__image-wrap">
                    <img src="<?= esc_url($url) ?>" alt="">
                    <button class="exercise-5__expand" type="button" aria-label="Show info" data-ex5-toggle>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="10" y1="2" x2="10" y2="18" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            <line x1="2" y1="10" x2="18" y2="10" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
                <?php if ($title || $desc): ?>
                <div class="exercise-5__info" hidden>
                    <?php if ($title): ?>
                        <h4 class="exercise-5__info-title"><?= esc_html($title) ?></h4>
                    <?php endif; ?>
                    <?php if ($desc): ?>
                        <p class="exercise-5__info-desc"><?= esc_html($desc) ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-5', 'exercise_5_shortcode');
