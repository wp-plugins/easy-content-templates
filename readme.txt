=== Easy Content Templates ===
Contributors: japaalekhinllemos
Donate link: http://japaalekhin.llemos.com/easy-content-templates
Tags: content templates, writing, posts, templates
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: 1.1

This plugin lets you define content templates to quickly apply to new posts or pages.

== Description ==

Easy Content Templates is a plugin for WordPress that lets you define content templates to quickly apply to new or existings posts and pages. By default, templates are private to the author/creator only. Templates can be shared to other users by checking the "Make this Template available for others" checkbox. Other users can't edit your template, they can only use it.

[Visit plugin site &raquo;](http://japaalekhin.llemos.com/easy-content-templates-wordpress-plugin "Easy Content Templates WordPress Plugin by Japa Alekhin")

Special Thanks:

* Jonathan Le - for pointing out some bugs and suggesting a fix
* [WebNuggetz.com](http://www.webnuggetz.com/) - for helping me shape the plugin to be more usable and for pointing out a possible issue

== Installation ==

Just install like you normally do with a plugin.

1. Upload `easy-content-templates` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Done

== Frequently Asked Questions ==

= How do i insert them into my posts or pages? =

In your write screen look to the upper right and there's a box there. Select a template from the drop-down and click "Load Template".

= Nothing shows up in the drop-down list, what do i do? =

First you need to define your templates, go to the *Templates* section of your WordPress admin and create your templates there.

= Can i define multiple templates? =

Sure you can! ;) Templates are actually Custom Post Types so you can make a lot of templates.

== Screenshots ==

1. Step 1. Template Definition - You need to add templates first before you can use them.
2. Step 2. Template Usage - When creating (or editing) a post or page, there's an "Easy Content Template" box to the upper right. Select the template you want to load from the drop-down box and click "Load Template".

== Changelog ==

= 1.1 =
* changed the way the plugin fetches the ajax url to fix some issues
* removed filters when loading a template to disable processing shortcodes (and other codes)
* made the dropdown span the whole width of the container box so it looks better
* added check boxes below the dropdown for selective loading (title, content, excerpt)
* added a `-- select template --` item in the dropdown as first item
* made the templates private (to the author/creator) by default, with an option to make it public
* updated the readme file so tells you to upload `easy-content-templates` instead of `plugin-name.php`
* removed the limit of templates loaded in the dropdown

= 1.0 =
* added wp_enqueue_script('jquery') to init action to make sure jquery is loaded
* fixed readme so it provides more instructions and some screenshots

= 0.9 =
* creation

== Upgrade Notice ==

= 1.1 =
New features, safe update!

= 1.0 =
Upgrade as you like. Not much change here.

= 0.9 =
Don't upgrade! This is the first version. hehe