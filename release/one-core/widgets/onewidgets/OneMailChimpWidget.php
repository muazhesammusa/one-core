<?php

class OneMailChimpWidget extends WP_Widget {
 
    public function __construct() {
        $widget_options = array(
            'classname' => 'tophive-mc-mchimp-subs-widget',
            'description' => esc_html__( 'Fundocean Mailchimp Widget', 'ONE_CORE_SLUG' )
        );
        parent::__construct('mchimp-subs', 'MC MailChimp Widget', $widget_options);
        add_filter( 'tophive/customizer/config', array( $this, 'config' ) );
    }
    public function config( $configs ){
        $api_url_help = 'https://mailchimp.com/help/about-api-keys/';
        $list_url_help = 'https://mailchimp.com/help/find-audience-id/';
        $configs[] = array(
            'name'           => 'tophive_mailchimp_panel',
            'type'           => 'panel',
            'priority'       => 100,
            'title'          => esc_html__( 'Mailchimp', 'ONE_CORE_SLUG' ),
        );
        $configs[] = array(
            'name'     => 'tophive_mailchimp_panel_api_key_settings',
            'type'     => 'section',
            'panel'    => 'tophive_mailchimp_panel',
            'title'    => esc_html__( 'Api Key Settings', 'tophive' ),
        );
        $configs[] = array(
            'name' => 'tophive_mailchimp_api_key',
            'type' => 'text',
            'section' => 'tophive_mailchimp_panel_api_key_settings',
            'label' => esc_html__( 'MailChimp Api Key', 'ONE_CORE_SLUG' ),
            'description' => sprintf(esc_html__( 'How Can I get My %sApi Key?%s', 'ONE_CORE_SLUG' ), '<a href="'. $api_url_help .'" target="_blank">', '</a>'),
        );
        $configs[] = array(
            'name' => 'tophive_mailchimp_list_id',
            'type' => 'text',
            'section' => 'tophive_mailchimp_panel_api_key_settings',
            'label' => esc_html__( 'MailChimp List ID', 'ONE_CORE_SLUG' ),
            'description' => sprintf(esc_html__( 'How Can I get My %sList ID?%s', 'ONE_CORE_SLUG' ), '<a href="'. $list_url_help .'" target="_blank">', '</a>'),
        );
        return $configs;
    }
    public function widget( $args, $instance ) {
        $html = $args['before_widget'];
        $html .= '<div>';
        $html .= '<h4 class="widget-title">'. $instance['title'] .'</h4>';
        if( !empty( $instance['description'] )){
            $html .= '<p class="widget-description ec-mb-3">'. $instance['description'] .'</p>';
        }
        $html .= '<div class="newsletter-submit-form">
                    <input class="form-control newsletter-submit-form-mail mb-2" type="email" name="email" placeholder="'. esc_html__( 'Enter Your Email', 'tophive' ) .'" required />
                 
                    <a href="#" class="newsletter-submit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.146 4.646a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L12.793 8l-2.647-2.646a.5.5 0 0 1 0-.708z"/>
                            <path fill-rule="evenodd" d="M2 8a.5.5 0 0 1 .5-.5H13a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8z"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"  width="55px" height="55px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                            <path d="M35 50A15 15 0 0 0 65 50A15 16.3 0 0 1 35 50" fill="#fff" stroke="none" transform="rotate(177.696 50 50.65)">
                              <animateTransform attributeName="transform" type="rotate" dur="0.5025125628140703s" repeatCount="indefinite" keyTimes="0;1" values="0 50 50.65;360 50 50.65"></animateTransform>
                            </path>
                        </svg>  
                    </a>
                </div>';
        $html .= '<div class="tophive-mailchimp-message"></div>';
        $html .= '</div>';
        $html .= $args['after_widget'];
        echo $html;
    }
 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $description = ! empty( $instance['description'] ) ? $instance['description'] : '';
        $post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : '';
        
        $list_id = function_exists('top_hive') ? tophive_one()->get_setting('tophive_mailchimp_list_id') : '';
        $api_key = function_exists('top_hive') ? tophive_one()->get_setting('tophive_mailchimp_api_key') : '';
        
        if( empty($list_id) || empty($api_key) ){
            $query['autofocus[section]'] = 'tophive_mailchimp_panel_api_key_settings';
            $section_link = add_query_arg( $query, admin_url( 'customize.php' ) );
            ?>
            <p class="ec-text-danger ec-mt-2 small">
                <?php  
                    echo __( "Your MailChimp <code>API KEY</code> is not configured yet.You can Configure It <a href='". esc_url( admin_url( '/customize.php?autofocus[section]=tophive_mailchimp_panel_api_key_settings' ) ) ."'>Here</a>", 'tophive' );
                ?>
            </p>';
            <?php
        }else{
        ?>
            <div class="mchimp-subs_form">
                <p>
                    <label 
                        for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
                    <input 
                        id="<?php echo $this->get_field_id( 'title' ); ?>" 
                        type="text" 
                        name="<?php echo $this->get_field_name( 'title' ); ?>" 
                        value="<?php echo esc_attr( $title ); ?>" 
                    />
                    <label 
                        for="<?php echo $this->get_field_id( 'description' ); ?>">Description:</label><br/><br/>
                    <textarea 
                        id="<?php echo $this->get_field_id( 'description' ); ?>" 
                        type="text" 
                        name="<?php echo $this->get_field_name( 'description' ); ?>"
                    ><?php echo stripslashes( $description ); ?></textarea>
                </p>
            </div>
        <?php
        }
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'description' ] = strip_tags( $new_instance[ 'description' ] );
        $instance[ 'post_count' ] = strip_tags( $new_instance[ 'post_count' ] );
        return $instance;
    }
 
}
