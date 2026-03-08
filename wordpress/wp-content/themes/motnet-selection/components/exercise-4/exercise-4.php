<?php
/*

[exercise-4 open-first="true" single-open="true"]

  [exercise-4-item title="Excepteur eu sint reprehenderit amet ullamco occaecat laboris adipisicing."]
    <p>Id dolore nostrud aute aliqua pariatur…</p>
  [/exercise-4-item]

  [exercise-4-item title="Excepteur eu sint reprehenderit amet ullamco occaecat laboris adipisicing."]
    <p>Id dolore nostrud aute aliqua pariatur…</p>
  [/exercise-4-item]

[/exercise-4]
*/


function exercise_4_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'class'        => '',
        'open-first'   => 'true',
        'single-open'  => 'true',
    ], $atts);

    if (trim($content) === '') {
        return '';
    }

    ob_start(); ?>
    <section
        class="exercise-4 <?= esc_attr($atts['class']) ?>"
        data-open-first="<?= esc_attr($atts['open-first']) ?>"
        data-single-open="<?= esc_attr($atts['single-open']) ?>"
    >
        <div class="exercise-4__container container">
            <div class="exercise-4__wrapper">
                <?= do_shortcode($content) ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-4', 'exercise_4_shortcode');




function exercise_4_item_shortcode($atts, $content = null) {
    $atts = shortcode_atts([
        'class'     => '',
        'title'     => '',
        'title-tag' => 'h3',
    ], $atts);

    if ($atts['title'] === '' || trim($content) === '') {
        return '';
    }

    ob_start(); ?>
    <div class="exercise-4__item <?= esc_attr($atts['class']) ?>">

        <!-- Header -->
        <div class="exercise-4__item-header">
            <<?= esc_html($atts['title-tag']) ?> class="exercise-4__item-title">
                <?= esc_html($atts['title']) ?>
            </<?= esc_html($atts['title-tag']) ?>>

            <span class="exercise-4__item-toggle-button" aria-hidden="true">
                <svg viewBox="0 0 18 18" width="18" height="18">
                    <line x1="9" y1="0" x2="9" y2="18" stroke="currentColor" stroke-width="2"/>
                    <line x1="0" y1="9" x2="18" y2="9" stroke="currentColor" stroke-width="2"/>
                </svg>
            </span>
        </div>

        <!-- Body -->
        <div class="exercise-4__item-body mcy-0">
            <div class="exercise-4__item-body-inner">
                <?= do_shortcode($content) ?>
            </div>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('exercise-4-item', 'exercise_4_item_shortcode');
