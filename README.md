# WCQ Automatic EMI Calculation for WooCommerce

**Contributors:** sakibstime, cornq  
**Donate link:** [Buy me a coffee](https://buymeacoffee.com/sakibstime)  
**Tags:** woocommerce, ecommerce, installment, finance, payment plans  
**Requires at least:** WordPress 5.6  
**Tested up to:** WordPress 6.7  
**Requires PHP:** 8.2  
**Stable tag:** 2.0 
**License:** GPLv3 or later  
**License URI:** [https://www.gnu.org/licenses/gpl-3.0.html](https://www.gnu.org/licenses/gpl-3.0.html)

> Display automatic EMI plans on WooCommerce product pages using a shortcode. Fully customizable and lightweight.

---

## Description

**WCQ EMI for WooCommerce** is a lightweight plugin that calculates EMI (Equated Monthly Installments) based on the product’s regular price and displays the plan directly on product pages. It supports both shortcode and automatic display using WooCommerce hooks. Customize colors, currency, and tooltip behavior via the admin settings.

### 🔑 Features

- Display EMI breakdown for 3, 6, 9, and 12 months
- Show via shortcode: `[wcqaew_emi]` or automatically via hook
- Admin settings for color customization (background, text, tooltip)
- Custom currency symbol or use WooCommerce default
- Uses native WP Color Picker (with alpha support)
- Clean, responsive, and lightweight

---

## Installation

1. Upload the plugin folder to the `/wp-content/plugins/` directory or install via the WordPress Plugins screen.
2. Activate the plugin through the ‘Plugins’ screen in WordPress.
3. Go to **Settings > WCQAEW EMI Settings** to configure options.
4. Use the shortcode `[wcqaew_emi]` on product pages or let it render automatically.

---

## FAQ

### ❓ Does this plugin calculate interest?
No. It simply divides the regular price evenly across 3, 6, 9, or 12 months. For real financing with interest, integrate with a payment provider.

### 🎨 Can I customize the EMI box design?
Yes! Go to **Settings > WCQAEW EMI Settings** and select "Custom" mode to change the background, text, and tooltip styles.

### 💱 Can I change the currency symbol?
Yes. You can either use WooCommerce’s default currency or define your own from the settings.

---

## Screenshots

1. EMI displayed on a product page
2. Admin settings panel
3. Color customization with WP Color Picker

---

## Changelog

### 2.0
- Initial release

---

## Upgrade Notice

### 2.0
- Initial release

---

## License

This plugin is licensed under the GPLv3.  
See [https://www.gnu.org/licenses/gpl-3.0.html](https://www.gnu.org/licenses/gpl-3.0.html)
