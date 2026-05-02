<?php

add_action( 'customize_controls_enqueue_scripts', 'add_lang_to_customizer_previewer', 9999 );

function add_lang_to_customizer_previewer() {

    $handle    = 'tophive-pro-customize-multilingual';
    $src       = OneCoreCustomizer_Module_Multilingual::get_instance()->get_url() . '/js/customize.js';
    $deps      = [ 'customize-controls' ];
    $version   = rand();
    $in_footer = 1;
    wp_enqueue_script( $handle, $src, $deps, $version, $in_footer );
    $suffix = tophive_one()->get_asset_suffix();
    wp_enqueue_style('tophive-pro-admin', esc_url(OneCoreCustomizer()->get_url()) . '/assets/css/admin/admin' . $suffix . '.css', array(), false);

    global $sitepress;
    $language = ( empty( $_REQUEST['lang'] ) ) ? $sitepress->get_current_language() : $_REQUEST['lang'];
    $sitepress->switch_lang( $language );
    $language = $sitepress->get_current_language();

    update_option( 'tophive_pro_customizing_lang', $language );
    do_action( 'tophive_setup_lang' );
    $default_lang = $sitepress->get_default_language();
    global $wp_customize;
    if ( isset($_GET['url'] ) && $_GET['url'] ) {
        $current_previewing = $_GET['url'];
    } else {
        $current_previewing = $wp_customize->get_preview_url();
    }

    $url  = home_url('/');

    $language = $sitepress->get_current_language();
    $url = apply_filters( 'wpml_permalink', $current_previewing, $language );

    /*
    if (!isset($_REQUEST['lang']) || !$_REQUEST['lang'] || $url != $current_previewing) {
        $schema = 'http';
        if (is_ssl() ){
            $schema = 'https';
        }
        $customize_url = $schema.'://'. $_SERVER['HTTP_HOST'] . wp_unslash($_SERVER['REQUEST_URI']);

        $customize_url = add_query_arg(array(
            'lang' => $language,
            'url'  => urlencode($url)
        ), $customize_url);
        wp_redirect( $customize_url );
        die();
    }
    */

    $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0, 'orderby' => 'name', 'order' => 'asc' ) );

    wp_localize_script( 'jquery', 'Customiy_Pro_Languages', array(
        'url'              => $url,
        'languages'        => $languages,
        'current_language' => $language,
    ) );

}



