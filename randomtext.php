<?php
/*

Plugin name: Random Text
Plugin URI: http://www.pantsonhead.com/wordpress/randomtext/
Description: A widget to display randomized text on your site
Version: 0.1.2
Author: Greg Jackson
Author URI: http://www.pantsonhead.com

Copyright 2009  Greg Jackson  (email : greg@pantsonhead.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/


class randomtext extends WP_Widget {

	function randomtext() {
	  $widget_ops = array('classname' => 'randomtext',
                      'description' => ' Display randomized text from the selected category.');
		$this->WP_Widget('randomtext', 'Random Text', $widget_ops);
	}

	function get_randomtext($category='') {
		global $wpdb;
		$table_name = $wpdb->prefix . 'randomtext';
		
	  $sql = 'SELECT randomtext_id, text FROM '. $table_name." WHERE visible='yes' ";
		$sql .= ($category!='') ? " AND category = '$category'" : '' ;
		$sql .= ' ORDER BY timestamp, randomtext_id LIMIT 1 ';
		$row = $wpdb->get_row($sql);
		$snippet = $row->text;
		
		// update the timestamp of the row we just seleted
		$sql = 'UPDATE '.$table_name.' SET timestamp = Now() WHERE randomtext_id = '.$row->randomtext_id;
		$wpdb->query($sql);
		
		return $snippet;
	}

	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$category = empty($instance['category']) ? '' : $instance['category'];
		$footer = empty($instance['footer']) ? '' : $instance['footer'];
		$snippet = $this->get_randomtext($category);
		if($snippet!='') {
			echo $before_widget;
			if($title)
				echo $before_title.$title.$after_title;
			echo $snippet.$footer;
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
	  $instance = $old_instance;
	  $instance['title'] = strip_tags(stripslashes($new_instance['title']));
		$instance['category'] = strip_tags(strip_tags(stripslashes($new_instance['category'])));
		$instance['footer'] = stripslashes($new_instance['footer']);
	  return $instance;
	}
	
	function form($instance) {
		
	  $instance = wp_parse_args((array)$instance, array('title' => 'Random Text', 'category' => '', 'pretext' => '', 'posttext' => ''));
		
	  $title = htmlspecialchars($instance['title']);
	  $category = htmlspecialchars($instance['category']);
		$pretext = htmlspecialchars($instance['pretext']);
		$posttext = htmlspecialchars($instance['posttext']);
  
		echo '<p>
			<label for="'.$this->get_field_name('title').'">Title: </label><br />
			<input type="text" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$title.'"/>
			</p><p>
			<label for="'.$this->get_field_name('pretext').'">Pre-Text: </label><br />
			<input type="text" id="'.$this->get_field_id('pretext').'" name="'.$this->get_field_name('pretext').'" value="'.$pretext.'"/>
			</p><p>
			<label for="'.$this->get_field_name('category').'">Category: </label><br /><select id="'.$this->get_field_id('category').'" name="'.$this->get_field_name('category').'">
			<option value="">All Categories </option>';
		echo randomtext_get_category_options($instance['category']);
		echo '</select></p>
			<p>
			<label for="'.$this->get_field_name('posttext').'">Post-Text: </label><br />
			<input type="text" id="'.$this->get_field_id('posttext').'" name="'.$this->get_field_name('posttext').'" value="'.$instance['posttext'].'"/>
			</p> ';
	}
	
}

function randomtext($category){
	$randomtext = new randomtext;
	echo $randomtext->get_randomtext($category);
}

function randomtext_init() {
  register_widget('randomtext');
}

function randomtext_get_category_options($category='') {
	global $wpdb;
	$table_name = $wpdb->prefix . 'randomtext';
	$sql = 'SELECT category FROM '.$table_name.' GROUP BY category ORDER BY category';
	$rows = $wpdb->get_results($sql);

	foreach($rows as $row){
		$selected = ($category==$row->category) ? 'SELECTED' : '';
		$result .= '<option value="'.$row->category.'" '.$selected.'>'.$row->category.' </option>';
	}
	return $result;
}


function randomtext_install() {
	global $wpdb, $user_ID;
	$table_name = $wpdb->prefix . 'randomtext';
	// create the table if it doesn't exist 
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$sql = "CREATE TABLE `$table_name` (
			`randomtext_id` int(10) unsigned NOT NULL auto_increment,
			`category` varchar(32) character set utf8 NOT NULL,
			`text` text character set utf8 NOT NULL,
			`visible` enum('yes','no') NOT NULL default 'yes',
			`user_id` int(10) unsigned NOT NULL,
			`timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`randomtext_id`),
			KEY `visible` (`visible`),
			KEY `category` (`category`),
			KEY `timestamp` (`timestamp`) 
		)";
		$results = $wpdb->query( $sql );
		// add some test data
		$data = array ('category' => 'Installer', 'user_id'=> $user_ID, 'text' => 'Creativity is the ability to introduce order into the randomness of nature. - Eric Hoffer' );
		$wpdb->insert($table_name, $data);
		$data['text'] = 'So much of life, it seems to me, is determined by pure randomness. - Sidney Poitier';
		$wpdb->insert($table_name, $data);
	}
}

add_action('widgets_init', 'randomtext_init');
register_activation_hook(__FILE__,'randomtext_install');

if(is_admin())
	include 'randomtext_admin.php';

?>