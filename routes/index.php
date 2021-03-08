<?php
/**
 * @author     Martin Høgh <mh@mapcentia.com>
 * @copyright  2013-2021 MapCentia ApS
 * @license    http://www.gnu.org/licenses/#AGPL  GNU AFFERO GENERAL PUBLIC LICENSE 3
 *
 */


use app\inc\Route;

/**
 * This will route to the controller "demo" at controller/demo
 */
Route::add("extensions/gc2_demo_extension/controller/demo/{db}");