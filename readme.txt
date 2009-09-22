=== Random Text ===
Contributors: pantsonhead
Donate link: http://www.amazon.co.uk/gp/registry/1IX1RH4LFSY4W
Tags: widget, plugin, sidebar, random, text, quotes
Requires at least: 2.8
Tested up to: 2.8.4
Stable tag: trunk

Store and display random/rotated text by category in sidebar widget or templates.

== Description ==

RandomText is a handy WordPress plugin that allows you to save, edit and delete categorized text, and inject random/rotated text by category into the sidebar (via widget) or page body (via template tags). The sidebar widget allows you to set an optional Title, and text header and footer. You could say RandomText picks up where the Text widget left off. Whether you want to display random/rotated trivia, quotes, helpful hints, featured articles, or snippets of html, you can do it all easily with RandomText.

== Installation ==

IMPORTANT: This plugin uses the WP_Widget class introduced in WordPress v2.8 and will not work with earlier versions of WordPress.

1. Upload `randomtext.php` and `randomtext_admin.php` to the `/wp-content/plugins/` directory of your WordPress installation
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The Random Text widget can now be configured and used from the Appearance -> Widgets menu
4. Text entries can be managed via from the Settings -> Random Text menu

Note: During installation, Random Text creates a new database table to store the entries by category  - you should see two test records after installation by clicking on the Settings -> Random Text menu.

== Screenshots ==

1. Sidebar widget options
2. Text management page

== Changelog ==

= v0.2.3 2009-09-22 =

* Added Bulk Insert option
* Improved handling of "No Category" items

= v0.2.2 2009-08-23 =

* Added record id check before timestamp update 

= v0.2.1 2009-08-22 =

* Added database table check/error to admin page

= v0.2 2009-08-22 =

* Added random/rotation option
* Added screenshots

= v0.1.4 2009-08-19 =

* Fixed admin path bug

= v0.1.3 2009-08-18 =

* Fixed Pre-text/Post-text bug

= v0.1.2 2009-08-16 =

* Fixed editing issues
* Minor correction to readme.txt

= v0.1.1 2009-08-14 =

* Minor corrections to readme.txt

= v0.1 2009-08-11 =

* Initial release
