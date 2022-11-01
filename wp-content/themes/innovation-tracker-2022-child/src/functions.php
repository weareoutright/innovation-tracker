<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

require_once(__DIR__ . '/vendor/autoload.php');

$timber = new \Timber\Timber();

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

// Define path and URL to the ACF plugin.
define( 'INNOVATIONTRACKER_ACF_PATH', get_stylesheet_directory() . '/plugins/advanced-custom-fields-pro/' );
define( 'INNOVATIONTRACKER_ACF_URL', get_stylesheet_directory_uri() . '/plugins/advanced-custom-fields-pro/' );

// Include the ACF plugin.
include_once( INNOVATIONTRACKER_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'innovationtracker_acf_settings_url');
function innovationtracker_acf_settings_url( $url ) {
    return INNOVATIONTRACKER_ACF_URL;
}


//Include custom block functionality
require_once('inc/blocks.php');

//Include custom taxonomy functionality
require_once('inc/taxonomies.php');

//Include custom post type functionality
require_once('inc/post-types.php');

//Include custom search functionality
require_once('inc/search.php');

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */

class InnovationTracker extends Timber\Site {
  use InnovationTrackerBlocks;
  use InnovationTrackerTaxonomies;
  use InnovationTrackerPostTypes;
  use InnovationTrackerSearch;
  
	/** Add timber support. */
	public function __construct() {
		$this->theme_supports();
		add_action( 'enqueue_block_editor_assets', array($this,'innovationtracker_editor_override'), 100);
    add_action( 'wp_enqueue_scripts', array( $this, 'innovationtracker_enqueue_scripts' ), 11 );
    add_action( 'wp_enqueue_scripts', array( $this, 'innovationtracker_enqueue_styles' ), 11 );
		add_action( 'widgets_init', array( $this, 'innovationtracker_widgets_override' ), 100 );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'body_class', [ $this, 'modify_body_class'] );
    add_action( 'init', [$this, 'register_taxonomies'], 1);
		add_action( 'init', [$this, 'register_post_types'], 1);
    add_action( 'init', [$this, 'register_filters'], 1);
    add_action( 'init', [$this, 'register_image_sizes'], 1);
    add_action( 'image_size_names_choose', [$this, 'display_image_sizes'], 1);
    add_action( 'acf/init', [$this, 'register_custom_fields'], 99);
    add_action( 'acf/init', [ $this, 'acf_init' ], 100 );


    //For security reasons, disable XMLRPC
    add_filter( 'xmlrpc_enabled', '__return_false' );

		parent::__construct();
	}

  public function innovationtracker_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-bundle-script', get_stylesheet_directory_uri() . '/../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', array(), null, true);
  }

  public function innovationtracker_enqueue_styles() {
    wp_dequeue_style('twenty-twenty-one-style');
    wp_dequeue_style('parent-style');
    wp_enqueue_style('edf-theme','//www.edf.org/sites/default/files/css/css_9FM_cdwwfNjw_dPYBpRvqC5H8dsxhKT3Mmn5kRqgc3o.css', array(), null);
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array(), null);
  }

  public function get_global_block($block_name) {
    $block = get_page_by_title($block_name,[],'wp_block');
    return $block ? $block : null;
  }

	public function add_to_context( $context ) {
		$context['site']  = $this;
		return $context;
	}

	public function modify_body_class($classes) {	
		global $post;
		if (isset($post)) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
    return $classes;
	}

	public function theme_supports() {
		add_theme_support( 'post-thumbnails', array( 'post','page' ) ); 
	}

	public function innovationtracker_editor_override() {
		$homePageId = get_option('page_on_front');
		$post_id = isset($_POST['post_id']) ? $_POST['post_id'] : (isset($_GET['post']) ? $_GET['post'] : null);
		if (isset($post_id)) {
			wp_enqueue_style( 'editor-style', get_stylesheet_directory_uri() . '/editor-style.css', false, '1.0', 'all' );
		}
	}

  public function register_filters(){
  }

  public function register_custom_fields() {

  }

  public function register_image_sizes() {
  }

  public function display_image_sizes($sizes) {
    return $sizes;
  }


	public function innovationtracker_widgets_override() {

	}

	public function add_to_twig( $twig ) {
    return $twig;
	}

  public function acf_init() {
    $this->register_blocks();
    add_post_type_support( 'page', 'excerpt' );
  }
}

$InnovationTrackerSite = new InnovationTracker();
