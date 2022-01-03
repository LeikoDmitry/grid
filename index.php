<?php
/**
 * Plugin Name: Category or Custom Post Type With Grid
 * Description: Test plugin for the SolbergSoft. 
 * Author: Dmitry Leiko
 * Author URI: https://github.com/LeikoDmitry
 * Version: 1.0.0
 */

namespace Dmitry\Grid;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require __DIR__.'/vendor/autoload.php';

(function () {
    $app = Core::getInstance();
    $app->run();
})();
