=== UI Labs ===
Contributors: JohnONolan, Ipstenu
Tags: ui, admin design, experimental
Requires at least: 3.2
Tested up to: 4.1
Stable tag: 2.1
License: GPLv2 or later 

Experimental WordPress admin UI features, shiny ones.

== Description ==

UI Labs is a plugin that offers experimental WordPress admin UI features with the aim of building upon and enhancing the default WordPress User Interface. All features are in a constant state of beta, there are no guarantees and a modern browser is mandatory!

These are unofficial Core UI experiments - who knows what could happen?

= Features =

Each experiment can be turned on and off from the plugin settings screen under TOOLS.

<strong>Colour-Coded Post Statuses</strong>

Ever had a page full of posts which were a mix of drafts, stickied posts, pending posts, and private posts? When you have a lot of different post statuses, it's hard to differentiate them all. Experiment #1 applies colour-coding to post statuses to make different types of posts easy to pick out with just a glance.

<strong>Toolbar Padding</strong>

Bringing a little more padding to the WP Toolbar, as well as a more 3.2- type footer. It also adds a little padding to the main content area to make everything feel a little more spacious.

<strong>Server Identification</strong>

<em>This is a developer feature.</em>

Sometimes, when developing sites locally, deploying them to a staging server, then deploying to a live server - it can become confusing as to which WordPress admin panel you're logged into. This can have disastrous consequences if you suddenly start deleting stuff on the live server cause you thought the current tab was the staging server. This allows you to enable colour coding for your different servers so that it's always obvious which one you're using right now.

<strong>Larger WP-Admin Fonts</strong>

Small fonts hurt. This will bump the default font sizes for those of us who need larger fonts.

== Installation ==

No special instructions.

== Screenshots ==

1. Experiment #1 - Colour-Coded Post Statuses
2. Experiment #2 - Better Spacing/Padding for the Toolbar
3. Experiment #3 - Server Identification
4. Experiment #4 - Larger WP-Admin fonts for old people

== Changelog ==

= 2.1 (2015-02-11) =

* Changed: CSS trickery to show the scheduled posts with a fake button
* Fixed: Array state of stupidity with post states

= 2.0 (2015-01-26) =
* Notice: Forked from original by John O'Nolan with the intent to merge and/or take over.
* Changed: Removed images in order to use Dashicons instead.
* Changed: Moved CSS to subfolder for organization.
* Changed: Moved settings page to Tools.
* Changed: Modernized code via singleton, settings UI, shared options (upgrade will keep 'em intact).
* Fixed: Proper use of plugins_url (we should never be calling our plugin folder by name).
* Fixed: Removed post-format images since that's in core now.
* Fixed: Experiment number 2, updated for the WP 4.0 world.
* Updated: Screenshots
* New: Experiment number 4, larger fonts for old people

= 1.2 (2011-10-05) =
* New: Experiment number 3, server identification colour coding. Adds a coloured bar to the top of WP admin to easily identify when you're editing dev/staging/live site.

= 1.1.3 (2011-08-21) =
* Fixed: Bug where post titles were invisible for non admin users. Props RyanImel.

= 1.1.2 (2011-07-20) =
* New: Experiment #1 support for Custom Post Formats with new icons.
* New: Classic admin footer bar also added to experiment #2.
* Fixed: Background labels made properly invisible with new WordPress 3.2 table bg colors.
* Fixed: Display errors with new admin header when using menu in collapsed mode.
* Fixed: Experiments will now automatically turn on when the plugin is activated.

= 1.1.1 (2011-07-16) =
* Fixed: CSS bug in new admin header
* Fixed: Ollie swearing on the settings page. Bad Ollie.

= 1.1 (2011-07-15) =
* New: The second UI Labs experiment, brings back a more traditional WordPress admin header. WARNING: Minimum version for this plugin is now WordPress 3.2.
* New: Settings screen to enable/disable individual experiments. Special thanks to Ollie Read for this.

= 1.0.2 (2011-07-06) =
* New: WordPress 3.2 compatibility
* Fixed: Bug where there was no margin between post status labels and post titles.
* Fixed: Bug where "Header image" labels were being made invisible on the Media management page.

= 1.0.1 (2011-03-23) =
* New: Support for Private and Password protected post statuses.
* Fixed: Support for multiple post statuses
* Screenshot: http://cl.ly/5RgI

= 1.0 (2011-03-23) =
* New: The first experiment! Colour-Coded Posts Statuses, making it easier to pick out Sticky, Pending, and Draft posts from the edit-posts screen. Mmmmmm shiny.