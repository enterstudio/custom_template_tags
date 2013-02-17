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

/*  Copyright 2012  Steve Armstrong (email : sarmstrongmusic@gmail.com)

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

/**
 * class CMT (Custom Meta Tags)
 * 
 * Allows you to use your post meta as a template tag simliar to the WordPress syntax the_title(). 
 * If you have meta data in a cusomt field called 'artist', you could call this in you template with the
 * following. CMT::the_artist(). Or, to return a value, you could use CMT::get_the_artist(). 
 * Additional convenience function meta_exists() to check if post meta exists or not.
 * 
 */
class CMT {

     /**
      * __callStatic
      * 
      * If you have post meta that has a key of 'artist', you can retrieve the meta by calling the_artists(), 
      * or get_the_artists().
      * 
      * @param string $method name of you custom meta tag the_artist()
      * @param array $args Leave empty, required by _callStatic
      */
     public static function __callStatic($method, $args) {

          if (substr($method, 0, 4) === "the_") {

               echo get_post_meta(get_the_ID(), substr($method, 4), true);
               
          } else if (substr($method, 0, 8) === "get_the_") {

               return get_post_meta(get_the_ID(), substr($method, 8), true);
               
          } else if (substr($method, -7) === "_exists") {

               return get_post_meta(get_the_ID(), substr($method, 0, -7), true) === "" ? false : true;
               
          } else {
               
               return false;
          }
     }

}

/**
 * class CMT (Custom Taxonomy Tags)
 * 
 * Allows you to use custom taxonomys a template tags simliar to the WordPress syntax the_tags(). 
 * If you have a custom taxonomy called skill', you could call this in you template with the
 * following. CMT::the_artist(). Or, to return a value, you could use CMT::get_the_artist(). 
 * Additional convenience function tag_exists() to check if tag exists or not.
 * 
 * 
 */
class CTT {

     /**
      * __callStatic
      * 
      * If you have post meta that has a key of 'artist', you can retrieve the taxonomy by calling the_artists(), 
      * or get_the_artists().
      * 
      * @param string $method name of you custom taxonomony tag
      * @param array $args pass in before, seperator and after paramters like the_tags(), use get_the_tags() similarly
      */
     public static function __callStatic($method, $args) {

          if (substr($method, 0, 4) == 'the_') {

               $term = substr($method, 4);

               $list = self::handle_terms($term, $args);

               echo gettype($list) == "string" ? $list : '';
               
          } else if (substr($method, 0, 8) === "get_the_") {

               $term = substr($method, 8);
               
               if (count($args) === 0) {
                    
                    $terms = get_the_terms(get_the_ID() , $term);
                    
               } else {
                    
                    
                    $terms = get_the_terms($args[0] , $term);
               }

               return $terms && !is_wp_error($terms) ? $terms : NULL;
               
          } else if (substr($method, -7) === "_exists") {

               $obj = get_the_terms(get_the_ID(), substr($method, 0, -7));

               return $obj && !is_wp_error($obj) ? true : false;
               
          } else {
               
               return false;
          }
          
          
     }

     private static function handle_terms($term, $args) {
          
          $func_params = array(); 
          
          array_push($func_params , get_the_ID()); 
          
          array_push($func_params , $term); 
          
          $func_params = array_merge($func_params , $args); 
          
          $str = call_user_func_array('get_the_term_list', $func_params);

          return $str;
          
     }

}

?>
