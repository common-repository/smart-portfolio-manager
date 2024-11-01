=== Smart Portfolio Manager - Product Catalog Listing ===
Contributors: AppAspect
Tags: resposive smart portfolio, smart portfolio, Custom Post Type, portfolio layout, grid layout portfolio, smart portfolio plugin, smart portfolio gallery, smart portfolio slider, responsive portfolio, portfolio showcase, wp portfolio
Requires at least: 5.6
Tested up to: 6.4
Requires PHP: 7.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fully Responsive and Mobile Friendly Portfolio for WordPress to showcase Your portfolio in Grid view.

== Description ==
Smart Portfolio Manager is an excellent plugin that is designed to work with any WordPress website. It is a straightforward plugin that assists you in creating a custom post-type portfolio. Once installed, you can easily display your work in a separate category and organize it by portfolio categories and terms. This plugin helps you present your work in a way that is attractive and visually appealing. With the Smart Portfolio Manager plugin, it's easy to add images along with other details to your portfolio. Furthermore, the plugin also allows you to load a portfolio with a grid layout, which makes it easier to showcase your work to your audience. You can customize your portfolio according to your preferences, thereby providing a unique essence to your website. So, if you're looking for the perfect plugin to display your work in an elegant way, the Smart Portfolio Manager is a great choice. 

###Features
* Shortcodes for showing anywhere on Page and Post
* Custom Portfolio Post Type
* Portfolio Gallery
* Lightbox
* Responsive Design
* Grid Layout (3 columns)
* Controlling Options
* Show/Hide Specific category terms

## Shortcodes
#### Default Shortcode
[spmpcl_post_grid]

#### Control Number of Portfolio Per Page
Options: Options: -1 for all Portfolio
Default: 10 (WordPress Default)
[spmpcl_post_grid posts_per_page="6"]

#### Show/Hide Specific Category Terms
Options: 1,2,3,4 (Comma Seprate ID)
Default: ""
[spmpcl_post_grid category="10,20,30,40"]
or
[spmpcl_post_grid terms="101,201,301,401"]

#### Post Order
Options: ASC, DESC
Default: DESC
[spmpcl_post_grid order="DESC"]

#### Post Orderby
Default: Options: menu_order, ID, title
Default: menu_order
[spmpcl_post_grid orderby="menu_order"]

for more info: [Visit Official Document](https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters)

== Installation ==
= Automatic installation =

To automatically install Smart Portfolio Manager, log in to your WordPress dashboard, navigate to the Plugins menu, and click “Add New.”

In the search field type “Smart Portfolio Manager - Product Catalog Listing” and then click “Search Plugins.” Once you’ve found us,  Click “Install Now,” and WordPress will take it from there.

= Manual installation =

The manual installation method requires downloading the Smart Portfolio Manager, plugin and uploading it to your web server via FTP application.(Upload "smart-portfolio-manager.zip" to the "/wp-content/plugins/" directory.) The WordPress codex contains [instructions on how to do this here](https://wordpress.org/support/article/managing-plugins/#manual-plugin-installation).

== Frequently Asked Questions ==

= Will Smart Portfolio Manager work with my theme? =
Yes! Smart Portfolio Manager will work with any theme.

= My site broke – what do I do? =
If you noticed the error after install Smart Portfolio Manager, there could be a conflict between Smart Portfolio Manager and an outdated theme or plugin.

= Where can I report bugs? =
You can post details on the support forum

= How to use it? =
use this shortcode: [spmpcl_post_grid] in page or post
Use shortcode in a PHP file (outside the post editor). 
<?php echo do_shortcode('[spmpcl_post_grid]'); ?>

== Screenshots ==
1. Portfolio Detail Page
2. Portfolio Slider
3. Portfolio Grid Layout
4. Portfolio Custom Post Type


== Changelog ==
= 1.0.0 =
* Initial Release

== Upgrade Notice ==
Automatic updates should work perfectly, but we still recommend you back up your site.

If you encounter issues with after an update, flush the permalinks by going to WordPress > Settings > Permalinks and hitting “Save.” That should return things to normal.