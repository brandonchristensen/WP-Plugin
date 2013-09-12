<?php
/*
Plugin Name: Game Handles
Plugin URI: http://pluginreadme.bchristensendesigns.com/
Description: Plugin to display game handles for the popular gaming systems.
Author: Brandon Christensen
Version: 1.0
Author URI: http://bchristensendesigns.com
License:  Copyright 2013  Brandon Christensen  (email : brandon.j.christensen@gmail.com)

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


////////// Include a CSS stylesheet ////////////////

function gamehandler_add_styles() {
    echo '<style rel="stylesheet" type="text/css">';
    include 'css/styles.css';
    echo '</style>';
}


//////////// Start of Plugin ///////////////////

class wp_my_plugin extends WP_Widget {

    // Constructor
    function wp_my_plugin(){
//defines the widget name
        $widget_ops = array ( 'classname' => 'Game Handles', 'description' => __( "Widget to display game handles for popular gaming systems" ) );
        //parent::WP_Widget(false, $name = __('Game Handler', 'wp_widget_plugin'));
          parent::WP_Widget('game-handles', __( 'Game Handles' ), $widget_ops);
    }

    // Create Widget in admin panel
    function form( $instance ) {
        if ( $instance ) {
            $title = esc_attr( $instance['title']);
            $text = esc_attr( $instance['text']);
            $radio = esc_attr( $instance['radio']);
            $radio2 = esc_attr( $instance['radio']);
            $radio3 = esc_attr( $instance['radio']);
        } else {
            $title = '';
            $text = '';
            $radio = '';
            $radio2 = '';
            $radio3 = '';
        }
        ?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value='<?php echo $title; ?>' />
</p>
<p>
<input id="<?php echo $this->get_field_id('radio'); ?>" name="<?php echo $this->get_field_name('radio'); ?>" type="radio" value="1" <?php checked( '1', $radio ); ?> />
<label for="<?php echo $this->get_field_id('radio'); ?>"><?php _e('All in one Dropdown', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input id="<?php echo $this->get_field_id('radio2'); ?>" name="<?php echo $this->get_field_name('radio'); ?>" type="radio" value="2" <?php checked( '2', $radio2 ); ?> />
<label for="<?php echo $this->get_field_id('radio'); ?>"><?php _e('User dropdown only', 'wp_widget_plugin'); ?></label>
</p>
<p>
<input id="<?php echo $this->get_field_id('radio3'); ?>" name="<?php echo $this->get_field_name('radio'); ?>" type="radio" value="3" <?php checked( '3', $radio3 ); ?> />
<label for="<?php echo $this->get_field_id('radio'); ?>"><?php _e('Search Form', 'wp_widget_plugin'); ?></label><br />
</p>


<?php
    }

    // Widget Update
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['text'] = strip_tags($new_instance['text']);
        $instance['radio'] = strip_tags($new_instance['radio']);
        $instance['radio2'] = strip_tags($new_instance['radio2']);
        $instance['radio3'] = strip_tags($new_instance['radio3']);
        return $instance;

    }

    // Widget Display (on frontend of website)
    function widget($args, $instance) {
      global $current_user;
      //$max_users = $d_max_users;
      extract( $args );

       // these are the widget options
       $title = apply_filters('widget_title', $instance['title']);
       $radio = $instance['radio'];
       $radio2 = $instance['radio2'];
       $radio3 = $instance['radio3'];
       echo $before_widget;

       // Display the widget
       echo '<div class="widget-text wp_widget_plugin_box">';

      // Greeting 
          if (is_user_logged_in()) {
            gamehandler_add_styles();
            echo '<h1>Welcome, '; 
            get_currentuserinfo();
            echo $current_user->display_name;
            echo '</h1>';


//////////////////// Update tags / Log Out  ////////////////////////////////
?>
      <script language="javascript"> 
      function toggle() {
          var ele = document.getElementById("toggleText");
          var text = document.getElementById("displayText");
          if(ele.style.display == "block") {
                  ele.style.display = "none";
              text.innerHTML = "Update";
          }
          else {
              ele.style.display = "block";
              text.innerHTML = "Hide";
          } 
      } 
      </script>
      <div class="update_logout"><a id="displayText" href="javascript:toggle();">Update</a> | <a href='/wp-login.php?action=logout' title='Log out'>Log out</a></div>

      <br />
      <br />
      <?php 
        $all = get_users();
        foreach ( $all as $um ) {
                  $pxbox = get_user_meta( $current_user->ID, 'xbox_name', true );
                  $ppsn = get_user_meta( $current_user->ID, 'psn_name', true );
                  $pwii = get_user_meta( $current_user->ID, 'wii_name', true );
                  $psteam = get_user_meta( $current_user->ID, 'steam_name', true );
      ?>
      <div id="toggleText" style="display: none">
          <h3>Update your Gaming Names here!</h3><br />
          <form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">
            <!-- Xbox field -->
            <div class="xbox_title_update"><label><?php _e('Xbox:'); ?></label></div>
              <div class="update_xbox_field"><input id="xbox_update" name="xbox_update" type="text" size="23" value="<?php echo $pxbox; ?>"></div>
           <!-- PSN field -->
            <div class="psn_title_update"><label><?php _e('PSN:'); ?></label></div>
              <div class="update_psn_field"><input id="psn_update" name="psn_update" type="text" size="23" value="<?php echo $ppsn; ?>"></div>
            <!-- Wii field -->
            <div class="wii_title_update"><label><?php _e('Wii:'); ?></label></div>
              <div class="update_wii_field"><input id="wii_update" name="wii_update" type="text" size="23" maxlength="16" value="<?php get_user_meta( $um->ID, 'xbox_name', true ); ?>"value="<?php echo $pwii; ?>"></div>
            <!-- Steam field -->
            <div class="steam_title_update"><label><?php _e('Steam:'); ?></label></div>
              <div class="update_steam_field"><input id="steam_update" name="steam_update" type="text" size="23" value="<?php echo $psteam; ?>"></div><br /><br />
              <div class="update_button"><input type="submit" name="Submit" value="Update"></div>
          </form>
      </div><br />
<?php
        } // end foreach loop for update game handles


//////////////////////End update window//////////////////


          if ( $title ) {
            echo "<h2>". $title . "</h2>";
            echo "<br /><br />";
          }

////////////////////////End Greeting////////////////////////

            if(isset($_POST['Submit'])){
              $new_xbox = $_POST['xbox_update'];
              $new_psn = $_POST['psn_update'];
              $new_wii = $_POST['wii_update'];
              $new_steam = $_POST['steam_update'];

              update_user_meta( $current_user->ID, 'xbox_name', $new_xbox );
              update_user_meta( $current_user->ID, 'psn_name', $new_psn );
              update_user_meta( $current_user->ID, 'wii_name', $new_wii );
              update_user_meta( $current_user->ID, 'steam_name', $new_steam );
            }
        
            // Check if radio is set
             if( $radio AND $radio == '1' ) {

///////////////////// Displays All in one Drop down  ////////////////////////   

               $all = get_users();
               echo '<div class="dropdown_title">Game Handlers</div><br />';
               echo "<div class='dropdown_menus'>";
               // Xbox field
               echo 'Users:<br /><div class="dropdown_users"><select name="xbox">';
                  foreach ( $all as $u ) {
                    echo '<option value="'.$u->ID.'">'.$u->user_login."</option>";
                    if ( $x = get_user_meta( $u->ID, 'xbox_name', true ) ) {
                      echo '<option> -- Xbox: '.$x."</option>";
                    } // end 
                    if ( $x = get_user_meta( $u->ID, 'psn_name', true ) ) {
                      echo '<option> -- Psn: '.$x."</option>";
                    } // end if
                    if ( $x = get_user_meta( $u->ID, 'wii_name', true ) ) {
                      echo '<option> -- Wii: '.$x."</option>";
                    } // end if
                    if ( $x = get_user_meta( $u->ID, 'steam_name', true ) ) {
                      echo '<option> -- Steam: '.$x."</option>";
                    } // end if
                  } // end foreach
               ?>
               </select>
               </div> <!-- End div dropdown_users -->
               <br />
               </div> <!--End div dropdown_menus -->
               <?php
///////////////////// User dropdown only /////////////////////////               
             } else
             if( $radio AND $radio == '2' ) {
               $au = get_users();
               echo '<div class="dropdown_title">Game Handlers</div><br />';
               echo "<div class='dropdown_menus'>";
               echo 'Xbox:<br /><div class="dropdown_xbox"><select name="xbox">';
               foreach ( $au as $u ) {
                    echo '<option value="'.$u->ID.'">'.$u->user_login."</option>";
               } // end foreach
               echo get_user_meta($u->ID, 'xbox_name', true);
               ?>
               </div><br />
            <?php

///////////////////// Search Users ////////////////////////
            } else
            if( $radio AND $radio == '3' ) {
                $all_users = get_users();
                ?>
                
                <div class="search_box_form"><form method="post" action="<?php echo $_SERVER[PHP_SELF];?>">
                  <div class="search_box_title"><label><?php echo "Search Display names here:"; ?></label></div>
                  <div class="search_box_input"><input id="user_search" name="user_search" type="text"></input></div>
                  <div class="search_box_search"><input type="submit" name="Search" value="Search"></input></div>
                </form>
              </div>
                <?php
                if(isset($_POST['Search'])){
                  $typed_request = $_POST['user_search'];
                } //if (isset)

                $shown = false;
                foreach ($all_users as $um ){
                  
                  $u_nickname = get_user_meta( $um->ID, 'nickname', true );
                  $rxbox = get_user_meta( $um->ID, 'xbox_name', true );
                  $rpsn = get_user_meta( $um->ID, 'psn_name', true );
                  $rwii = get_user_meta( $um->ID, 'wii_name', true );
                  $rsteam = get_user_meta( $um->ID, 'steam_name', true );
                  
                  if ( strtolower( $typed_request ) == strtolower( $u_nickname ) ){
                    echo "<div class='search_title'>Information on ". $um->nickname . "</div><br />";
                    echo "<div class='search_results'>";
                    echo "<div class='search_title_xbox'><li>Xbox: </div>" . "<div class='search_result_xbox'>" .$rxbox . "</li></div><br />";
                    echo "<div class='search_title_psn'><li>PSN: </div>" . "<div class='search_result_psn'>" .$rpsn . "</li></div><br />";
                    echo "<div class='search_title_wii'><li>Wii: </div>" . "<div class='search_result_wii'>" .$rwii . "</li></div><br />";
                    echo "<div class='search_title_steam'><li>Steam: </div>" . "<div class='search_result_steam'>" .$rsteam . "</li></div><br /><br />";
                    echo "</div>";
                    $shown = true;
                  } // end if 
                } // for foreach
                  if ( strtolower( $typed_request ) != strtolower( $u_nickname ) && !$shown && isset($_POST['Search']) ){
                    echo "<div class='error_message'>Didn't find any users that match that spelling. Try again!</div><br />";
                    $shown = true;
                  } // end else
                  echo "</div>"; // end search_box_form
              } // end else for radio button
            } // end if logged in
        else {
          gamehandler_add_styles();
          echo "<div class='welcome_letter'>Welcome, guest!</div><br />";
          echo  "<div class='login_register'><li><a href='/wp-login.php'>Login/Register</a></li></div>";
          } 
} //End function
} //End Class wp_my_plugin


// Register Widget
add_action('widgets_init', create_function('', 'return register_widget("wp_my_plugin");'));

?>
