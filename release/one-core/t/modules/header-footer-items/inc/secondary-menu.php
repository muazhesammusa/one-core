<?php

class One_Builder_Item_Secondary_Menu extends One_Builder_Item_Primary_Menu {
	public $id;
	public $label;
	public $prefix;
	public $selector;
	public $section;
	public $theme_location;

	/**
	 * Optional construct
	 */
	function __construct() {
		$this->id = 'secondary-menu';
		$this->label = __( 'Secondary Menu', 'tophive-pro' );
		$this->prefix = 'secondary_menu';
		$this->selector = '.builder-item--' . $this->id . ' .nav-menu-desktop .secondary-menu-ul';
		$this->section = 'header_menu_secondary';
		$this->theme_location = 'menu-2';
	}

}

One_Customize_Layout_Builder()->register_item( 'header', new One_Builder_Item_Secondary_Menu() );
