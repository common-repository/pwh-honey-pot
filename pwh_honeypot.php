<?php
/**
* Plugin Name: PWH Honey Pot
* Plugin URI: https://www.infobahn.co.za/
* Version: 1.0.5
* Author: InfoBahn
* Author URI: https://www.infobahn.co.za/
* Description: Adds a harvester and email honey pot to your site to catch spammers!
* License: GPL2
*/

/*  Copyright 2014 InfoBahn

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

// This code is based very heavily on the InsertHeadersAndFooters plugin by www.wpbeginners.com

/**
* PWH Honey Pot Class
*/
class PWH_HoneyPot {
     /**
     * Constructor
     */
     public function __construct() {
          // Plugin Details
        $this->plugin = new stdClass;
        $this->plugin->name = 'pwh_honeypot'; // Plugin Folder
        $this->plugin->displayName = 'PWH Honey Pot'; // Plugin Name
        $this->plugin->version = '1.0.5';
        $this->plugin->folder = WP_PLUGIN_DIR.'/pwh-honey-pot'; // Full Path to Plugin Folder
        $this->plugin->url = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
        
          
          // Hooks
          add_action('admin_init', array(&$this, 'registerSettings'));
        add_action('admin_menu', array(&$this, 'adminPanelsAndMetaBoxes'));
        
        // Frontend Hooks
          add_action('wp_footer', array(&$this, 'frontendFooter'));
     }
     
     /**
     * Register Settings
     */
     function registerSettings() {
          register_setting($this->plugin->name, 'pwh_spam_trap_email', 'trim');
          register_setting($this->plugin->name, 'pwh_spam_trap_email_date', 'trim');
     }
     
     /**
    * Register the plugin settings panel
    */
    function adminPanelsAndMetaBoxes() {
     add_submenu_page('options-general.php', $this->plugin->displayName, $this->plugin->displayName, 'manage_options', $this->plugin->name, array(&$this, 'adminPanel'));
     }
    
    /**
    * Output the Administration Panel
    * Save POSTed data from the Administration Panel into a WordPress option
    */
    function adminPanel() {
          // Load Settings Form
          include_once(plugin_dir_path(__FILE__).'/views/settings.php');
    }
    
    /**
     * Loads plugin textdomain
     */
     function loadLanguageFiles() {
          load_plugin_textdomain($this->plugin->name, false, $this->plugin->name.'/languages/');
     }
     
     /**
     * Outputs script / CSS to the frontend footer
     */
     function frontendFooter() {
          $this->output('pwh_spam_trap_email');
     }
     
     /**
     * Outputs the given setting, if conditions are met
     *
     * @param string $setting Setting Name
     * @return output
     */
     function output($setting) {
          // Ignore admin, feed, robots or trackbacks
          if (is_admin() OR is_feed() OR is_robots() OR is_trackback()) {
               return;
          }
          
          $UpdateDate = get_option("pwh_spam_trap_email_date");
          $Email = get_option("pwh_spam_trap_email");

          if( ($Email == "") || ($UpdateDate != date("Ymd")) )
          {
               try
               {
                         $options2 = array(
                    'uri' => 'http://dnsbl.phpwebhost.co.za',
                    'location' => 'http://dnsbl.phpwebhost.co.za/api/DNSBL.php',
                    'trace' => 1);

                    $client = new SoapClient(NULL, $options2);
                         $Email = $client->GetRandomEmailAddress($_SERVER["SERVER_NAME"]);

                    update_option('pwh_spam_trap_email_date', date("Ymd"), 'trim');
                    update_option('pwh_spam_trap_email', $Email, 'trim');
               }
               catch(Exception $e)      
               {
               
                    if(file_exists(dirname(__FILE__)."/errors.log"))
                    {
                         if(filesize(dirname(__FILE__)."/errors.log") > 5242880)
                         {
                              unlink(dirname(__FILE__)."/errors.log");
                         }
                    }
                    
                    file_put_contents(dirname(__FILE__)."/errors.log", "--------------------------------------\r\nError: ".date("Y-m-d H:i:s")."\r\n".$e."\r\n\r\n", FILE_APPEND);
                    $Email  = "john".date("YmdH")."@sm.softsmart.co.za";

                    // failures could cause big delays in page loads. Cache the default address to prevent page load issues (except for the 
                    // single load delay which caused this branch!)
                    update_option('pwh_spam_trap_email_date', date("Ymd"), 'trim');
                    update_option('pwh_spam_trap_email', $Email, 'trim');
                                        
               }
               if(trim($Email) == "")
               {
                    $Email  = "john".date("YmdH")."@sm.softsmart.co.za";

                    // failures could cause big delays in page loads. Cache the default address to prevent page load issues (except for the 
                    // single load delay which caused this branch!)
                    update_option('pwh_spam_trap_email_date', date("Ymd"), 'trim');
                    update_option('pwh_spam_trap_email', $Email, 'trim');                    
               }
          }


          echo "\r\n\r\n<!--\r\nEmail: ".$Email."<br>\r\n<a href=\"mailto:".$Email."\">".$Email."</a><br>\r\n-->\r\n\r\n";
     }
}
          
$pwh = new PWH_HoneyPot();
?>