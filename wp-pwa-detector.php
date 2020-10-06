<?php
/**
 * Plugin Name: PWA Detector
 * Description: Pozwala na wykrycie zainstalowanej aplikacji PWA u użytkownika mobilnego.
 * Author: Sebastian Bort
 * Version: 1.0.0
 */
 
class WP_PWA_Detector {

        public function __construct() {
                add_action('wp_head', [$this, 'append_to_head_tag'], 99);
        }
        
        public function append_to_head_tag() {
        ?>
              <script>
               
                  var cookie_key = 'pwa-status';
                  var cookie_ttl_days = 7;  
                  var cookie_value = '0';
               
                  function is_pwa_installed() {
                        return ((window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://')) ? true : false;
                  }
                  
                  function set_cookie_value(cname, cvalue, exdays) {
                      var d = new Date();
                      d.setTime(d.getTime() + (exdays*24*60*60*1000));
                      var expires = "expires="+ d.toUTCString();
                      document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                  }
                  
                  jQuery(function($) {
                  
                        if(is_pwa_installed()) {                            
                            $('body').addClass('is-pwa');   
                            cookie_value = '1'; 
                        }                        
                        set_cookie_value(cookie_key, cookie_value, cookie_ttl_days);                         
                   });
              </script>
              
              <style>
              body.is-pwa .hide-when-pwa {
                  display:none !important;                  
              }
              body:not(.is-pwa):not(.elementor-editor-active) .hide-when-not-pwa {
                  display:none !important;         
              }
              </style>
        <?php 
        }   
}
 
new WP_PWA_Detector(); 
 
?>