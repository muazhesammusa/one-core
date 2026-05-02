<?php

class OneSidebarMenuWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'custom_sidebar_menu',
            __('Sidebar Menu', 'textdomain'),
            ['description' => __('Custom sidebar menu with icons and links.', 'textdomain')]
        );
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_script']);
    }

    public function enqueue_admin_script($hook) {
        if ($hook === 'widgets.php') {
            wp_enqueue_script('custom-sidebar-menu-admin', get_template_directory_uri() . '/js/sidebar-menu-widget.js', ['jquery'], null, true);
        }
    }

    public function form($instance) {
        $items = isset($instance['items']) ? $instance['items'] : [];

        echo '<div class="menu-items-container">';
        if (!empty($items)) {
            foreach ($items as $index => $item) {
                $this->render_menu_item_fields($index, $item);
            }
        }
        echo '</div>';

        $base_name = $this->get_field_name('items');
        echo '<button class="add-menu-item button" data-field-prefix="' . esc_attr($base_name) . '">Add Item</button>';
    }

    private function render_menu_item_fields($index, $item = []) {
        $text  = isset($item['text']) ? esc_attr($item['text']) : '';
        $url   = isset($item['url']) ? esc_attr($item['url']) : '';
        $icon_url = isset($item['icon']) ? esc_url($item['icon']) : '';
    
        $field_base = $this->get_field_name("items") . "[$index]";
        ?>
        <div class="menu-item" style="border:1px solid #ccc;padding:10px;margin-bottom:10px;">
            <p>Text: <input type="text" name="<?php echo $field_base; ?>[text]" value="<?php echo $text; ?>" class="widefat" /></p>
            <p>URL: <input type="text" name="<?php echo $field_base; ?>[url]" value="<?php echo $url; ?>" class="widefat" /></p>
            <p>
                Icon Image URL:
                <input type="text" name="<?php echo $field_base; ?>[icon]" value="<?php echo $icon_url; ?>" class="widefat icon-url" />
                <button class="upload-icon button">Upload</button>
            </p>
            <button class="remove-menu-item button">Remove</button>
        </div>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = [];
        if (!empty($new_instance['items']) && is_array($new_instance['items'])) {
            foreach ($new_instance['items'] as $index => $item) {
                $instance['items'][$index] = [
                    'text'  => sanitize_text_field($item['text']),
                    'url'   => esc_url_raw($item['url']),
                    'icon'  => esc_url_raw($item['icon']),
                ];
            }
        }
        return $instance;
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        $items = isset($instance['items']) ? $instance['items'] : [];
    
        if (!empty($items)) {
            echo '<div class="custom-sidebar-menu">';
            foreach ($items as $item) {
                $icon = !empty($item['icon']) ? '<img src="' . esc_url($item['icon']) . '" alt="" class="icon-img" style="width:20px;height:20px;margin-right:10px;" />' : '';
                echo '<a href="' . esc_url($item['url']) . '" class="menu-link" style="display:flex;align-items:center;padding:6px 0;">';
                echo $icon;
                echo '<span class="text">' . esc_html($item['text']) . '</span>';
                echo '</a>';
            }
            echo '</div>';
        }
    
        echo $args['after_widget'];
    }
    
}
    