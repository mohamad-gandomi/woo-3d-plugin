<?php

/**
 * Add custom field to the WooCommerce product page for variable products
 *
 * @since 1.0
 */

// Renders custom fields for Arashtad 3D Product Viewer on WooCommerce variable product page.
function arashtad_variable_product_custom_fields($loop, $variation_data, $variation) {

    echo '<div class="product_custom_field" style="clear:both">';
    echo '
        <header>
            <h4 style="padding:1.3em 0 0.5em 0; box-sizing: border-box; margin:0">
                Arashtad 3D Product Viewer
            </h4>
            <p style="margin:0;line-height: 16px; font-style: italic; font-size: 13px;">
                Setup a 3D model to be displayed instead of the default product Image. To find out more, visit <a href="https://arashtad.com/" target="_blank">Arashtad.com</a>.
            </p>
        </header>
    ';

    // Replace default product gallery with the 3D scene?
    woocommerce_wp_checkbox(
        array(
            'style' => 'margin-right:7px !important',
            'wrapper_class' => 'form-row form-row-full',
            'id'          => '_ar_model_visibility_checkbox_' . $loop,
            'label'       => __('Replace with product image', 'woocommerce'),
            'description' => __('Replaces the product image with 3D scene.', 'woocommerce'),
            'desc_tip' => 'true',
            'value' => get_post_meta($variation->ID, '_ar_model_visibility_checkbox', true),
        )
    );
    
    // Path to the model GLTF file
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-full',
            'id' => '_ar_model_gltf_path_' . $loop,
            'placeholder' => 'path/to/model.gltf',
            'label' => __('Path to GLTF 3D model', 'woocommerce'),
            'description' => __('Path to the 3D model. E.x: wp-content/uploads/3d-models/model.gltf', 'woocommerce'),
            'desc_tip' => 'true',
            'value' => get_post_meta($variation->ID, '_ar_model_gltf_path', true)
        )
    );

    // The size of the model in the scene
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-first',
            'id' => '_ar_model_display_size_' . $loop,
            'placeholder' => 'Default: 1',
            'label' => __('Display size', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
            'value' => get_post_meta($variation->ID, '_ar_model_display_size', true),
        )
    );

    // Path to the environment image of 3D model
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-last',
            'id' => '_ar_model_env_' . $loop,
            'placeholder' => 'path/to/environment.dds',
            'label' => __('Path to environment', 'woocommerce'),
            'desc_tip' => 'true',
            'description' => __('Path to .dds file. E.x: wp-content/uploads/environments/env.dds. (leave blank for default). Note: If wrong path entered, the default environment will be used!', 'woocommerce'),
            'value' => get_post_meta($variation->ID, '_ar_model_env', true)
        )
    );

    // Hides the env image and shows the background color instead
    woocommerce_wp_checkbox(
        array(
            'wrapper_class' => 'form-row form-row-full',
            'style' => 'margin-right:7px !important',
            'id'          => '_ar_show_env_background_color_' . $loop,
            'label'       => __('Replace with color', 'woocommerce'),
            'description' => __('Hides the env image and shows the color instead.', 'woocommerce'),
            'desc_tip' => 'true',
            'value' => get_post_meta($variation->ID, '_ar_show_env_background_color', true),
        )
    );

    // Enviroment custom background color
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-first',
            'id' => '_ar_env_background_color_' . $loop,
            'placeholder' => 'RGBA only; Ex: 0, 0, 0, 1',
            'label' => __('Custom background color', 'woocommerce'),
            'description' => __('A custom background color can be set to be displayed instead of the environment.', 'woocommerce'),
            'desc_tip' => 'true',
            'value' => get_post_meta($variation->ID, '_ar_env_background_color', true),
        )
    );

    // Minimum distance from the model
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-last',
            'id' => '_ar_min_zoom_' . $loop,
            'placeholder' => 'Default: 0.02',
            'label' => __('Minimum distance', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
            'value' => get_post_meta($variation->ID, '_ar_min_zoom', true),
        )
    );

    // Maximum distance from the model
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-first',
            'id' => '_ar_max_zoom_' . $loop,
            'placeholder' => 'Default: 0.1',
            'label' => __('Maximum distance', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
            'value' => get_post_meta($variation->ID, '_ar_max_zoom', true),
        )
    );

    // Mouse wheel precision
    woocommerce_wp_text_input(
        array(
            'wrapper_class' => 'form-row form-row-last',
            'id' => '_ar_wheel_speed_' . $loop,
            'placeholder' => 'Default: 200',
            'label' => __('Wheel Precision', 'woocommerce'),
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
            'value' => get_post_meta($variation->ID, '_ar_wheel_speed', true),
        )
    );

    echo '</div>';
}
add_action('woocommerce_variation_options_pricing', 'arashtad_variable_product_custom_fields', 10, 3);

// Storing the custom fields for Arashtad 3D Product Viewer
function arashtad_variable_product_custom_fields_save($variation_id, $i) {

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
        $post_field_name = $field . '_' . $i;
        $post_value = isset($_POST[$post_field_name]) ? $_POST[$post_field_name] : '';
        update_post_meta($variation_id, $field, sanitize_text_field($post_value));
    }

}
add_action('woocommerce_save_product_variation', 'arashtad_variable_product_custom_fields_save', 10, 2);
