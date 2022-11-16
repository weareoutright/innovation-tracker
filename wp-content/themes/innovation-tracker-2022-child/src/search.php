<?php
  global $InnovationTrackerSite;
  $context = Timber::context();

  wp_enqueue_script('search', get_template_directory_uri() . '/js/search.js',array(),null,true);

  $context["query"] = $wp_query->query_vars;

  $context['results'] = !empty($context["query"]['s']) ? $wp_query->posts : [];

  Timber::render([
    'search.twig',
  ], $context);
?>