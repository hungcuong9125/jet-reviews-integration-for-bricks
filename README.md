# JetReviews Integration For Bricks

Adds Bricks Builder elements to render JetReviews widgets without modifying JetReviews core files.

## Features
- **Reviews Listing Widget**: Custom Bricks element to render JetReviews listing.
- **Configurable Options**: Control rating layout, input types, show/hide avatar, titles, and more directly from Bricks editor.
- **Builder Performance**: Option to disable rendering inside the builder to keep the editor responsive.
- **Debug Status Page**: Includes a status page in WordPress admin to check integration status.

## Installation
1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. (Optional) Go to **JetReviews -> Bricks Integration** to enable/disable the integration and check debug info.

## Requirements
- WordPress 5.0+
- Bricks Builder theme installed and active
- JetReviews plugin installed and active

## Changelog

### 0.1.6.2
- **Fixed**: Corrected plugin folder structure in ZIP release to ensure it can be installed directly via WordPress.
- **Fixed**: Removed accidental temporary files from the repository.

### 0.1.6.1

### 0.1.6
- **Added** new **Static Review** element for Bricks Builder (equivalent to Elementor's "Jet Reviews" / Static Review widget).
  - Repeater-based rating fields (Label, Value, Max).
  - Stars / Points / Percentage layout modes with progress bar support.
  - Header with title and total average display.
  - Summary section with configurable position (right, left, top, bottom), title, text, and legend.
  - JSON-LD structured data (Schema.org Review markup) with item name, image, description, and author.
- Uses JetReviews CSS class names (`.jet-review__*`) for seamless style compatibility with JetReviews themes.

### 0.1.5
- **Added** Labels control group with 21 customizable text fields, organized into 4 sections:
  - **Header**: No Reviews Message, Singular/Plural Review Count Label, New Review Button, Already Reviewed Message, Moderator Check Message.
  - **Review Form**: Not Valid Field Message, Author Name/Mail Placeholder, Review Content/Title Placeholder, Submit Review Button, Cancel Button.
  - **Comment Form**: New Comment Button, Comments Placeholder, Show/Hide Comments Button, Comments Title, Submit Comment Button.
  - **Reply Form**: Reply Comment Button, Reply Placeholder, Submit Reply Button.
- Labels override JetReviews defaults when customized. Empty labels fall back to JetReviews built-in translations.

### 0.1.4
- **Added** Icons control group with 13 customizable icon pickers (Empty Star, Filled Star, New Review Button, Show Comments Button, New Comment Button, Pinned, Empty Like, Filled Like, Empty Dislike, Filled Dislike, Reply Button, Prev, Next).
- Icons override JetReviews default SVG icons when customized. Supports FontAwesome, Themify, Ionicons, and custom SVG uploads.
- **Improved** controls panel organization with grouped sections (Settings, Icons).

### 0.1.3
- **Fixed** visibility toggles (Show review author avatar, Show review title, Show review title input, Show review content input, Show comment author avatar) now work correctly by properly converting Bricks checkbox values to booleans that JetReviews Vue frontend expects.
- **Fixed** admin submenu "Bricks Integration" now correctly appears after "Settings" instead of at the top of the JetReviews menu.
- **Fixed** admin submenu URL was broken (`/wp-admin/jetreviews-integration-bricks` instead of `admin.php?page=jetreviews-integration-bricks`), resolved by setting correct `admin_menu` priority.
- Cleaned up admin page code.

### 0.1.2
- Added Debug Status page in WordPress Admin.
- Added support for JetReviews icons in Bricks Builder.
- Added "Don't render inside builder" option for better performance.
- Improved error handling.

### 0.1.1
- Fixed Reviews Listing (JetReviews) widget not displaying in Bricks Builder.
- Fixed element registration timing to wait for Bricks base classes.

### 0.1.0
- Initial release.
- Support for Reviews Listing element in Bricks.

## Support
If you find this plugin helpful, please consider supporting its development:

[![Buy Me A Coffee](https://img.buymeacoffee.com/button-api/?text=Buy%20me%20a%20coffee&emoji=%E2%98%95&slug=hungcuong259&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff)](https://buymeacoffee.com/hungcuong259)

- **Visit Website**: [toiuuwp.com](https://toiuuwp.com)
- **Facebook**: [Connect on Facebook](https://www.facebook.com/hungcuong2591)
- **Discord**: `hungcuong259`

---
Created by [toiuuwp](https://toiuuwp.com)
