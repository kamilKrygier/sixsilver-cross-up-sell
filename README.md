# Woocommerce SIXSILVER Cross-Sell and Up-Sell Plugin
Simple cross-sell and up-sell plugin that is showing products based at some attributes<br>
Mechanism dedicated for [sixsilver.pl](https://sixsilver.pl/)

## Description

This plugin uses custom taxonomies and meta data associated with WooCommerce products to dynamically generate cross-sell and up-sell products based on the properties of the currently viewed product.

The plugin primarily functions on single-product pages and queries products based on parameters such as pa_marka (Brand), pa_asortyment (Assortment), pa_kruszec (Alloy), pa_material (Material), pa_kolor-zlota (Gold Color), pa_kamien (Stone), and product_cat (Product Category).

### NOTICE

*Please note that these conditions are layered in a descending order of priority and restrictiveness. The logic operates on a "best match" basis. This means that if an entity doesn't meet the criteria of the first condition, it is then tested against the next conditions in the sequence, which are more general and less restrictive.*

*As such, it's crucial to ensure the most specific and restrictive conditions are placed at the beginning of the logic structure. If an entity meets the criteria of multiple conditions, it will be categorized based on the first condition it matches.*

*This process continues until a match is found or all conditions have been tested. If no match is found after testing all conditions, the logic defaults to the most general condition.*

*The order and specificity of the conditions are crucial to the functionality of the logic. Be sure to understand the hierarchy of conditions and their implications before making any changes or additions to the logic structure.*

## Installation

1. Upload the plugin files to the /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' screen in WordPress


## Usage

This plugin automatically adds cross-sell and up-sell products to single product pages on your WooCommerce site.

Cross-sell products are displayed in a swipeable section with the title "You may also be interested in".

The cross-sell and up-sell products are selected based on matching product attributes and category, ensuring that the products displayed are relevant to the customer's current product view.

The plugin ensures that products that are not in stock are excluded from the results.

The number of products shown is determined by whether the user is on a mobile device or not. If the user is on mobile, 24 products are shown. The same number is shown for non-mobile users.
## Configuration

This plugin is created specifically for the SIXSILVER website. It uses the custom taxonomies and product attributes specific to this website, and the algorithm for selecting cross-sell and up-sell products is based on the product catalog of SIXSILVER.

While this plugin will not be directly usable on other WooCommerce sites without modification, it can serve as a useful example of how to create a custom cross-sell and up-sell plugin for WooCommerce.

If you want to use this plugin on another WooCommerce site, you will need to modify the taxonomies and meta data queries to match the attributes and categories of your products.
