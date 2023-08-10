<?php

/**
 * Add a custom submenu page under the "Settings" menu
 *
 * @since 1.0
 */

// Load styles and scripts only for arashtad admin settings page
function arashtad_3d_viewer_admin_setting_assets($hook) {

    if ($hook === 'settings_page_arashtad-3d-product-viewer') {
        // Enqueue styles
        wp_enqueue_style('admin-setting-page', ARASHTAD_3D_PRODUCT_URL . 'admin/assets/css/admin-setting-page.css');
        
        // Enqueue scripts
        wp_enqueue_script('admin-setting-page', ARASHTAD_3D_PRODUCT_URL . 'admin/assets/js/admin-setting-page.js', array('jquery'), '1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'arashtad_3d_viewer_admin_setting_assets');

// Add a custom submenu page under the "Settings" menu
function arashtad_3d_viewer_add_menu() {
    add_submenu_page(
        'options-general.php',
        'Arashtad 3D Product Viewer',
        'Arashtad 3D Product Viewer',
        'manage_options',
        'arashtad-3d-product-viewer',
        'arashtad_3d_product_viewer_page'
    );
}
add_action('admin_menu', 'arashtad_3d_viewer_add_menu');

// Callback function to render the content of the Arashtad 3D Product setting page
function arashtad_3d_product_viewer_page() {
    include_once(ARASHTAD_3D_PRODUCT_DIR . 'admin/templates/arashtad-setting-page-template.php');
}