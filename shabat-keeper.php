<?php
/*
 Plugin Name: Shabat keeper 
 Plugin URI: http://kosherdev.com/category/shabat-keeper/
 Description: Allows to turn off the Wordpress site, while Shabat of High Holidays are going on in your area.
 Version: 0.4.4
 Author: Misha Beshkin
 Author URI: http://kosherdev.com/
 */

/*
 This file is part of shabat-keeper.

    shabat-keeper is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    shabat-keeper is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with shabat-keeper.  If not, see <http://www.gnu.org/licenses/>.
 */

?>
<?php
include ("functions.php");
include ("hdate/hdate.php");

add_action('admin_menu', 'uc_adminMenu');
add_filter('admin_head','ShowTinyMCE');
function ShowTinyMCE() {
	// conditions here
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}

$nday="day";
if ($weekday == 6 && "$currentHour$currentMin" < "$resultHour_end$resultMin_end") $nday="shab";
elseif ($weekday == 5 && "$currentHour$currentMin" > "$resultHour$resultMin") $nday="shab";
elseif ($weekday >= 6  && $leftHour < 0 ) $nday="day";
//$nday="shab";

if ($nday == "shab") {
	if (get_option('shabat-keeperType')=='comments') {
//		add_action('init', 'ald_acc');
              add_action('comments_number','lock_comments');
		add_action('get_footer','ald_accHTML');

 	}else 
		add_action('get_header', 'uc_overrideWP');
	register_deactivation_hook(__FILE__, 'uc_remove');
}else {
	add_action('init', 'ald_acc_enable');
}

// Add message box to the top of page. this will be enabled in case only comments are locked.
function ald_accHTML() {
	require_once "message.php";
}

//Block display of comment form
function lock_comments () {
	include 'comment_style.php';
}

// Disable comments mechanism. Inspired by Autoclose plugin by Ajay D'Souza
function ald_acc() {
    global $wpdb;
    $poststable = $wpdb->posts;

        // Close Comments on posts

                $wpdb->query("
                        UPDATE $poststable
                        SET comment_status = 'closed'
                        WHERE comment_status = 'open'
                        AND post_status = 'publish'
                        AND post_type = 'post'
                ");
  //      }

}
function ald_acc_enable () {
    global $wpdb;
    $poststable = $wpdb->posts;
	$wpdb->query("
                        UPDATE $poststable
                        SET comment_status = 'open'
                        WHERE comment_status = 'closed'
                        AND post_status = 'publish'
                        AND post_type = 'post'
                ");
}

// Block site view. Inspired by underConstruction by Jeremy Massel
function uc_overrideWP()
{
    if (!is_user_logged_in())
    {
            require_once ('defaultMessage.php');
			die();
    }
}

function uc_adminMenu()
{
    add_options_page('Shabat Keeper Message', 'Shabat Keeper', 8, basename(__FILE__) , 'uc_changeMessage');
}

function uc_changeMessage()
{
	$options_ar=array("content"=>'shabat-keeperHTML', 
		"shklat"=>'shabat-keeperLat',
		"shklong"=>'shabat-keeperLong',
		"shkoffset"=>'shabat-keeperOffset',
		"shktype"=>"shabat-keeperType"
	);
	foreach ($options_ar as $opt=>$param) {
	if(isset($_POST[$opt])){
		if(trim($_POST[$opt])){
			update_option($param, attribute_escape($_POST[$opt]));
		}
		else{
			uc_remove($param);
		}
	}
		
	}
	
?>
<div class="wrap">
    <div id="icon-options-general" class="icon32">
        <br/>
    </div>
    <h2>Shabat Keeper</h2>
    <form method="post" action="<?php echo $GLOBALS['PHP_SELF'] . '?page=shabat-keeper.php'; ?>">
        <h3>Shabat Keeper Page HTML</h3>
	<label for="shktype">Select type of site lock:</label>
		<select name="shktype">
			<?
			$type_ar=array(
				"full"=>"Full lock",
				"comments"=>"Only Comments"
			);
			foreach ($type_ar as $opt=>$param){
				print '<option value="'.$opt.'" ';
				if ($opt == get_option('shabat-keeperType')) print 'selected="selected"';
				print '>'.$param.'</option>';
			}
			?>
		</select><br />
	<label for="shklat">Latitude</label><input name="shklat" value="<?php if(get_option('shabat-keeperLat')) echo get_option('shabat-keeperLat');?>">
	<label for="shklong">Longitude</label><input name="shklong" value="<?php if(get_option('shabat-keeperLong')) echo get_option('shabat-keeperLong');?>">
	<label for="shkoffset">GMTOffset</label><input name="shkoffset" value="<?php if(get_option('shabat-keeperOffset')) echo get_option('shabat-keeperOffset');?>">
		<p>Put in this area the HTML you want to show up on your front page</p>
	<!--div id='editorcontainer'>
        <textarea name="shkHTML" rows="15" cols="75" id='content'><?php if(get_option('shabat-keeperHTML')){echo ucGetHTML('shabat-keeperHTML');}?></textarea>
        <textarea name="events_pre_event" rows="15" cols="75" id='content'><?php if(get_option('shabat-keeperHTML')){echo ucGetHTML('shabat-keeperHTML');}?></textarea>
	</div-->
<?
if(get_option('shabat-keeperHTML')) $content_to_load=ucGetHTML('shabat-keeperHTML');
the_editor($content_to_load);?>
     
		<p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="Save Changes" id="submitCalendarAdd"/>
    	</p>
	</form>
</div>
<?php
}

/*function ucGetHTML($option)
{
	return stripslashes(html_entity_decode(get_option($option)));
}*/

function uc_remove($option){
	delete_option($option);
}
?>
