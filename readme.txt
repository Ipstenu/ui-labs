=== UI Labs ===
Contributors: JohnONolan, Ipstenu
Tags: ui, admin design, experimental
Requires at least: 5.5
Tested up to: 5.6
Stable tag: 4.0
License: GPLv2 or later
Donate link: https://ko-fi.com/A236CEN/

Experimental WordPress admin UI features, shiny ones.

== Description ==

UI Labs is a plugin that offers experimental WordPress admin UI features with the aim of building upon and enhancing the default WordPress User Interface. All features are in a constant state of beta, there are no guarantees and a modern browser is mandatory!

These experiments are limited by their very nature and are mostly small tweaks via CSS to the display of the admin section in non-destructive ways. Some experiments are failures.

While using WordPress Multisite, the options are only configurable via the Network Admin. Yes, this means it's for all sites.

=== Features ===

Each experiment can be turned on and off from the plugin settings screen under TOOLS.

<strong>Colour-Coded Post Statuses</strong>

Ever had a page full of posts which were a mix of drafts, sticky posts, pending posts, and private posts? When you have a lot of different post statuses, it's hard to differentiate them all. Experiment #1 applies colour-coding to post statuses to make different types of posts easy to pick out with just a glance.

<strong>Warn if Plugins Are Old</strong>

If a plugin hasn't been updated in more than 2 years, you'll see an alert on the plugin list page.

<strong>More Toolbar Padding</strong>

Bringing a little more padding to the WP Toolbar. It also adds a little padding to the main content area to make everything feel a little more spacious.

<strong>Make Footers Great Again</strong>

Makes the admin footer look more like it did in WP 3.2.

<strong>Bigger Dashboard Fonts</strong>

Small fonts hurt. This will bump the default font sizes for those of us who need larger fonts.

<strong>Identify This Server</strong>

Sometimes, when developing sites locally, deploying them to a staging server, then deploying to a live server - it can become confusing as to which WordPress admin panel you're logged into. This can have disastrous consequences if you suddenly start deleting stuff on the live server cause you thought the current tab was the staging server. This allows you to enable colour coding for your different servers so that it's always obvious which one you're using right now.

=== Privacy Notes ===

No data is tracked by this plugin, nor is any additional user data stored.

== Installation ==

No special instructions.

== Screenshots ==

1. Experiment #1 - Colour-Coded Post Statuses
2. Experiment #2 - Better Spacing/Padding for the Toolbar
3. Experiment #3 - Adds a 3.2-esque admin footer
4. Experiment #4 - Server Identification
5. Experiment #5 - Larger WP-Admin fonts
6. Experiment #6 - Old Plugin Warnings

== FAQ ==

<strong>How do I change the server environment type?</strong>

You change it via the `WP_ENVIRONMENT_TYPE` define (introduced in WP 5.5).

Adding this to your `wp-config.php` will turn your site into a staging site:
`define( 'WP_ENVIRONMENT_TYPE', 'staging' );`

Currently only the default environments are supported.

<strong>Will you add X?</strong>

Maybe. It really depends on the value and potential usage.

<strong>Why is my site slow when I turn on Old Plugin Warning?</strong>

This happens if you have plugins hosted off of WordPress.org that do funny things with the check for updates. Basically they trigger the updater too many times, and in a way that kicks off this plugin. This should only slow down the plugin listing page, however, and no other pages.

<strong>Why are the settings only editable by the Network Admin on Multisite?</strong>

Because Multisite is a special thing.

== Changelog ==

= 4.0 (2020-08) =
* Added: Support for WordPress default environment types.
* PHPCS cleanup

(See Changelog.txt for older revisions)

== Upgrade Notice ==

= 4.0 =

Updated environment types to be based on the `WP_ENVIRONMENT_TYPE` define.
