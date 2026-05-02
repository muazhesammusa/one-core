<?php

class OneBPGroupsInfo extends WP_Widget {
 
    public function __construct() {
        $widget_options = array(
            'classname' => 'tophive-one-groups-info-widget',
            'description' => esc_html__( 'BuddyPress - One Profile descriptions', 'ONE_CORE_SLUG' )
        );
        parent::__construct('buddypress_groups_desc', 'Buddypress about group [one]', $widget_options);
    }
    public function widget( $args, $instance ) {
    	if (bp_is_groups_component() && bp_is_single_item() ) {
	        $html = $args['before_widget'];
	        $html .= '<div>';
	        $html .= '<h4 class="widget-title">'. $instance['title'] .'</h4>';
	        
	        	$group = groups_get_group( array( 'group_id' => bp_get_group_id()) );	
	        	
			$html .= '<p>' . $group->description . '</p>';	
	        $html .= '<p></p>';
	        $html .= '</div>';
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
