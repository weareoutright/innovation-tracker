<?php

trait InnovationTrackerPostTypes {

  function register_post_types() {

    $DEFAULT_SUPPORTS = [ 'title', 'editor', 'custom-fields', 'excerpt', 'thumbnail'];

    $post_types = [
      // (object) [
      //   'single' => 'Impact',
      //   'plural' => 'Impacts',
      //   'slug' => 'our-impact',
      //   'id' => 'impact',
      //   'icon' => 'superhero-alt',
      //   'supports' => $DEFAULT_SUPPORTS,
      //   'taxonomies' => ['strategy']
      // ], 
    ];

    usort($post_types,function($a,$b) {
      if ($a->single < $b->single) return -1;
      if ($a->single > $b->single) return 1;
      return 0;
    });

    foreach($post_types as $t=>$type) {
      $id = property_exists($type,'id') ? $type->id : $type->slug;
      $opts = [
        'labels' => [
          'name' => __( $type->plural, 'innovationtracker' ), /* This is the Title of the Group */
          'singular_name' => __( $type->single, 'innovationtracker' ), /* This is the individual type */
          'all_items' => __( 'All '.$type->plural, 'innovationtracker' ), /* the all items menu item */
          'add_new' => __( 'Add New', 'innovationtracker' ), /* The add new menu item */
          'add_new_item' => __( 'Add New '.$type->single, 'innovationtracker' ), /* Add New Display Title */
          'edit' => __( 'Edit', 'innovationtracker' ), /* Edit Dialog */
          'edit_item' => __( 'Edit '.$type->single, 'innovationtracker' ), /* Edit Display Title */
          'new_item' => __( 'New '.$type->single, 'innovationtracker' ), /* New Display Title */
          'view_item' => __( 'View '.$type->single, 'innovationtracker' ), /* View Display Title */
          'search_items' => __( 'Search '.$type->plural, 'innovationtracker' ), /* Search Custom Type Title */
          'not_found' =>  __( 'Nothing found in the Database.', 'innovationtracker' ), /* This displays if there are no entries yet */
          'not_found_in_trash' => __( 'Nothing found in Trash', 'innovationtracker' ), /* This displays if there is nothing in the trash */
          'parent_item_colon' => ''
        ], /* end of arrays */
        'description' => __( 'InnovationTracker '.$type->plural, 'innovationtracker' ), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-'.$type->icon, /* the icon for the custom post type menu */
        'rewrite' => [ 'slug' => $type->slug ], /* you can specify its url slug */
        'has_archive' => property_exists($type,'has_archive') ? $type->has_archive : $type->slug , /* you can rename the slug here */
        'capability_type' => 'post',
        'hierarchical' => false,
        'show_in_rest' => true,
        'supports' => $type->supports,
        'taxonomies' => property_exists($type,'taxonomies') ? $type->taxonomies : array('post_tag','category'),
        //'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
      ]; /* end of options */
      if (isset($type->opts)) $opts = array_merge($opts,$type->opts);
      register_post_type($id,$opts);
      //For some reason, thumbnail support isn't working for CPTs - add manually for each
      if (in_array('thumbnail',$type->supports)) add_theme_support( 'post-thumbnails', [$id] ); 
    }
  }
}

?>