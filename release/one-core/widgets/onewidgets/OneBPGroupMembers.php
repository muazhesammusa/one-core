<?php

class OneBPGroupMembers extends WP_Widget {
 
    public function __construct() {
        $widget_options = array(
            'classname' => 'tophive-one-groups-members-widget',
            'description' => esc_html__( 'BuddyPress - One Groups members lists', 'ONE_CORE_SLUG' )
        );
        parent::__construct('buddypress_groups_members', 'BuddyPress Group Members', $widget_options);
    }
    public function widget( $args, $instance ) {
        global $wpdb;
    	if (bp_is_groups_component() && bp_is_single_item() ) {
	        $html = $args['before_widget'];
	        $html .= '<h4 class="widget-title">'. $instance['title'] .'</h4>';
	        $group_id =  bp_get_group_id();
            
            $members_query = $wpdb->get_results("SELECT user_id from {$wpdb->base_prefix}bp_groups_members where group_id={$group_id}");

            if(!empty( $members_query )){
                $html .= '<div class="avatar-block">';
                    foreach( $members_query as $val ){
                        $html .= '<div class="item-avatar">';
                        $html .= '<a href="'. bp_members_get_user_url( $val->user_id ) .'">';
                        $html .= get_avatar( $val->user_id, 50 );
                        $html .= '</a>';
                        $html .= '</div>';
                    }
                $html .= '</div>';
            }
	        $html .= $args['after_widget'];
		}
        echo $html;
    }
 
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
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
                </p>
            </div>
        <?php
    }
 
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
        return $instance;
    }
 
}
