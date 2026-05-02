<?php

class OneRecentPostsWidget extends WP_Widget {
 
    public function __construct() {
        $widget_options = array(
            'classname' => 'tophive-mc-recent-post-widget',
            'description' => esc_html__( 'Fundocean Recent Posts', 'ONE_CORE_SLUG' )
        );
        parent::__construct('tophive_fo_recent_post_widget', 'MC Recent Posts', $widget_options);
    }
    function img_left_layout( $id ){
        $spacing = is_rtl() ? 'ec-pr-3' : 'ec-pl-3';
        return '<a class="theme-primary-color-head-hover text-decoration-none" href="'. get_permalink( $id ) .'">
            <div class="ec-d-flex ec-mb-3">
                <div class="ec-w-25">
                    <div class="th-post-widget-thumb">
                        ' . get_the_post_thumbnail( $id, 'thumbnail', array('class' => 'rounded-sm img-fluid') ) . '
                    </div>
                </div>
                <div class="ec-w-75 '. $spacing .'">
                    <p class="widget-blog-date ec-mb-1"><small>'. get_the_date('F j, Y', $id) .'</small></p>
                    <h6><small>'. get_the_title( $id ) .'</small></h6>
                    <span class="mc-blog-readmore">'. esc_html__( 'Read more', 'ONE_CORE_SLUG' ) .'<i class="ti-arrow-right"></i></span>
                </div>
            </div>
        </a>';
    }        
    function img_right_layout( $id ){
        $spacing = is_rtl() ? 'ec-pl-3' : 'ec-pr-3';
        return '<a class="theme-primary-color-head-hover text-decoration-none" href="'. get_permalink($id) .'">
            <p class="widget-blog-date ec-mb-1"><small>'. get_the_date('F j, Y', $id) .'</small></p>
            <div class="ec-d-flex ec-mb-3">
                <div class="ec-w-75 ec-pr-2">
                    <h6><small>'. get_the_title($id) .'</small></h6>
                    <span class="mc-blog-readmore">'. esc_html__( 'Read more', 'ONE_CORE_SLUG' ) .'<i class="ti-arrow-right"></i></span>
                </div>
                <div class="ec-w-25">
                    <div class="th-post-widget-thumb">
                        ' . get_the_post_thumbnail( $id, 'thumbnail', array('class' => 'rounded-sm img-fluid') ) . '
                    </div>
                </div>
            </div>
        </a>';    
    } 
    function img_top_layout($id){
        return '<a class="theme-primary-color-head-hover text-decoration-none" href="'. get_permalink( $id ) .'">
            <div class="ec-mb-3">
                <div>
                    <div class="th-post-widget-thumb ec-mb-2">
                        ' . get_the_post_thumbnail( $id, 'thumbnail', array('class' => 'rounded-sm img-fluid') ) . '
                    </div>
                </div>
                <div>
                    <p class="widget-blog-date ec-mb-0 mt-n1"><small>'. get_the_date('F j, Y', $id) .'</small></p>
                    <h6><small>'. get_the_title( $id ) .'</small></h6>
                    <span class="mc-blog-readmore">'. esc_html__( 'Read more', 'ONE_CORE_SLUG' ) .'<i class="ti-arrow-right"></i></span>
                </div>
            </div>
        </a>';
    }
    function post_image( $id, $post_img_pos ){
        $post_image;

        switch ($post_img_pos) {
            case 'img-left':
                $post_image = $this->img_left_layout($id); 
                break;

            case 'img-right':
                $post_image = $this->img_right_layout($id); 
                break;
            
            default:
                $post_image = $this->img_top_layout($id);
                break;
        }
        return $post_image;
    }   
    public function widget( $args, $instance ) {
        $id = rand();
        $post_layout = ! empty( $instance['post_layout'] ) ? $instance['post_layout'] : 'one-col';
        $post_img_pos = ! empty( $instance['post_img_pos'] ) ? $instance['post_img_pos'] : 'img-left';

        $post_date = ! empty( $instance['post_date'] ) ? $instance['post_date'] : false;
        $read_more = ! empty( $instance['read_more'] ) ? $instance['read_more'] : false;

        $display_date = $post_date ? 'block' : 'none';
        $display_more = $read_more ? 'block' : 'none';

        $html = $args['before_widget'];
        $params = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $instance['post_count']
        );
        $post_query = new WP_Query($params);
        $html .= '<div class="th-mc-posts-widget-'. $id .'">';
        if( !empty($instance['title']) ){
            $html .= '<h4 class="widget-title">'. $instance['title'] .'</h4>';
        }
        $html .= '<div class="ec-container-mega-widget">';
        $html .= '<div class="ec-row">';
        if($post_query->have_posts()){
            while ($post_query->have_posts()) {
                $post_query->the_post();
                if( $post_layout == 'one-big-col' ){
                    if($post_query->current_post == 0){
                        $html .= '<div class="display-date-'. $display_date .' display-more-'. $display_more .' ec-col-12 th-blog-big-head theme-primary-color-head-hover">';
                            $html .= '<div class="th-post-widget-thumb th-post-widget-big-thumb ec-mb-2">';
                                $html .= get_the_post_thumbnail( get_the_ID(), 'post-thumbnail', array('class' => 'rounded-sm') );
                            $html .= '</div>';
                            $html .= '<p class="widget-blog-date ec-mb-0 ec-mt-n1"><small>'. get_the_date('F j, Y', get_the_ID()) .'</small></p>';
                            $html .= '<a class="text-decoration-none" href="'. get_the_permalink() .'"><h5 class="ec-mb-3">'. get_the_title() .'</h5></a>';
                            $html .= '<span class="mc-blog-readmore">'. esc_html__( 'Read more', 'ONE_CORE_SLUG' ) .'<i class="ti-arrow-right"></i></span>';
                        $html .= '</div>';
                    }else{
                        $html .= '<div class="ec-col-12 display-date-'. $display_date .' display-more-'. $display_more .'">';
                            $html .= $this->post_image( get_the_ID(), $post_img_pos );     
                        $html .= '</div>';
                    }
                }elseif( $post_layout == 'one-col' ){
                    $html .= '<div class="ec-col-12 display-date-'. $display_date .' display-more-'. $display_more .'">';
                        $html .= $this->post_image( get_the_ID(), $post_img_pos );  
                    $html .= '</div>';
                }elseif( $post_layout == 'two-col' ){
                    $html .= '<div class="ec-col-6 display-date-'. $display_date .' display-more-'. $display_more .'">';
                        $html .= $this->post_image( get_the_ID(), $post_img_pos );  
                    $html .= '</div>';
                }elseif( $post_layout == 'three-col' ){
                    $html .= '<div class="ec-col-4 display-date-'. $display_date .' display-more-'. $display_more .'">';
                        $html .= $this->post_image( get_the_ID(), $post_img_pos );
                    $html .= '</div>';
                }
            }
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $style = '.th-mc-posts-widget-'. $id .' .widget-blog-date{display:'. $display_date .'}
                    .th-mc-posts-widget-'. $id .' .mc-blog-readmore{display:'. $display_more .'}';
        $html .= $args['after_widget'];

        // wp_enqueue_style( 'th-style' );
        // wp_add_inline_style( 'th-style', $style );

        echo $html;
    }
 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $post_count = ! empty( $instance['post_count'] ) ? $instance['post_count'] : '';
        $post_date = ! empty( $instance['post_date'] ) ? $instance['post_date'] : false;
        $read_more = ! empty( $instance['read_more'] ) ? $instance['read_more'] : false;
        $post_layout = ! empty( $instance['post_layout'] ) ? $instance['post_layout'] : 'one-col';
        $post_img_pos = ! empty( $instance['post_img_pos'] ) ? $instance['post_img_pos'] : 'img-left';
        

        ?>
            <div class="tophive_fo_recent_post_widget_form">
                <p>
                    <label 
                        for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title : ', 'ONE_CORE_SLUG' ); ?></label>
                    <input 
                        id="<?php echo $this->get_field_id( 'title' ); ?>" 
                        type="text" 
                        name="<?php echo $this->get_field_name( 'title' ); ?>" 
                        value="<?php echo esc_attr( $title ); ?>" 
                    />
                </p>
                <p>
                    <label 
                        for="<?php echo $this->get_field_id('post_count'); ?>"><?php echo esc_html__( 'Post Count', 'ONE_CORE_SLUG' ); ?></label>
                    <input 
                        type="number"
                        min="3" 
                        name="<?php echo $this->get_field_name('post_count'); ?>" 
                        id="<?php echo $this->get_field_id('post_count'); ?>" 
                        value="<?php echo esc_attr($post_count); ?>"
                    />
                </p>
                <p>
                    <label 
                        for="<?php echo $this->get_field_id('post_date'); ?>"><?php echo esc_html__( 'Show Date', 'ONE_CORE_SLUG' ); ?></label>
                    <input 
                        type="checkbox"
                        name="<?php echo $this->get_field_name('post_date'); ?>" 
                        id="<?php echo $this->get_field_id('post_date'); ?>" 
                        value="<?php echo $this->get_field_id('post_date'); ?>" 
                        <?php echo $post_date ? 'checked' : ''; ?>
                    />
                </p>
                <p>
                    <label 
                        for="<?php echo $this->get_field_id('read_more'); ?>"><?php echo esc_html__( 'Show readmore', 'ONE_CORE_SLUG' ); ?></label>
                    <input 
                        type="checkbox"
                        name="<?php echo $this->get_field_name('read_more'); ?>" 
                        id="<?php echo $this->get_field_id('read_more'); ?>" 
                        value="<?php echo $this->get_field_id('read_more'); ?>" 
                        <?php echo $read_more ? 'checked' : ''; ?>
                    />
                </p>
                <p>
                    <label 
                        for="<?php echo $this->get_field_id('post_layout'); ?>"><?php echo esc_html__( 'Post Count', 'ONE_CORE_SLUG' ); ?></label>
                    <select 
                        name="<?php echo $this->get_field_name('post_layout') ?>" 
                        id="<?php echo $this->get_field_id('post_layout') ?>"
                    >
                        <option <?php selected( $post_layout , 'one-big-col'); ?>  value="one-big-col"><?php echo esc_html__( 'One Column + Big First', 'ONE_CORE_SLUG' ) ?></option>
                        <option <?php selected( $post_layout , 'one-col'); ?>  value="one-col"><?php echo esc_html__( 'One Column', 'ONE_CORE_SLUG' ) ?></option>
                        <option <?php selected( $post_layout , 'two-col'); ?>  value="two-col"><?php echo esc_html__( 'Two Column', 'ONE_CORE_SLUG' ) ?></option>
                        <option <?php selected( $post_layout , 'three-col'); ?>  value="three-col"><?php echo esc_html__( 'Three Column', 'ONE_CORE_SLUG' ) ?></option>
                    </select>
                </p>
                <p>
                    <label 
                        for="<?php echo $this->get_field_id('post_img_pos'); ?>"><?php echo esc_html__( 'Post Count', 'ONE_CORE_SLUG' ); ?></label>
                    <select 
                        name="<?php echo $this->get_field_name('post_img_pos') ?>" 
                        id="<?php echo $this->get_field_id('post_img_pos') ?>"
                    >
                        <option <?php selected( $post_img_pos , 'img-top'); ?>  value="img-top"><?php echo esc_html__( 'Image top', 'ONE_CORE_SLUG' ) ?></option>
                        <option <?php selected( $post_img_pos , 'img-left'); ?>  value="img-left"><?php echo esc_html__( 'Image left', 'ONE_CORE_SLUG' ) ?></option>
                        <option <?php selected( $post_img_pos , 'img-right'); ?>  value="img-right"><?php echo esc_html__( 'Image Right', 'ONE_CORE_SLUG' ) ?></option>
                    </select>
                </p>
            </div>
        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        $instance[ 'post_count' ] = strip_tags( $new_instance[ 'post_count' ] );
        $instance[ 'post_date' ] = !empty($new_instance[ 'post_date' ]) ? strip_tags( $new_instance[ 'post_date' ] ) : false;
        $instance[ 'read_more' ] = !empty($new_instance[ 'read_more' ]) ? strip_tags( $new_instance[ 'read_more' ] ) : false;
        $instance[ 'post_layout' ] = strip_tags( $new_instance[ 'post_layout' ] );
        $instance[ 'post_img_pos' ] = strip_tags( $new_instance[ 'post_img_pos' ] );
        return $instance;
    }
 
}
