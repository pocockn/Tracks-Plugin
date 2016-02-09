<?php
/* 
Plugin Name: Tracks
Plugin URI: www.blueprintwebdesigns.co.uk
Description: This plugin allows you to easily add new songs to your WordPress site
Version: 0.1 
Author: Nick Pocock
Author URI: http://leave-you.com
License: GPL2 

    This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License,
    version 2, as published by the Free Software Foundation. 

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of 
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
    GNU General Public License for more details. 

    You should have received a copy of the GNU General Public License 
    along with this program; if not, write to the Free Software 
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 
    02110-1301  USA 
*/

require_once('inc/class-tracks-plugin.php');

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Define constants
if ( ! defined( 'TRACKS_VERSION' ) ) {

    define( 'TRACKS_VERSION', 0.1 );
}

if( ! defined('TRACKS_PLUGIN_URI' ) ) {

    define( 'TRACKS_PLUGIN_URI', plugins_url( '', 'tracks-plugin/tracks-plugin.php' ) );
}

if ( ! defined( 'TRACKS_PLUGIN_DIR' ) ) {

    define( 'TRACKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Get the plugin in motion
new Tracks_Plugin();

?>