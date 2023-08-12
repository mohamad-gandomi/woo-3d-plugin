<?php

/**
 * Add Simple Product 3D Model in woocommerce single product page
 *
 * @since 1.0
 */

function arashtad_woocommerce_before_single_product_summary_action_simple () {

    if (!is_product()) return;

    remove_all_actions('woocommerce_before_single_product_summary');

    $id =  get_the_ID();
    $product = wc_get_product($id);
    
    // If the product is not a simple product or show 3D model is not checked, return early
    $model_visibility = get_post_meta($id, '_ar_model_visibility_checkbox', true);
    if ( !$product->is_type('simple') ||  empty($model_visibility) ) {
        return;
    }

    // If the specified 3D model does not exist, an error will be thrown
    $model_path = site_url() . get_post_meta($id, '_ar_model_gltf_path', true);
    if (empty($model_path) || is_wp_error(wp_remote_head($model_path)) || wp_remote_retrieve_response_code(wp_remote_head($model_path)) !== 200) {
        wc_add_notice(__('The requested 3D model could not be located.', 'arashtad-3d-product-viewer'), 'error');
        return;
    }

    // Find the last occurrence of '/' in model url
    $last_slash_pos = strrpos($model_path, '/');

    // Extract the model directory and filename
    $model_directory = substr($model_path, 0, $last_slash_pos + 1);
    $model_name = substr($model_path, $last_slash_pos + 1);

    // If the enviroment does not exist, use the default
    $model_env = get_post_meta($id, '_ar_model_env', true);
    if ( empty($model_env) || !file_exists($model_env) ) {
        $model_env = ARASHTAD_3D_PRODUCT_URL . 'public/assets/environments/environment.dds';
    }

    // Other 3D Model meta
    $show_env_background_color = get_post_meta($id, '_ar_show_env_background_color', true);
    $env_background_color = get_post_meta($id, '_ar_env_background_color', true);
    $model_display_size = get_post_meta($id, '_ar_model_display_size', true) ?: 1;
    $min_zoom = get_post_meta($id, '_ar_min_zoom', true) ?: 0.02;
    $max_zoom = get_post_meta($id, '_ar_max_zoom', true) ?: 0.1;
    $wheel_speed = get_post_meta($id, '_ar_wheel_speed', true) ?: 200;

    // Enqueue Script and Pass Meta Data
    wp_enqueue_script('arashtad-simple-product-script', ARASHTAD_3D_PRODUCT_URL . 'public/assets/js/arashtad-simple-product-script.js', array('jquery'), null, true);
    wp_localize_script('arashtad-simple-product-script', 'metaData', array(
        'modelDirectory' => $model_directory,
        'modelName' => $model_name,
        'modelEnv' => $model_env,
        'modelDisplaySize' => $model_display_size,
        'envBackgroundColor' => $env_background_color,
        'showEnvBackgroundColor' => $show_env_background_color,
        'minZoom' => $min_zoom,
        'maxZoom' => $max_zoom,
        'wheelSpeed' => $wheel_speed,
    ));

    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    add_action('woocommerce_before_single_product_summary', function() { 
        echo '
        <div id="canvas">
            <canvas id="productScene"></canvas>
            <div class="arPreloader">
                <div class="blink middle">
                    <div class="ar-preloader-logo"></div>
                    LOADING...
                </div>
            </div>
        </div>
        ';
    }, 20);
}

add_action('wp_enqueue_scripts', 'arashtad_woocommerce_before_single_product_summary_action_simple');