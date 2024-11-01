<?php
class Wholesale_Price_DBhandler {
    
    public function get_global_option_value($option,$default='') {
            $value = get_option( $option, $default );
            if( !isset($value) || $value=='' ) { $value = $default; }
            $value = maybe_unserialize( $value );
            return $value;
    }

    public function update_global_option_value($option,$value) {
            update_option( $option, $value );
    }
    
 
}
