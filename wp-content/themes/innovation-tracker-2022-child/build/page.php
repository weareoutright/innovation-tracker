<?php 
	global $InnovationTrackerSite;
	$context = Timber::context();
	$homePageId = get_option('page_on_front');
	$homePage = new TimberPost($homePageId);
	$context['homePage'] = $homePage;
	$context['page'] = Timber::get_post();

	if (is_front_page()) {
		Timber::render('home.twig', $context);
	} else {
		$page_file = dirname(__DIR__).'/build/inc/pages/'.$context['page']->slug.'.php';
		if(file_exists($page_file)) include $page_file;

		if ($context['page']->slug === 'methodology') {
			wp_enqueue_script( 'nav-jump', get_stylesheet_directory_uri() . '/js/nav-jump.js', array(), null, true );
		}

		Timber::render([
			'archive-' . $context['page']->slug . '.twig',
			'page-' . $context['page']->slug . '.twig',
			'page.twig',
			'base-single.twig',
			'base.twig'
		], $context);
	}
?>