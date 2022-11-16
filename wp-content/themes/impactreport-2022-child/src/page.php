<?php 
	global $ThemeSite;
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

		if ($context['page']->slug === 'tracker') {
			$app_manifest = file_get_contents(get_stylesheet_directory_uri() . '/app/asset-manifest.json');
			$app_assets = json_decode($app_manifest);
			foreach ($app_assets->entrypoints as $asset) {
				$parts = explode('.',$asset);
  			$extension = end($parts);
  			if ($extension === 'js') {
  				wp_enqueue_script( 'tracker', get_stylesheet_directory_uri() . '/app/' . $asset, array(), null, true );
  			} else if ($extension === 'css') {
  				wp_enqueue_style( 'tracker', get_stylesheet_directory_uri() . '/app/' . $asset, array(), null);
  			}
			}
			Timber::render(['tracker.twig'], $context);
		} else {
			Timber::render([
				'archive-' . $context['page']->slug . '.twig',
				'page-' . $context['page']->slug . '.twig',
				'page.twig',
				'base-single.twig',
				'base.twig'
			], $context);
		}
	}
?>