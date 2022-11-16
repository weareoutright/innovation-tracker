<?php 
  global $InnovationTrackerSite;
  $context = Timber::context();
  $context['post'] = Timber::get_post();

  $type = $context['post']->post_type;

  $post_file = dirname(__DIR__).'/build/inc/posts/'.$type.'.php';
  if(file_exists($post_file)) include $post_file;

  $context['latest_posts'] = Timber::get_posts(array_merge(DEFAULT_POST_QUERY_ARGS, [
    'posts_per_page' => 3
  ]));

  $context['block_back_to_top'] = $InnovationTrackerSite->get_global_block('Return to Top');
  
  Timber::render([
    'single-'.$context['post']->post_type.'.twig',
    'single.twig'
  ], $context);
?>