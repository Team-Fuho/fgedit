<?php

/**
 * Plugin Name: Fuho Gallery
 * Plugin URI: https://teamfuho.net/vi/gallery
 * Description: Made by hUwUtao with <3
 * Version: 0.1
 * Author: hUwUtao
 * Author URI: http://hUwUtao.me
 **/

$pluginpath = dirname(__FILE__);

require_once($pluginpath . "/../../../wp-config.php");
require_once($pluginpath . "/vendor/autoload.php");
require_once($pluginpath . "/src/options.php");
require_once($pluginpath . "/src/editor.php");


$fstr = array(
    "title" => "Fuho Gallery",
);

function fuho_dashmenu()
{
    add_options_page('Config gallery database', 'Config Gallery', 'manage_options', 'fuho_gplug', 'fuho_settings_renderer');
    add_menu_page('Khu triển lãm', 'Khu triển lãm', 'edit_others_posts', 'fuho_dashgal', 'fuho_dashgaledit');
}
add_action('admin_menu', 'fuho_dashmenu');
