<?php
/**
 * Remove Menu Items
 *
 * @link       http://fulcrumcreatives.com
 * @since      1.0.0
 *
 * @package    Fcc
 * @subpackage Fcc/public
 */

/**
 * Remove Menu Items
 *
 *
 * @package    Fcc
 * @subpackage Fcc/public
 * @author     Fulcrum Creatives <info@fulcrumcreatives.com>
 */

class Benefactor_Remove_Menu_Items {

    public $items;

    public function __construct( $items = array() ) {
        $this->items = $items;
        add_action( 'admin_init', array( $this, 'remove_menu_items' ) );
    }

    public function remove_menu_items() {
        foreach( $this->items as $item ) {
            remove_menu_page( $item );
        }
    }

}
