<?php 
  global $InnovationTrackerSite;
  $context = Timber::context();
  $context['post'] = Timber::get_post();

  $type = $context['post']->post_type;

  $post_file = dirname(__DIR__).'/build/inc/posts/'.$type.'.php';
  if(file_exists($post_file)) include $post_file;

  $context['block_back_to_top'] = $InnovationTrackerSite->get_global_block('Back to Top');
  
  Timber::render([
    'single-'.$context['post']->post_type.'.twig',
    'single.twig'
  ], $context);
?>