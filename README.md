#Custom Template Tags

###Purpose

When developing a theme with a lot of custom post meta and custom taxonomies, your theme can become quickly loaded with method calls that detract from the legibility of reading the code in your theme. 

Enter Custom Template Tags. They take away the need to always write verbose method calls in you themes and mimic the simplicity of WP template tags. 

Custom Template Tags is divided in to two classes. One for handling custom post meta and one for handling custom taxonomies. 

###Custom Meta Tags or CMT

Methods can be called on the `CMT` namespace. Assume 'post_meta' is the key for the meta data that you are printing or retrieving.

`CMT::the_post_meta()`

`CMT::get_the_post_meta()`

Also, an extra isset function can be used that appends your key with "exists"

`CMT::post_meta_exists()`

###Custom Taxonomy Tags or CTT

Methods can be called on the `CTT` namespace. Assume 'custom_taxonomy' is the name of the custom taxonomy you are calling. Usage mimics `the_tags()`.

`CTT::the_custom_taxnonomy`

`CTT::get_the_custom_taxonomy`

Also, an extra isset function can be used that appends your taxonomy with "exists"

`CTT::custom_taxnonomy_exists`

###Usage

Example from the work section on [my blog](http://codeandnotes.com/work/tweebop/).

```php

<?php if (CMT::role_exists()) : ?>

    <p><strong>Role:</strong> <?php CMT::the_role() ?></p>

<?php endif; ?>

<?php if (CTT::skill_exists()) : ?>

    <p class="skill" ><strong>Skills:</strong> <?php CTT::the_skill('' , " | " , '') ?></p>

<?php endif; ?>

```

