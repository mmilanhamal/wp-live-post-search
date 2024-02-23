=== WP Live Post Search ===
Contributors: saurav.rox, mhamal, lilasmita, bibeksth, anupshakya, srextasagar32, nabinjaiswal, sandeepregmi 
Tags: live, live search, ajax, ajax search, search, post
Requires at least: 4.1
Tested up to: 5.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin provides a search form which provides live search functionality of any posts/pages.

== Description ==

WP Live Post Search is a really handy plugin which provides live search functionality. The plugin provides a search form and anything entered will be searched live through all the posts/pages and page/post title with link is displayed as result. 

== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `wp-live-post-search.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `wp-live-post-search.zip`
2. Extract the `wp-live-post-search` directory to your computer
3. Upload the `wp-live-post-search` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= How to use? =
*Using Shortcode: Use <pre>[WPLS_SEARCH_FORM]</pre> to display the search form any where in your site including posts/pages or widget.

= How to change what to search? =
*Paste the below code to your theme's functions.php file:
<pre>
&lt;?php
function change_the_search_post_type()
{
	$posttype= 'post'; //change according to the requirement on what to search
	return $posttype;
}
add_filter('wpls_change_post_type_search','change_the_search_post_type');
?&gt;
</pre>

== Changelog ==
= 1.0.0 =
* Initial release

== Upgrade Notice ==
WP Live Post Search