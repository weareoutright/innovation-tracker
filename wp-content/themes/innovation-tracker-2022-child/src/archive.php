<?php 
    $context = Timber::context();
    $homePageId = get_option('page_on_front');
    $homePage = new TimberPost($homePageId);
    $context['homePage'] = $homePage;

    if (is_front_page()) {
        Timber::render('home.twig', $context);
    } else {
        if (is_post_type_archive()) {

            $type = $wp_query->query['post_type'];
            $request =  $wp->request;
            $slug_parts = explode( '/', $request );
            $slug = end($slug_parts);

            $archive_page = get_page_by_path( $request, OBJECT, 'page' );

            if ($archive_page) {
                $context['page'] = new TimberPost($archive_page->ID);
            }

            $context['type'] = $type;
            $page_file = dirname(__DIR__).'/build/inc/pages/'.$slug.'.php';
            if(file_exists($page_file)) include $page_file;

        }
        
        Timber::render([
            'archive-' . $slug . '.twig',
            'archive-' . $type . '.twig',
            'archive.twig'
        ], $context);
    }
?>