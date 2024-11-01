=== WP Ajax Query ===
Plugin Name: WP Ajax Query
Contributors: aizatto
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=aizat%2efaiz%40gmail%2ecom&lc=MY&item_name=Ezwan%20Aizat%20Bin%20Abdullah%20Faiz&item_number=WP%20Ajax%20Query&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Author: Ezwan Aizat Bin Abdullah Faiz
Tags: ajax, query, wp_query, json
Requires at least: 3
Tested up to: 3
Stable tag: 0.1

== Description ==

WP Ajax Query allows you to query your WordPress database using the same query paramaters you would use for WP_Query, and return a JSON respresentation of the query results. This allows developers to easily interface with WordPress without having to relearn a new API.

== How It Works ==

The Ajax Query interface would be available at http://example.com/wp-admin/admin-ajax.php?action=query

A sample jQuery request would be like:
`$.get(ajaxurl, { action: 'query' }, function () { }, 'json');`

Querying for a post:
`$.get(ajaxurl, { action: 'query', p: 1 }, function () { }, 'json');`

JSON results:
`{
  "id": 1,
  "type": 'post',
  "title": "Hello World",
  "permalink": "http:\/\/example.com\/?p=1"
}`

Query a category:
`$.get(ajaxurl, { action: 'query', cat: 1 }, function () { }, 'json');`

JSON results:
`{
  "id": 1
  "type": "category",
  "permalink": "http:\/\/example.com\/?cat=1",
  "terms": [],
  "posts": []
}`

`terms` and `posts` represents an array of either terms that are sub categories of the category, or posts belonging to the category.

== Installation ==

1. Upload the `wp-ajax-query` folder into your plugin directory.
1. Activate the plugin through the 'Plugins' menu in WordPress

== Why I Created It ==

Needed a common way to query the database for posts and taxonomies across multiple plugins, and didn't find a suitable replacement.
