<?php

/**
 * Enqueue styles and scripts on WooCommerce product page
 *
 * @since 1.0
 */

function arashtad_enqueue_styles_and_scripts_public() {
    if (is_product()) {

        // Public styles
        wp_enqueue_style('arashtad-public-styles', ARASHTAD_3D_PRODUCT_URL . 'public/assets/css/arashtad-public-styles.css');

        // Babylon scripts
        wp_enqueue_script('dat', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/dat.gui.min.js', array(), '1.0.0', false);
        wp_enqueue_script('assets', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/Assets.js', array(), '1.0.0', false);
        wp_enqueue_script('ammo', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/ammo.js', array(), '1.0.0', false);
        wp_enqueue_script('cannon', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/cannon.js', array(), '1.0.0', false);
        wp_enqueue_script('oimo', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/Oimo.js', array(), '1.0.0', false);
        wp_enqueue_script('earcut', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/earcut.min.js', array(), '1.0.0', false);
        wp_enqueue_script('babylon', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylon.js', array(), '1.0.0', false);
        wp_enqueue_script('materials', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylonjs.materials.min.js', array(), '1.0.0', false);
        wp_enqueue_script('procedural-textures', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylonjs.proceduralTextures.min.js', array(), '1.0.0', false);
        wp_enqueue_script('post-process', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylonjs.postProcess.min.js', array(), '1.0.0', false);
        wp_enqueue_script('loaders', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylonjs.loaders.js', array(), '1.0.0', false);
        wp_enqueue_script('serializers', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylonjs.serializers.min.js', array(), '1.0.0', false);
        wp_enqueue_script('gui', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylon.gui.min.js', array(), '1.0.0', false);
        wp_enqueue_script('inspector', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/babylon/babylon.inspector.bundle.js', array(), '1.0.0', false);

    }
}
add_action('wp_enqueue_scripts', 'arashtad_enqueue_styles_and_scripts_public');