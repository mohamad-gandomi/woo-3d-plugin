<?php

/**
 * This plugin adds a 3D view to WooCoomerce product pages and loads GLB and GLTF 3D models in the page.
 *
 * @package Arashtad 3D Product Viewer
 * @author Amin Shahrokhi
 * @license GPL-2.0+
 * @link https://arashtad.com/
 * @copyright 2023 Arashtad.com. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: Arashtad 3D Product Viewer
 *            Plugin URI: https://arashtad.com/
 *            Description: This plugin adds a 3D view to WooCoomerce product pages and loads GLB and GLTF 3D models in the page. After installation, news fields will be added to the WooCommerce product form to add 3D models and setting them up to be displayed instead of the product images.
 *            Version: 1.0
 *            Author: Amin Shahrokhi
 *            Author URI: https://shahrokhi.pro/
 *            Text Domain: arashtad-3d-product-viewer
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// Security check to prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for file paths
define('ARASHTAD_3D_PRODUCT_DIR', plugin_dir_path(__FILE__));
define('ARASHTAD_3D_PRODUCT_URL', plugin_dir_url(__FILE__));

// Localization
function arashtad_3d_product_load_textdomain() {
    load_plugin_textdomain('arashtad-3d-product-viewer', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'arashtad_3d_product_load_textdomain');

// Include files
require_once(ARASHTAD_3D_PRODUCT_DIR . 'admin/arashtad-settings-page.php');
require_once(ARASHTAD_3D_PRODUCT_DIR . 'admin/arashtad-simple-product-custom-fields.php');
