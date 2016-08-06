=== Grid WUD ===
Contributors: wistudat.be
Plugin Name: Grid WUD
Donate Reason: Stand together to help those in need!
Donate link: https://www.icrc.org/eng/donations/
Description: Grid WUD adds responsive, customizable and dynamic grids, tiles, galleries & widgets to WordPress posts and pages.
Author: Danny WUD
Author URI: http://wistudat.be/
Plugin URI: http://wistudat.be/
Tags: grid, grids, tile, tiles, latest post, youtube, vimeo, video, gallery, responsive, slug, shortcode, slugs, post grids, post tiles, post grid, post tile, image grid, filter, image tile, display, list, page, pages, posts, post, query, custom post type
Requires at least: 3.6
Tested up to: 4.5
Stable tag: 1.2.1
Version: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==

= Welcome @ Grid WUD: Grids, Tiles, Galleries, Widgets & more! =

* **FREE version, updates, PRO support and new features!**
* Included: Widgets, Latest Post, Posts, Gallery, Custom post type, Vimeo or YouTube! 
* Different grid lay-outs possible on the same post/ pages.
* NEW: Change the Wordpress Gallery to **Grid WUD Gallery** with Light Box.
* NEW: Re-sizable tiles, grids and galleries.
* NEW: Load as grid/tile/gallery background: Full, Medium or Thumbnail images.

* More info [here](http://wp.wistudat.be/) in our online manual.

= About GRID WUD =

* It enables a shortcode which, when inserted in a page or post, creates a series of link grids corresponding to the posts in a certain category or tag.
* Do you have any question or do you need support? Click [here](https://wordpress.org/support/plugin/grid-wud)!
* See Grid WUD in [action](http://wistudat.be/)

== Installation ==

= Automatic installation: =

* The simplest way to install is to click on 'Plugins' then 'Add' and type 'Grid WUD' in the search field.

= Manual installation 1: =

1. Login to your website and go to the Plugins section of your admin panel.
1. Click the Add New button.
1. Under Install Plugins, click the Upload link.
1. Select the plugin zip file (grid-wud.x.x.x.zip) from your computer then click the Install Now button.
1. You should see a message stating that the plugin was installed successfully.
1. Click the Activate Plugin link.

= Manual installation 2: =

1. You should have access to the server where WordPress is installed. If you don't, see your system administrator.
1. Upload the plugin zip file (grid-wud.x.x.x.zip) up to your computer and unzip it somewhere on the file system.
1. Copy the "grid-wud" folder into the /wp-content/plugins directory of your WordPress installation.
1. Login to your website and go to the Plugins section of your admin panel.
1. Look for "Grid WUD" and click Activate.

= Usage =
* See at our [FAQ page](https://wordpress.org/plugins/grid-wud/faq/).

== Frequently Asked Questions ==

= How can i activate the grids? =
* **Standard schortcode**:
* You can use the following shortcode: [gridwud slug="cat_or_tag"] where "cat_or_tag" is the slug from the category or tag you want.
*
* **Optional shortcodes**:
* [grid="2"] to display x grids /category or tag, different number then defined in the settings from Grid WUD.
* [button="1"] to hide the read more button.
* [skip="x"] to skip x recent posts, where x is the quantity to skip.
* [shape="x"] change the layout to the corresponding layout.
* [nowidget="1"] force a post/page lay-out in a widget.
*
* **Custom Post Type schortcodes**:
* [cp="1"] or [cp="2"] to display all posts from the custom post type, where 1 or 2 is the title (can be set in the admin options/settings page).
* Sample: [gridwud slug="custom_post_type_name" cp="1"] or [gridwud slug="custom_post_type_name" cp="2"].

= Can i have support? =
> If you have any question or you need support, Get it directly [here](https://wordpress.org/support/plugin/grid-wud)!

= Visit our "How to use" page =
> Read [here](http://wp.wistudat.be/grid-wud-how-to-use/) our online manual.


== Changelog ==
= 1.2.1 =
* Critical update solving quantity maximum grids/tiles.

= 1.2.0 =
* Correction for "Nelio External Featured Image"
* Better image choice for video posts.
* Optimized CSS format for tablet, mobile devices .
* Grid WUD Gallery on mobile devices, now with close Light Box with swipe.
* Limit quantity words for excerpts: parameter.

= 1.1.9 =
* Resolved: Array error by thumbnails.
* Build grids/tiles with images from "Nelio External Featured Image".
* Update widget short code: removed unused argument.

= 1.1.8 =
* Show thumbnails, medium or full size images in the grid/tile/gallery
* Selector size images by grid/tile or gallery
* Full width grid/tile title when it's on top.

= 1.1.7 =
* Thumbnails instead full images possible by grids/tiles and/or galleries.
* Escape or enter key or mouse click, will close the lightbox preview by the gallery.
* Removed trailing spaces from all the source code pages, to avoid warnings.

= 1.1.6 =
* Removed trailing spaces from gallery PHP page.
* Use shortcode nowidget="1" to force post/page lay-out in a widget.
* Parameter to choose between thumbnails and full images in the gallery (pop-up image is always full size)
* Position: close preview gallery button adjusted.

= 1.1.5 =
* Grid WUD Gallery with Light Box popup images.
* Grid WUD Gallery: on/off.
* Light Box: on/off.
* Gallery image URL: on/off.

= 1.1.4 =
* The use of Grid WUD WIDGETS now even easier.
* The short code: widget="x" is not needed anymore.
* Removed gallery warning by no content.
* Possibility to resize the grids/tiles and galleries.

= 1.1.3 =
* Correction by save post/page action.

= 1.1.2 =
* Change the Wordpress Gallery to tiles or grids!
* CSS adjustment tiles and grids.

= 1.1.1 =
* Choose between the lay-out Grids or Tiles.
* Set shadow arround tiles (on/off).
* Read more button CSS values adjustment.
* Started merging of our plugins WP-Tiles-WUD and Grid-WUD, into Grid-WUD!

= 1.1.0 =
* New slug to display latest post from all categories and tags. Use: [gridwud slug="wud-latest"] to display the latest posts.
* Latest Posts Title, used if you add the shortcode: [gridwud slug="wud-latest"].
* Extra parameter "Target read more button": Grids or Archives to display.
* Extra parameter to change the target when clicking on a grid: 
* CSS z-index removed, which caused menu problems.

= 1.0.9 =
* Grid WUD WIDGETS.
* Add a short code to a text widget.
* Extra parameter: Split grids, set a space between the grids.
* Fix: button="1" short code back enabled.

= 1.0.8 =
* No switching pages anymore by "Read More" action!
* Read more button slides the requested grids down.
* Parameter to enable Title URL's: by clicking the title, you wil be redirected to the the category or tag.
* Better responsive results.

= 1.0.7 =
* Grid Title position: top, center, bottom, cover.
* Grid Title align: left, center, right.

= 1.0.6 =
* Extra option: show post title only by excerpts.

= 1.0.5 =
* Possibility of placing rounded corners around the grids or buttons.
* Parameter to determine size of the rounded corners.
* Font family selection (10) for the header, excerpt and/or button. [on request](https://wordpress.org/support/topic/it-works-with-external-featured-images#post-8494039).

= 1.0.4 =
* FIX: Correction on custom code, where nothing was displayed.

= 1.0.3 =
* CSS responsive code optimized to switch lay-outs.
* Use different grid lay-outs on 1 page/post with shortcode shape="x" where x is the lay-out number.
* Custom code added upon request, read [here](https://wordpress.org/support/topic/it-works-with-external-featured-images#post-8486919).

= 1.0.2 =
* Prepare Multilanguage.

= 1.0.1 =
* First release!


== Upgrade Notice ==
* You do not need to change anything to the current configuration.
	
	
== Screenshots ==
1. Grids on Frontend.
2. Tiles on Frontend.
3. Admin menu
4. Grid WUD WIDGETS (even with latetst post)