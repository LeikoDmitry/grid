<?php
/**
 * Plugin Name: Category or Custom Taxonomy ShortCode.
 * Description: Test plugin. 
 * Author: Dmitry Leiko
 * Author URI: https://github.com/LeikoDmitry
 * Version: 1.0.0
 */

namespace Dmitry\Grid;

if (!defined('ABSPATH')) {
    exit;
}

require __DIR__.'/vendor/autoload.php';

(function () {
    $app = Core::getInstance();
    $app->run();
})();
