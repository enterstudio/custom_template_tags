<?php

/*
  Plugin Name: Custom Template Tags
  Plugin URI: http://codeandnotes.com
  Description: Custom Template Tags for a Wordpress theme that use the same snytax as standard WP template tags (the_content) by addding a very simple class prefix
  Version: 1.0
  Author: Steven J Armstrong
  Author URI: http://codeandnotes.com
  License: GPL2
 * 
 */

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : sarmstrongmusic@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

class CMT {

    public static function __callStatic($method, $args) {

        if (substr($method, 0, 4) === "the_") {

            echo get_post_meta(get_the_ID(), substr($method, 4), true);
            
        } else if (substr($method, 0, 8) === "get_the_") {

            return get_post_meta(get_the_ID(), substr($method, 8), true);
            
        } else if (substr($method, -7) === "_exists") {

            return get_post_meta(get_the_ID(), substr($method, 0, -7), true) === "" ? false : true;
            
        }
    }

}

class CTT {

    public static function __callStatic($method, $args) {

        if (substr($method, 0, 4) == 'the_') {
            
            $term = substr($method, 4); 
            
            $list = self::handle_terms($term ,$args); 

            echo gettype($list) == "string" ? $list : ''; 
            
        } else if (substr($method, 0, 8) === "get_the_") {
            
            $term = substr($method, 8); 
            
            $list = self::handle_terms($term ,$args); 
            
            return gettype($list) == "string" ? $list : '';   
            
        } else if (substr($method, -7) === "_exists") {

            $obj  = get_the_terms( get_the_ID() , substr($method, 0, -7) ); 
            
            return $obj && !is_wp_error($obj) ? true : false;  
        }
    }

    private static function handle_terms($term , $args) {

        isset($args[0]) ? $seperator = $args[0] : $seperator = false;
        
        if ($seperator == false) {

            $str = '<ul class="post-' . $term . '" >';

            $str .= get_the_term_list(get_the_ID(), $term, '<li>', "</li><li>", "</li>");

            $str .= "</ul>";

            return $str;
            
        } else {
            
            $str = get_the_term_list(get_the_ID(), $term, '', $seperator , '');
            
            return $str; 
            
        }
    }

}

?>
