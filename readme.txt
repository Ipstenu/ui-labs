=== UI Labs ===
Contributors: JohnONolan, Ipstenu
Tags: ui, admin design, experimental
Requires at least: 4.0
Tested up to: 4.6
Stable tag: 2.2.4
License: GPLv2 or later

Experimental WordPress admin UI features, shiny ones.

== Description ==

UI Labs is a plugin that offers experimental WordPress admin UI features with the aim of building upon and enhancing the default WordPress User Interface. All features are in a constant state of beta, there are no guarantees and a modern browser is mandatory!

These experiments are limited by their very nature and are mostly small tweaks via CSS to the display of the admin section in non-destructive ways. Some experiments are failures.

= Features =

Each experiment can be turned on and off from the plugin settings screen under TOOLS.

<strong>Colour-Coded Post Statuses</strong>

Ever had a page full of posts which were a mix of drafts, sticky posts, pending posts, and private posts? When you have a lot of different post statuses, it's hard to differentiate them all. Experiment #1 applies colour-coding to post statuses to make different types of posts easy to pick out with just a glance.

<strong>Warn if Plugins Are Old</strong>

If a plugin hasn't been updated in more than 2 years, you'll see an alert on the plugin list page.

<strong>More Toolbar Padding</strong>

Bringing a little more padding to the WP Toolbar, as well as a more 3.2-type footer. It also adds a little padding to the main content area to make everything feel a little more spacious.

<strong>Bigger Dashboard Fonts</strong>

Small fonts hurt. This will bump the default font sizes for those of us who need larger fonts.

<strong>Identify This Server</strong>

<em>This is a developer feature.</em>

Sometimes, when developing sites locally, deploying them to a staging server, then deploying to a live server - it can become confusing as to which WordPress admin panel you're logged into. This can have disastrous consequences if you suddenly start deleting stuff on the live server cause you thought the current tab was the staging server. This allows you to enable colour coding for your different servers so that it's always obvious which one you're using right now.

== Installation ==

No special instructions.

== Screenshots ==

1. Experiment #1 - Colour-Coded Post Statuses
2. Experiment #2 - Better Spacing/Padding for the Toolbar
3. Experiment #3 - Server Identification
4. Experiment #4 - Larger WP-Admin fonts
5. Experiment #5 - Old Plugin Warnings

== FAQ ==

<strong>Will you add X?</strong>

Maybe. It really depends.

<strong>Why is my site slow when I turn on Old Plugin Warning?</strong>

In general, this happens if you have plugins hosted off of WordPress.org that do funny things with the check for updates. Basically they trigger it too many times, and in a way that kicks off this plugin.

<strong>Why is it spelled 'Colour'?</strong>

The original author spelled it that way, being from a place where that was how it's spelled. I don't change it out of respect for John. Besides, it adds flavour.

== Changelog ==

= 2.2.4 (2016-06-06) =
* Changed: Made plugin age more cacheable.

= 2.2.3 (2016-04-19) =
* Fixed: Add leading/trailing spaces to classes to prevent them from being attached to other classes. ( [Props @jtsternberg](https://wordpress.org/support/topic/admin-body-class-is-missing-leading-space-breaking-other-plugins-styling?) )

= 2.2.2 (2016-01-04) =
* Changed: Bail earlier if the slug comes up null because that means the plugin is doing something derpy.

= 2.2.1 (2015-11-30) =
* Fixed: An unexpected T_PAAMAYIM_NEKUDOTAYIM occurred.

= 2.2.0 (2015-10-07) =
* New: Experiment number 5, added warnings for plugins over 2 years old

= 2.1.1 (2015-08-21) =
* Fixed: CSS with scheduled posts was off because of a change I missed in core!

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

(See Changelog.txt for older revisions)