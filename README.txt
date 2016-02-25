=== Advanced Custom Fields Page Builder ===
Contributors: owenr88
Tags: advanced custom fields, custom fields, page builder, build pages
Requires at least: 3.8
Tested up to: 4.4.2
Stable tag: 1.1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A powerful and easy to use page builder, using the Advanced Custom Fields Flexible Content module.

== Description ==

**PLEASE NOTE: The following plugins or add-ons are required for this to work:**

* **[Advanced Custom Fields](http://www.advancedcustomfields.com/) is ESSENTIAL**
* **The Advanced Custom Fields [Flexible Content add-on field](http://www.advancedcustomfields.com/add-ons/flexible-content-field/) is essential**
* **[Simple Contact Forms](https://wordpress.org/plugins/simple-contact-forms/) is required for the Simple Contact Forms page builder section to work**

The ACF Page Builder uses the Advanced Custom Fields Flexible Content field to create a bunch of completely customisable page elements. This plugin works best when used with [Bootstrap](http://getbootstrap.com/), but it isn't essential. These elements include:

* Banner images
* Buttons
* Bootstrap Content Grids
* Image Gallery (with text and caption)
* Raw HTML and JavaScript
* [Simple Contact Forms](https://wordpress.org/plugins/simple-contact-forms/)
* WYSIWYG Content

Each element can be configured - see the screenshots for configuration options. Default options are background colours, wrapper classes and if the element needs to be contained (Bootstrap only!) Please [get in touch](https://twitter.com/biglemontweets) or [submit pull requests](https://github.com/owenr88/acf-page-builder) for any more page sections. 

The ACF Page Builder was created and is managed by [Big Lemon Creative](http://www.biglemoncreative.co.uk).

= Configuration =

To configure which post types, page templates and specific post ID the page builder is displayed on, use the following filter in your functions.php file:

~~~~
function support_acfpb( $support = array() ) {

    $support['post_type'] = array(
        'page',
        'post'
    );

    $support['page_template'] = array(
        'page-templates/page-sectioned.php'
    );

    $support['id'] = array(
        '21'
    );

    return $support;

}
add_filter('acfpb_set_locations', 'support_acfpb', 10, 1);
~~~~

= Usage =

We designed the functions to match the ACF syntax of `get_field()` and `the_field()`. Use the functions below to get or directly echo the sections on the front end. The ID is optional.

`the_sections( $id );`

OR

`echo get_sections( $id );`

== Installation ==

Install the plugin by following these steps:

1. Upload the `acf-page-builder` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Check out the settings page to create some fields and see how to include it in your theme

The plugin can also be searched for and installed directly in the WordPress Plugin manager.

Make sure that you have [Advanced Custom Fields](http://www.advancedcustomfields.com/) installed. 

== Frequently Asked Questions ==

= Can I ask you a question? =

Yes. Head over to the [GitHub](https://github.com/owenr88/acf-page-builder) page with any questions or feature requests. You might also find your answer in the support tab. Feel free to [contact us](http://www.biglemoncreative.co.uk) if you can't find an answer, or reach us on [Twitter](https://twitter.com/biglemontweets).

== Screenshots ==

1. All sections collapsed
2. Banner section options
3. Button section options
4. Content Grid section options
5. Gallery section options
6. Raw HTML section options
7. Simple Contact Forms section options
8. WYSIWYG section options
9. Full Page of created sections

== Changelog ==

= v1.1.3 =
* Fixed the containment and bootstrap toggle - wasn't working!

= v1.1.2 =
* Changed contributors and some house keeping

= v1.1.1 =
* The very first version! Includes the following sections: banners, buttons, content grid, galleries, raw HTML, normal WYSIWYG text and simple contact form integration

== Upgrade Notice ==

