<?php
/**
 * Add custom fields to the WooCommerce simple product
 *
 * @since 1.0
 */

// Renders custom fields for Arashtad 3D Product Viewer on WooCommerce simple product page.
function arashtad_simple_product_custom_fields() {
     global $woocommerce, $post;
     echo '<div class="product_custom_field">';
     echo '
         <header>
             <h4 style="padding: 0 10px; box-sizing: border-box;">
                 Arashtad 3D Product Viewer
             </h4>
             <p style="margin:0; padding:0 12px; line-height: 16px; font-style: italic; font-size: 13px;">
                 Setup a 3D model to be displayed instead of the default product page gallery. To find out more, visit <a href="https://arashtad.com/" target="_blank">Arashtad.com</a>.
             </p>
         </header>
     ';

     // Path to the model GLTF file
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_model_gltf_path',
             'placeholder' => 'path/to/model.gltf',
             'label' => __('Path to GLTF 3D model', 'arashtad-3d-product-viewer'),
             'description' => __('Path to the 3D model. E.x: wp-content/uploads/3d-models/model.gltf', 'arashtad-3d-product-viewer'),
             'desc_tip' => 'true'
         )
     );

     // The size of the model in the scene
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_model_display_size',
             'placeholder' => 'Default: 1',
             'label' => __('Display size', 'arashtad-3d-product-viewer'),
             'type' => 'number',
             'custom_attributes' => array(
                 'step' => 'any',
                 'min' => '0'
           )
         )
     );

     // Path to the environment image of 3D model
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_model_env',
             'placeholder' => 'path/to/environment.dds',
             'label' => __('Path to environment', 'arashtad-3d-product-viewer'),
             'desc_tip' => 'true',
             'description' => __('Path to .dds file. E.x: wp-content/uploads/environments/env.dds. (leave blank for default). Note: If wrong path entered, the default environment will be used!', 'arashtad-3d-product-viewer'),
         )
     );

     // Replace default product gallery with the 3D scene?
     woocommerce_wp_checkbox(
         array(
             'id'          => '_ar_model_visibility_checkbox',
             'value'       => @get_post_meta(get_the_ID(), '_ar_model_visibility_checkbox')[0],
             'label'       => __('Replace with gallery', 'arashtad-3d-product-viewer'),
             'description' => __('Replaces the product gallery with 3D scene.', 'arashtad-3d-product-viewer'),
         )
     );

     // Enviroment custom background color
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_env_background_color',
             'placeholder' => 'RGBA only; Ex: 0, 0, 0, 1',
             'label' => __('Custom background color', 'arashtad-3d-product-viewer'),
             'description' => __('A custom background color can be set to be displayed instead of the environment.', 'arashtad-3d-product-viewer'),
             'desc_tip' => 'true'
         )
     );

    // Hides the env image and shows the background color instead
    woocommerce_wp_checkbox(
        array(
            'id'          => '_ar_show_env_background_color',
            'value'       => @get_post_meta(get_the_ID(), '_ar_show_env_background_color')[0],
            'label'       => __('Replace with color', 'arashtad-3d-product-viewer'),
            'description' => __('Hides the env image and shows the background color instead.', 'arashtad-3d-product-viewer'),
        )
    );

     // Minimum distance from the model
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_min_zoom',
             'placeholder' => 'Default: 0.02',
             'label' => __('Minimum distance', 'arashtad-3d-product-viewer'),
             'type' => 'number',
             'custom_attributes' => array(
                 'step' => 'any',
                 'min' => '0'
           )
         )
     );

     // Maximum distance from the model
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_max_zoom',
             'placeholder' => 'Default: 0.1',
             'label' => __('Maximum distance', 'arashtad-3d-product-viewer'),
             'type' => 'number',
             'custom_attributes' => array(
                 'step' => 'any',
                 'min' => '0'
           )
         )
     );

     // Mouse wheel precision
     woocommerce_wp_text_input(
         array(
             'id' => '_ar_wheel_speed',
             'placeholder' => 'Default: 200',
             'label' => __('Wheel Precision', 'arashtad-3d-product-viewer'),
             'type' => 'number',
             'custom_attributes' => array(
                 'step' => 'any',
                 'min' => '0'
           )
         )
     );

     echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'arashtad_simple_product_custom_fields');

// Storing the custom fields for Arashtad 3D Product Viewer
function arashtad_simple_product_custom_fields_save($post_id) {

    $fields = array(
        '_ar_model_gltf_path',
        '_ar_model_display_size',
        '_ar_model_env',
        '_ar_model_visibility_checkbox',
        '_ar_env_background_color',
        '_ar_show_env_background_color',
        '_ar_min_zoom',
        '_ar_max_zoom',
        '_ar_wheel_speed'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            // Sanitize text fields, checkbox values, etc. as needed
            update_post_meta($post_id, $field, $value);
        } else {
            update_post_meta($post_id, $field, ''); // Empty value if not set
        }
    }
}
add_action('woocommerce_process_product_meta', 'arashtad_simple_product_custom_fields_save');
