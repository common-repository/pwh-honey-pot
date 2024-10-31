<div class="wrap">
    <h2><?php echo $this->plugin->displayName; ?> &raquo; <?php _e('Catch Spammers!', $this->plugin->name); ?></h2>
           
    <?php    
    if (isset($this->message)) {
        ?>
        <div class="updated fade"><p><?php echo $this->message; ?></p></div>  
        <?php
    }
    if (isset($this->errorMessage)) {
        ?>
        <div class="error fade"><p><?php echo $this->errorMessage; ?></p></div>  
        <?php
    }
    ?> 
    
    <div id="poststuff">
     <div id="post-body" class="metabox-holder columns-2">
          <!-- Content -->
          <div id="post-body-content">
                    <div id="normal-sortables" class="meta-box-sortables ui-sortable">                        
                     <div class="postbox">
                         <h3 class="hndle">Catch Spammers!</h3>
                         
                         <div class="inside">
                              <p>
                                        
                              Your Wordpress site is now catching spammers! Thank you!
                              <p>
                              You do not have to do anything else, we'll take it from here...
                              
<p>


                         </div>
                     </div>
                     <!-- /postbox -->
     
                    </div>
                    <!-- /normal-sortables -->
          </div>
          <!-- /post-body-content -->
          
          <!-- Sidebar -->
          <div id="postbox-container-1" class="postbox-container">  
	       <?php include_once(plugin_dir_path(__FILE__).'/../_modules/dashboard/views/sidebar-donate.php'); ?>
          </div>
          <!-- /postbox-container -->
     </div>
     </div>      
</div>