=== Refe Core ===
Contributors: 6punto14
Tags: blocks, custom post types, settings
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 8.3
Stable tag: 1.0.4
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Content types, fields, blocks and settings for the Refe website.

== Description ==

This plugin holds everything that is not appearance: case studies, testimonials, people, ACF fields, blocks, site settings, global colours and fonts, bindings to company data, editor control, schema, REST routes and abilities. The look of the site lives in the Refe theme.

The `build` folder is produced with @wordpress/scripts. The source code is in the private project repository.

== Third-party code ==

* es-module-shims 2.8.4 by Guy Bedford, MIT License (assets/js/es-module-shims.LICENSE.txt). Loaded only in browsers without import maps.

== Changelog ==

= 1.0.4 =
* Works in 2021 browsers (Safari 14.1, iOS 14.5, Chrome 88): es-module-shims where import maps are missing, small polyfills, CSS fallbacks.


= 1.0.3 =
* People cards: image and longer text on the back instead of the video.

= 1.0.2 =
* Menu panels stay open while the mouse moves down to them.

= 1.0.1 =
* Menu panels more opaque.

= 1.0.0 =
* First delivery.

= 0.6.0 =
* Schema, REST routes, abilities, contact form support.

= 0.3.0 =
* Content types, fields, settings, blocks, bindings, editor control.
