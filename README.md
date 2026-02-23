# JetReviews x Bricks Bridge

Adds Bricks Builder elements to render JetReviews widgets without modifying JetReviews core files.

## Features
- **Reviews Listing Widget**: Custom Bricks element to render JetReviews listing.
- **Configurable Options**: Control rating layout, input types, show/hide avatar, titles, and more directly from Bricks editor.
- **Builder Performance**: Option to disable rendering inside the builder to keep the editor responsive.
- **Debug Status Page**: Includes a status page in WordPress admin to check integration status.

## Installation
1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. (Optional) Go to **JetReviews -> Bricks Bridge** to enable/disable the integration and check debug info.

## Requirements
- WordPress 5.0+
- Bricks Builder theme installed and active
- JetReviews plugin installed and active

## Changelog

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
- **Fixed** admin submenu "Bricks Bridge" now correctly appears after "Settings" instead of at the top of the JetReviews menu.
- **Fixed** admin submenu URL was broken (`/wp-admin/jetreviews-bricks-bridge` instead of `admin.php?page=jetreviews-bricks-bridge`), resolved by setting correct `admin_menu` priority.
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

---
Created by [toiuuwp](https://toiuuwp.com)
