<?php
/*
Plugin Name: WP Button by Sorsawo Digital
Plugin URI: https://sorsawodigital.com/button/
Description: Create beautiful button on your WordPress site.
Version: 1.0.0
Author: Sorsawo Digital
Author URI: https://sorsawodigital.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class Sorsawo_Digital_Button {
    private static $_instance = NULL;
    
    /**
     * retrieve singleton class instance
     * @return instance reference to plugin
     */
    public static function get_instance() {
        if ( NULL === self::$_instance ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
    /**
     * Initialize all variables, filters and actions
     */
    private function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'stylesheet' ) );
        add_shortcode( 'button', array( $this, 'button_shortcode' ) );
    }
    
    /**
     * Enqueues front-end CSS for the button.
     */
    public function stylesheet() {
        wp_enqueue_style( 'sorsawodigital-button', plugin_dir_url( __FILE__ ) . 'assets/button.css', array(), null );
    }
    
    /**
     * Produces the button link.
     * @return string Shortcode output
     */
    public function button_shortcode( $atts ) {
        $defaults = array(
            'container' => 'div',
            'link' => '',
            'title' => '',
            'blank' => false,
            'nofollow' => false
        );

        $atts = shortcode_atts( $defaults, $atts, 'button' );
        
        $output = $this->get_output( $atts );
        
        return apply_filters( 'button_shortcode', $output, $atts );
    }
    
    private function get_output( $atts = array() ) {
        $output = '';
        
        if ( isset( $atts['link'] ) && '' !== $atts['link'] && isset( $atts['title'] ) && '' !== $atts['title'] ) {
            $nofollow = isset( $atts['nofollow'] ) && $atts['nofollow'] ? ' rel="nofollow"' : '';
            $blank = isset( $atts['blank'] ) && $atts['blank'] ? ' target="_blank"' : '';
            if ( isset( $atts['container'] ) ) {
                if ( 'div' === $atts['container'] ) {
                    $output .= sprintf( '<div class="sorsawodigital-button"><a href="%s"%s%s>%s</a></div>', $atts['link'], $nofollow, $blank, $atts['title'] );
                } else {
                    $output .= sprintf( '<span class="sorsawodigital-button"><a href="%s"%s%s>%s</a></span>', $atts['link'], $nofollow, $blank, $atts['title'] );
                }
            }
        }
        
        return $output;
    }
}

Sorsawo_Digital_Button::get_instance();