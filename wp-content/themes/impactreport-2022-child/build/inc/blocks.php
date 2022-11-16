<?php
trait ThemeBlocks {

  public function register_blocks() {

    if ( ! function_exists( 'acf_register_block' ) ) {
        return;
    }

    define("DEFAULT_POST_QUERY_ARGS",array(
      'post_status' => 'publish',
      'orderby' => 'publish_date',
      'order' => 'DESC',
      'post_type' => 'post'
    ));

    // acf_register_block( array(
    //     'name'            => 'hero_with_cta',
    //     'title'           => __( 'EDF Hero with CTA', 'theme' ),
    //     'description'     => __( 'Hero space to be used at the top of pages with a call to action.', 'theme' ),
    //     'render_callback' => [$this, 'hero_with_cta_render'],
    //     'category'        => 'edf-theme',
    //     'icon'            => 'cover-image',
    //     'keywords'        => array( 'homepage', 'hero', 'top', 'cta', 'edf' ),
    // ) );

  // /**
  //  * hero_with_cta_render
  //  * @param $block
  //  * @param string $content
  //  * @param false $is_preview
  //  */
  // public function hero_with_cta_render( $block, $content = '', $is_preview = false ) {
  //   $context = Timber::context();
  //   $context['fields'] = get_fields();
  //   Timber::render( 'hero_with_cta.twig', $context );
  // }

  }
}
?>