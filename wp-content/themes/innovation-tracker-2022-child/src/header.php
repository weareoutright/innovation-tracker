<?php
/*
 * Third party plugins that hijack the theme will call wp_head() to get the header template.
 * We use this to start our output buffer and render into the view/page-plugin.twig template in footer.php
 */
global $InnovationTrackerSite;
$GLOBALS['timberContext'] = Timber::get_context();
$context = Timber::context();
ob_start();

$context["main_menu"] = new Timber\Menu('Main Menu');

Timber::render('header.twig', $context);