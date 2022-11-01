<?php
trait InnovationTrackerBlocks {

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

    acf_register_block( array(
        'name'            => 'hero_with_cta',
        'title'           => __( 'EDF Hero with CTA', 'innovationtracker_2022' ),
        'description'     => __( 'Hero space to be used at the top of pages with a call to action.', 'innovationtracker_2022' ),
        'render_callback' => [$this, 'hero_with_cta_render'],
        'category'        => 'edf-theme',
        'icon'            => 'cover-image',
        'keywords'        => array( 'homepage', 'hero', 'top', 'cta', 'edf' ),
    ) );

    acf_register_block( array(
        'name'            => 'latest_posts',
        'title'           => __( 'EDF Latest Posts', 'innovationtracker_2022' ),
        'description'     => __( 'The latest three posts with a header and description.', 'innovationtracker_2022' ),
        'render_callback' => [$this, 'latest_posts_render'],
        'category'        => 'edf-theme',
        'icon'            => 'grid-view',
        'keywords'        => array( 'blog', 'blogs', 'posts', 'latest', "what's new", 'new', 'insights', 'edf' ),
    ) );

    acf_register_block( array(
        'name'            => 'tracker_prompts',
        'title'           => __( 'EDF Tracker Question Prompts', 'innovationtracker_2022' ),
        'description'     => __( 'Question suggestions to promote engagement with the tracker.', 'innovationtracker_2022' ),
        'render_callback' => [$this, 'tracker_prompts_render'],
        'category'        => 'edf-theme',
        'icon'            => 'help',
        'keywords'        => array( 'tracker', 'question', 'prompts', 'edf' ),
    ) );

    acf_register_block( array(
        'name'            => 'updates',
        'title'           => __( 'EDF Updates', 'innovationtracker_2022' ),
        'description'     => __( 'CTA to join email newsletter.', 'innovationtracker_2022' ),
        'render_callback' => [$this, 'updates_render'],
        'category'        => 'edf-theme',
        'icon'            => 'email',
        'keywords'        => array( 'updates', 'email', 'edf' ),
    ) );

    acf_register_block( array(
        'name'            => 'posts_archive',
        'title'           => __( 'EDF Posts Archive', 'innovationtracker_2022' ),
        'description'     => __( 'A list of all Insights posts.', 'innovationtracker_2022' ),
        'render_callback' => [$this, 'posts_archive_render'],
        'category'        => 'edf-theme',
        'icon'            => 'grid-view',
        'keywords'        => array( 'blog', 'blogs', 'posts', 'insights', 'edf' ),
    ) );
  }

  /**
   * hero_with_cta_render
   * @param $block
   * @param string $content
   * @param false $is_preview
   */
  public function hero_with_cta_render( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();
    $context['fields'] = get_fields();
    Timber::render( 'hero_with_cta.twig', $context );
  }

  /**
   * latest_posts_render
   * @param $block
   * @param string $content
   * @param false $is_preview
   */
  public function latest_posts_render( $block, $content = '', $is_preview = false ) {

    $context = Timber::context();
    $context['fields'] = get_fields();

    $context['latest_posts'] = Timber::get_posts(array_merge(DEFAULT_POST_QUERY_ARGS, [
      'posts_per_page' => 3
    ]));

    Timber::render( 'latest_posts.twig', $context );
  }

  /**
   * tracker_prompts_render
   * @param $block
   * @param string $content
   * @param false $is_preview
   */
  public function tracker_prompts_render( $block, $content = '', $is_preview = false ) {

    $context = Timber::context();
    $context['fields'] = get_fields();

    Timber::render( 'tracker_prompts.twig', $context );
  }

  /**
   * updates_render
   * @param $block
   * @param string $content
   * @param false $is_preview
   */
  public function updates_render( $block, $content = '', $is_preview = false ) {

    $context = Timber::context();
    $context['fields'] = get_fields();

    Timber::render( 'updates.twig', $context );
  }

  /**
   * posts_archive_render
   * @param $block
   * @param string $content
   * @param false $is_preview
   */
  public function posts_archive_render( $block, $content = '', $is_preview = false ) {

    $context = Timber::context();
    $context['fields'] = get_fields();

    $context['posts'] = Timber::get_posts(array_merge(DEFAULT_POST_QUERY_ARGS, []));

    Timber::render( 'posts_archive.twig', $context );
  }

}
?>