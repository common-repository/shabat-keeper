=== Shabat Keeper ===
Contributors: Misha Beshkin
Tags: sabbath, shabbat, shabat, jewish, judaism, comments, lock, site
Requires at least: 2.7
Tested up from : 2.8.3
Stable tag: 0.4

Allows to turn off the Wordpress site, while Shabat of High Holidays are going on in your area.

== Description ==

Allows to turn off the Wordpress site, while Shabat of High Holidays are going
on in your area.

== Installation ==

1. Upload the folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. If you want to change the look of the page that is displayed, click Settings->Shabat Keeper enter the HTML for the page you want to show up.

== Frequently Asked Questions ==

= What kind of HTML can I put in? =

You enter the contents of the entire HTML file. You can include inline styles, or links to external style sheets and external images.

= How to set my location? =
Enter Lattitude, Longitude and Offset to proper boxes in Setup page. 

== Changelog ==
= 0.4.4 =
- in case IP location is not detected time of Server is used. Add your server location in configuration page.
- changed mechanism of locking comments. Now comment form section is not displayed in page, using styling. 

= 0.4.3 =
- fixed issue with current time detection. Current time was reported without Offset difference.
- corrected plugin URL

= 0.4.2 =
- reports city, state and country of visitor

= 0.4.1 = 
- determine shabat time by user's IP/location.

= 0.4 =
current release

= 0.3.3 =
- text area now uses tinyMCE for adding message to locked page.

= 0.3.2 =
- Added message to display in case comments are locked

= 0.3.1 =
- time will be detected according to UTC +/- current offset

= 0.3 =
- added functionality to close comments on shabat and open on ordinary day.
  Thanks to Autoclose plugin
(http://ajaydsouza.com/wordpress/plugins/autoclose/) by Ajay D'Souza for idea
on implementation.
- added selector for Full lock and Only comments.

= 0.02 =
- added Shabat date calculations
- modified default page 

= 0.01 =
- Forked underConstruction by Jeremy Massel plugin

== TODO ==

== Screenshots == 
