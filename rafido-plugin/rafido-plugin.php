<?php

/**
 * Trigger This file on plugin uninstall
 * 
 * @package RafidoPlugin
 */

use Inc\Base\Activate;
use Inc\Base\Deactivate;

/*
   Plugin Name: Rafido Plugin
   Plugin URI: https://my-awesomeness-emporium.com
   description:  a plugin to create awesomeness and spread joy
   Version: 1.2
   Author: Mr. Awesome
   Author URI: https://mrtotallyawesome.com
   License: GPL2
   Text Domain: rafido-plugin
*/

defined('ABSPATH') or die('Hey, what are you doing here? You silly human.');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_rafido_plugin()
{
    Activate::activate();
}
function deactivate_rafido_plugin()
{
    Deactivate::deactivate();
}


register_activation_hook(__FILE__, 'activate_rafido_plugin');
register_deactivation_hook(__FILE__, 'deactivate_rafido_plugin');



if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}
