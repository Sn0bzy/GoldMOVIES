<?php


/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => 'General settings'
      ),
      array(
        'id'          => 'tmdb_settings',
        'title'       => 'TMDB settings'
      ),
      array(
        'id'          => 'adverts',
        'title'       => 'Adverts'
      ),
      array(
        'id'          => 'css_settings',
        'title'       => 'CSS settings'
      ),
      array(
        'id'          => 'js_settings',
        'title'       => 'JS settings'
      ),
      array(
        'id'          => 'footer_settings',
        'title'       => 'Footer settings'
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'website_logo',
        'label'       => 'Website Logo',
        'desc'        => 'Choose website logo',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'home_logo',
        'label'       => 'Home Logo',
        'desc'        => 'Choose home logo',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'favicon',
        'label'       => 'Favicon',
        'desc'        => 'Favicon for website',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'news_category',
        'label'       => 'Paste Category Permalink to Display Category News',
        'desc'        => 'Paste Category Permalink',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'tracking_code',
        'label'       => 'Tracking Code (Google Analytics or other)',
        'desc'        => 'Tracking Code (Google Analytics or other)',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'tmdb_api_key',
        'label'       => 'TMDB Api Key',
        'desc'        => 'You can write here your TMDB API KEY',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'tmdb_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'auto_fetching',
        'label'       => 'Auto Fetching',
        'desc'        => 'Turn on/off auto fetching',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'tmdb_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'movie_cover',
        'label'       => 'Movie Cover',
        'desc'        => 'Turn on/off movie cover in single movie page',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'tmdb_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'center_advert',
        'label'       => 'Center Advert',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'adverts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'advert2_advert',
        'label'       => 'Second Center Advert',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'adverts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'post_advert',
        'label'       => 'Post Advert',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'adverts',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_css',
        'label'       => 'Custom CSS',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'css_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_js',
        'label'       => 'Custom JS',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'js_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'min-height-control',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_columns',
        'label'       => 'Footer columns',
        'desc'        => 'Turn on/off footer columns',
        'std'         => '',
        'type'        => 'on-off',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_copyright',
        'label'       => 'Footer copyright',
        'desc'        => 'Website Footer Copyright',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer_settings',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}