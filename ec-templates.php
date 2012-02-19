<?php
/*
Plugin Name: Easy Content Templates
Plugin URI: http://japaalekhin.llemos.com/easy-content-templates
Description: This plugin lets you define content templates to quickly apply to new posts or pages.
Version: 1.1
Author: Japa Alekhin Llemos
Author URI: http://japaalekhin.llemos.com/
License: GPL2

Copyright 2011  Japa Alekhin Llemos  (email : japaalekhin@llemos.com)

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

class ec_templates {

// Internals *******************************************************************
    
    const post_meta_key_public = 'ect-template-is-public';

// Essentials ******************************************************************
    
    static function exists($id){
        global $wpdb;
        return $wpdb->get_var("SELECT `id` FROM `" . $wpdb->posts . "` WHERE `id` = '" . intval($id) . "' AND `post_type` = 'ec-template'") != null;
    }
    
    static function get_template($id){
        if(!self::exists($id)) return array('success' => false, 'message' => 'Template does not exist!');
        $template = get_post($id);
        return array(
            'success' => true,
            'message' => 'Template loaded!',
            'title' => $template->post_title,
            'content' => $template->post_content,
            'excerpt' => $template->post_excerpt,
        );
    }

// Actions *********************************************************************

    static function action_init(){
        register_post_type('ec-template', array(
            'label' => 'Template',
            'labels' => array(
                'name' => 'Templates',
                'singular_name' => 'Template',
                'add_new' => 'Add New',
                'all_items' => 'Templates',
                'add_new_item' => 'Add New Template',
                'edit_item' => 'Edit Template',
                'new_item' => 'New Template',
                'view_item' => 'View Template',
                'search_items' => 'Search Templates',
                'not_found' => 'No templates found',
                'not_found_in_trash' => 'No templates found in trash',
                'menu_name' => 'Templates',
            ),
            'description' => 'AWM Shop - Products',
            'publicly_queryable' => true,
            'exclude_from_search' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports' => array(
                'title', 'editor', 'thumbnail',
            ),
        ));
        wp_enqueue_script('jquery');
    }
    
    static function action_add_meta_boxes(){
        $post_types = get_post_types(array(), 'objects');
        foreach($post_types as $post_type){
            if($post_type->show_ui){
                if($post_type->name == 'ec-template'){
                    add_meta_box('mtb_ec_templates', 'Easy Content Template', array('ec_templates', 'action_metabox_render_template'), $post_type->name, 'side', 'high');
                }else{
                    add_meta_box('mtb_ec_templates', 'Easy Content Template', array('ec_templates', 'action_metabox_render_allothers'), $post_type->name, 'side', 'high');
                }
            }
        }
    }
    
    static function action_save_post($post_id, $post = null){
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if(null != $post && 'ec-template' != $post->post_type) return;
        if('page' == $_POST['post_type'])
            if(!current_user_can('edit_page', $post_id)) return;
        else
            if(!current_user_can('edit_post', $post_id)) return;

        // OK, we're authenticated: we need to find and save the data
        update_post_meta($post_id, self::post_meta_key_public, isset($_POST['ect_make_public']) && $_POST['ect_make_public'] == 1);
    }
    
    static function action_metabox_render_template(){
        ob_start();
        include plugin_dir_path(__FILE__) . 'ect-metabox-template.php';
        echo ob_get_clean();
    }
    
    static function action_metabox_render_allothers(){
        ob_start();
        include plugin_dir_path(__FILE__) . 'ect-metabox-allothers.php';
        echo ob_get_clean();
    }
    
    static function action_ajax_ect_get_template(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        echo json_encode(self::get_template(isset($_POST['template_id']) ? intval($_POST['template_id']) : 0));
        exit;
    }

// Filters *********************************************************************

    static function filter_posts_where($where){
        if(is_admin()){
            global $typenow;
            if($typenow == 'ec-template') $where .= " AND `post_author` = '" . get_current_user_id() . "'";
        }
        return $where;
    }

// Template Tags ***************************************************************

// Shortcodes ******************************************************************

}

add_action('init',                              array('ec_templates',   'action_init'),                 1000);
add_action('add_meta_boxes',                    array('ec_templates',   'action_add_meta_boxes'),       1000);
add_action('save_post',                         array('ec_templates',   'action_save_post'));
add_action('wp_ajax_nopriv_ect_get_template',   array('ec_templates',   'action_ajax_ect_get_template'));
add_action('wp_ajax_ect_get_template',          array('ec_templates',   'action_ajax_ect_get_template'));
add_filter('posts_where',                       array('ec_templates',   'filter_posts_where'));
?>