<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/admin
 * @author     Your Name <email@example.com>
 */
class Dynamic_Wholesale_Price_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $dynamic_wholesale_price    The ID of this plugin.
	 */
	private $dynamic_wholesale_price;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $dynamic_wholesale_price       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dynamic_wholesale_price, $version ) {

		$this->dynamic_wholesale_price = $dynamic_wholesale_price;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dynamic_Wholesale_Price_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dynamic_Wholesale_Price_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->dynamic_wholesale_price, plugin_dir_url( __FILE__ ) . 'css/dynamic-wholesale-price-admin.css', array(), $this->version, 'all' );
                   wp_enqueue_style( 'wp-color-picker' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Dynamic_Wholesale_Price_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Dynamic_Wholesale_Price_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->dynamic_wholesale_price, plugin_dir_url( __FILE__ ) . 'js/dynamic-wholesale-price-admin.js', array( 'jquery','wp-color-picker' ), $this->version, true );

	}
        
        public function wholesale_product_tab() 
        {
            ?>
<li class="wholesale_price_custom_tab"><a class="wholesale_price_custom_link" href="#wholesale_price_custom_tab_data"><span><?php _e('Wholesale', 'wholesale-price'); ?></span></a></li>
            <?php
        }
        
        public function wholesale_product_tab_content() 
        {
            global $product;
            global $post;
            $val= get_post_meta($post->ID,'wholesale_price_wholesale_data', true); 
//            echo '<pre>';
//            print_r($val);die;
            ?>
            <div id="wholesale_price_custom_tab_data" class="panel woocommerce_options_panel hidden">
                
                <div id="wholesale_price_repeater_div_container" style="display: none;">
                    <div class="wholesale_price_min_max_div"> 
                        <input type="number" placeholder="<?php _e('Min Quantity','wholesale-price');?>" name="wholesale_min_val[]" min=0 class="wholesale_min_val" value="" />
                        <input type="number" placeholder="<?php _e('Max Quantity','wholesale-price');?>" name="wholesale_max_val[]" min=0  class="wholesale_max_val" value="" />
                        <input type="number" step='any' placeholder="<?php _e('Wholesale Price','wholesale-price');?>" name="wholesale_price[]" min=0 class="wholesale_price" value="" />
                        <button name="wholesale_price_remove_btn" class="wholesale_price_remove_btn button">-</button>
                    </div>
                    
                </div>
                
                <div class="wholesale_price_html_content_div">
					
                    <div class="wholesale_price_label">
                            <label><b><?php _e('Min quantity','wholesale-price');?></b></label> 
                            <label><b><?php _e('Max quantity','wholesale-price');?></b></label> 
                            <label><b><?php _e('Wholesale price','wholesale-price'); echo ' (' .get_woocommerce_currency_symbol().')';?></b></label>
                    </div>
                    <div class="wholesale_price_min_max_div_container"> 
                        <?php 
                        if(isset($val[0]) && is_array($val))
                        {
                            for($i=0;$i<count($val);$i++)
                            {							
                                    ?>
                                    <div class="wholesale_price_min_max_div" > 
                                        <input type="number" placeholder="<?php _e('Min Quantity','wholesale-price');?>" name="wholesale_min_val[]" min=0 class="wholesale_min_val" value="<?php echo isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:''; ?>" />
                                        <input type="number" placeholder="<?php _e('Max Quantity','wholesale-price');?>" name="wholesale_max_val[]" min=0  class="wholesale_max_val" value="<?php echo isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:''; ?>" />
                                        <input type="number" step='any' placeholder="<?php _e('Wholesale Price','wholesale-price');?>" name="wholesale_price[]" min=0 class="wholesale_price" value="<?php echo isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:''; ?>" />
                                        <button name="wholesale_price_remove_btn" class="wholesale_price_remove_btn button">-</button>
                                    </div>
                                    <?php 
                            }
                        }
                        else
                        {
                            ?>
                            <div class="wholesale_price_min_max_div" > 
                                <input type="number" placeholder="<?php _e('Min Quantity','wholesale-price');?>" name="wholesale_min_val[]" min=0 class="wholesale_min_val" value="" />
                                <input type="number" placeholder="<?php _e('Max Quantity','wholesale-price');?>" name="wholesale_max_val[]" min=0  class="wholesale_max_val" value="" />
                                <input type="number" step='any' placeholder="<?php _e('Wholesale Price','wholesale-price');?>" name="wholesale_price[]" min=0 class="wholesale_price" value="" />
                                <button name="wholesale_price_remove_btn" class="wholesale_price_remove_btn button">-</button>
                            </div>
                            <?php 
                        }
                        ?>
                    </div>
                    
                    <input type="button" value="Add More" class="wholesale_price_add_more button button-primary button-large" />
		</div>
            </div>
            <?php	
        }
        
        public function wholesale_product_tab_content_process( $post_id ) 
        {
		$wholesale_price_data = array();
		$min_val= $_POST['wholesale_min_val'];
		$max_val= $_POST['wholesale_max_val'];
		$wholesale_price= $_POST['wholesale_price'];
		
		for($i=0;$i<COUNT($min_val);$i++)
		{
                    if( $min_val[$i] != '')
                    {
                        $wholesale_price_data[] = array(
                                'wholesale_min_val' =>	$min_val[$i],
                                'wholesale_max_val' =>	$max_val[$i],
                                'wholesale_price' =>	$wholesale_price[$i]
                        );
                    }
		}
		update_post_meta( $post_id, 'wholesale_price_wholesale_data', $wholesale_price_data );
	}
        
        public function wholesale_price_admin_menu()
        {
            if(current_user_can('manage_options'))
            {
                add_submenu_page("woocommerce",__('Wholesale Price','wholesale-price'),__('Wholesale Price','wholesale-price'),"manage_options","wholesale_price_options",array( $this, 'wholesale_price_options' ));
            }
        }
	
        public function wholesale_price_options()
        {
            if(current_user_can('manage_options'))
            {
                include 'partials/dynamic-wholesale-price-admin-display.php';
            }
        }
       

}
