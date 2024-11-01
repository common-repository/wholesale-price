<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dynamic_Wholesale_Price
 * @subpackage Dynamic_Wholesale_Price/public
 * @author     Your Name <email@example.com>
 */
class Dynamic_Wholesale_Price_Public {

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
	 * @param      string    $dynamic_wholesale_price       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $dynamic_wholesale_price, $version ) {

		$this->dynamic_wholesale_price = $dynamic_wholesale_price;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->dynamic_wholesale_price, plugin_dir_url( __FILE__ ) . 'css/dynamic-wholesale-price-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
                wp_enqueue_script('jquery');
		wp_enqueue_script( $this->dynamic_wholesale_price, plugin_dir_url( __FILE__ ) . 'js/dynamic-wholesale-price-public.js', array( 'jquery' ), $this->version, true );

	}
        
        public function wholesale_price_html( $price, $product )
        {
            global $post;
	
            $product_id = $post->ID;
            $html = $price;
            $val= get_post_meta($product_id,'wholesale_price_wholesale_data', true); 
            //print_r($val);die;
            if(!empty($val))
            {
                $html .="<br />";
                $html .= "Wholesale Price:";
                $html .="<div class='wholesale_price_container'>";
                $html .="<div class='wholesale_price_box wholesale_price_table_heading'>";
                $html .="<div class='wholesale_qty_box'>Quantity</div>";
                $html .="<div class='wholesale_qty_box'>Price</div>";
                $html .="</div>";
                for($i=0;$i<count($val);$i++) 	
                {
                    $wholesale_minval = isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                    $wholesale_maxval = isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";	
                    $wholesale_price =  isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:"";
                    $html .="<div class='wholesale_price_box'>";
                    $html .="<div class='wholesale_qty_box'>".$wholesale_minval."</div>";
                    $html .="<div class='wholesale_qty_box'>".wc_price($wholesale_price)."</div>";
                    $html .="</div>";
                }
                $html .="</div>";
            }
            return $html;
        }
        
        public function wholesale_price_html_before_cart( )
        {
            global $post;
            $dbhandler = new Wholesale_Price_DBhandler();
            $product_id = $post->ID;
            $html = '';
            $val= get_post_meta($product_id,'wholesale_price_wholesale_data', true); 
            $show_table = $dbhandler->get_global_option_value('wholesale_price_show_table','0');
            $show_table_as = $dbhandler->get_global_option_value('woocommerce_price_table_show_as','always');
            $header_bgcolor = $dbhandler->get_global_option_value('woocommerce_price_table_header_bgcolor','#e1e1e1');
            $header_border_color = $dbhandler->get_global_option_value('woocommerce_price_table_border_color','#e1e1e1');
            $header_text_color = $dbhandler->get_global_option_value('woocommerce_price_table_header_text_color','#000000');
            //print_r($val);die;
            if(!empty($val) && $show_table==1)
            {
                $html .="<br />";
                if($show_table_as=='always'):
                    $html .="<div>";
                    $html .= "Wholesale Price:";
                    $html .="</div>";
                    $style = '';
                else:
                    $html .="<div>";
                    $html .= "Wholesale Price:";
                    $html .= '<span class="wholesale-price-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg></span>';
                    $html .="</div>";
                    $style = 'style="display:none;"';                    
                    
                endif;
                $html .="<div class='wholesale-price-view' ".$style."><div class='wholesale-price-wrap'><div class='wholesale_price_container' style='border-color:".$header_border_color."'>";
                $html .="<div class='wholesale_price_box wholesale_price_table_heading' style='background-color: ".$header_bgcolor.";color:".$header_text_color."'>";
                $html .="<div class='wholesale_qty_box' style='border-color:".$header_border_color."'>Quantity</div>";
                $html .="<div class='wholesale_qty_box' style='border-color:".$header_border_color."'>Price</div>";
                $html .="</div>";
                for($i=0;$i<count($val);$i++) 	
                {
                    $wholesale_minval = isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                    $wholesale_maxval = isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";	
                    $wholesale_price =  isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:"";
                    $html .="<div class='wholesale_price_box'>";
                    $html .="<div class='wholesale_qty_box' style='border-color:".$header_border_color."'>".$wholesale_minval."</div>";
                    $html .="<div class='wholesale_qty_box' style='border-color:".$header_border_color."'>".wc_price($wholesale_price)."</div>";
                    $html .="</div>";
                }
                $html .="</div></div></div>";
            }
            echo $html;
        }
        
        
        public function wholesale_price_before_calculate_total( $cart_object ) 
        {
           
            foreach ( $cart_object->cart_contents as $key => $value ) 
            {  
                $val= get_post_meta($value['product_id'],'wholesale_price_wholesale_data', true); 
                $old_price=$value['data']->get_price();
                if(!empty($val))
                {
                    for($i=0;$i<count($val);$i++) 	
                    {
                        $quantity = intval( $value['quantity'] );
                        $orgPrice = intval( $value['data']->get_price() );						
                        $wholesale_minval=isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                        $wholesale_maxval=isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";				
                        if($wholesale_maxval=="")
                        {
                            if(($quantity>= $wholesale_minval))  
                            {
                                $new_prc_value =  $val[$i]['wholesale_price'];
                                $value['data']->set_price($new_prc_value); 
                                break;		
                            }
                        }
                        else
                        {
                            if(($quantity>= $wholesale_minval)&&($quantity<=$wholesale_maxval))  
                            {
                                $new_prc_value =  $val[$i]['wholesale_price'];
                                $value['data']->set_price($new_prc_value); 
                                break;		
                            }
                        }
                        

                    }
                }

            }
            
	}
        
        public function wholesale_price_filter_cart_item_price( $price, $values ) 
        {
			  		
            global $woocommerce;
            $new_prod_val=get_post_meta( $values['product_id']);
            $ret_val="0";
            $num_phoen="0";
            $terms = get_the_terms( $values['product_id'], 'product_cat' );
            foreach ($terms as $term) 
            {
                $product_cat_id[] = $term->term_id;
            }
            $val= get_post_meta($values['product_id'],'wholesale_price_wholesale_data', true); 
            $quantity = intval( $values['quantity'] );
            if(!empty($val))
            {
                for($i=0;$i<count($val);$i++) 	
                {

                    $wholesale_minval=isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                    $wholesale_maxval=isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";				
                   if($wholesale_maxval=="")
                   {
                       if(($quantity>= $wholesale_minval))  
                        {
                            $ret_val=1;
                        }
                   }
                   else
                   {
                       if(($quantity>= $wholesale_minval)&&($quantity<=$wholesale_maxval))  
                        {
                            $ret_val=1;
                        }
                       
                   }
                    
                    
                }
            }
         
            $curr=get_woocommerce_currency_symbol();
            $old_price1="";
            $old_price="";
            global $product;
            $plan = wc_get_product($values['product_id']);
            $name=get_post($values['product_id'] );
            $_product = wc_get_product( $values['product_id'] );
            if ( $_product && $_product instanceof WC_Product_Variable && $values['variation_id'] )
            {
                $variations = $plan->get_available_variation($values['variation_id']);
                if($variations['display_regular_price']!='')
                {
                    $old_price1=$curr.$variations['display_regular_price'];
                }	
                if($variations['display_price']!='')
                {
                    $old_price1=$curr.$variations['display_price'];
                }	 
            }
            else
            {
                if($new_prod_val['_regular_price'][0]!='')
                {
                    $old_price1=$curr.$new_prod_val['_regular_price'][0];
                }
                if($new_prod_val['_sale_price'][0]!='')
                {
                    $old_price1=$curr.$new_prod_val['_sale_price'][0];
                }
            }
         
            if(($ret_val==0))
            {
                return "<span class='discount-info' title=''>" .
                       "<span class='old-price' >$old_price1</span></span>";
            }
            else
            {
                return "<span class='discount-info' title=''>" .
                "<span class='old-price' style='color:red; text-decoration:line-through;'>$old_price1</span> " .
                "<span class='new-price' > $price</span></span>";
            }
        }
        
        public function wholesale_price_filter_cart_subtotal_price($price, $values)
        {
            global $woocommerce;
            $amt='';			
            $type_curr='';			
            $ret_val="";			
            $quantity = intval( $values['quantity'] );			
            $curr=get_woocommerce_currency_symbol();			
            $val= get_post_meta($values['product_id'],'wholesale_price_wholesale_data', true); 			
           
            if(!empty($val))
            {				
                for($i=0;$i<count($val);$i++) 	
                {						
                    $quantity = intval( $values['quantity'] );
                    $wholesale_minval=isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                    $wholesale_maxval=isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";				
                    if($wholesale_maxval=="")
                    {
                        if(($quantity>=$wholesale_minval))  
                        {
                                $amt=isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:'';									
                                $type_curr="[". $curr.$amt." Price for each Product]";									
                                $ret_val = 1;
                                break;	
                                		
                        }
                    }
                    else
                    {
                        if(($quantity>=$wholesale_minval)&&($quantity<=$wholesale_maxval))  
                        {
                            $amt=isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:'';									
                            $type_curr="[". $curr.$amt." Price for each Product]";									
                            $ret_val = 1;
                            break;		
                        }	
                        
                    }
                    		
                }
            }			

            if($ret_val=="")
            {
                return "<span class='discount-info' title='$type_curr'>" .
                "<span>$price</span></span>";

            }
            else
            {	
                return "<span class='discount-info' title='$type_curr'>" .
                "<span>$price</span>" .
                "<span class='new-price' style='color:red;'> $type_curr</span></span>";
            }
        }
	
        public function wholesale_price_filter_subtotal_order_price( $price, $values, $order )
        {
            global $woocommerce;
            $amt = '';
            $type_curr = '';
            $ret_val = "";
            $curr = get_woocommerce_currency_symbol();
            $val = get_post_meta($values['product_id'],'wholesale_price_wholesale_data', true); 
            
            foreach ($order->get_items() as $item_id => $item_data) 
            {

                $quantity = $item_data->get_quantity(); // Get the item quantity
                for($i=0;$i<count($val);$i++) 	
                {

                    $wholesale_minval=isset($val[$i]['wholesale_min_val'])?$val[$i]['wholesale_min_val']:"";						
                    $wholesale_maxval=isset($val[$i]['wholesale_max_val'])?$val[$i]['wholesale_max_val']:"";	
                    if($wholesale_maxval=="")
                    {
                        if(($quantity>=$wholesale_minval))  
                        {
                            $amt=isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:'';
                            $type_curr="[". $curr.$amt." Price for each Product]";	
                            $ret_val = 1;
                            break;	
                        }
                    }
                    else
                    {
                        if(($quantity>=$wholesale_minval)&&($quantity<=$wholesale_maxval)) 
                        {

                            $amt=isset($val[$i]['wholesale_price'])?$val[$i]['wholesale_price']:'';
                            $type_curr="[". $curr.$amt." Price for each Product]";	
                            $ret_val = 1;

                            break;	
                        }
                    }


                }

                if($ret_val=="")
                {
                        return "<span class='discount-info11' title='$type_curr'>" .
                        "<span>$price</span></span>";

                }
                else
                {

                        return "<span class='discount-info' title='$type_curr'>" .
                        "<span>$price</span>" .
                        "<span class='new-price' style='color:red;'> $type_curr</span></span>";

                }
            }
            
        } 

}
