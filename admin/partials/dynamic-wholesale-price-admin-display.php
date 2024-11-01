<?php
$dbhandler = new Wholesale_Price_DBhandler();

if(filter_input(INPUT_POST,'submit_settings'))
{
	$retrieved_nonce = filter_input(INPUT_POST,'_wpnonce');
        $show_table = filter_input(INPUT_POST,'wholesale_price_show_table');
        $show_table_as = filter_input(INPUT_POST,'woocommerce_price_table_show_as');
        $header_bgcolor = filter_input(INPUT_POST,'woocommerce_price_table_header_bgcolor');
        $header_border_color = filter_input(INPUT_POST,'woocommerce_price_table_border_color');
        $header_text_color = filter_input(INPUT_POST,'woocommerce_price_table_header_text_color');
	if (wp_verify_nonce($retrieved_nonce, 'save_wholesale_price_settings' ) )
        {
            if(!isset($show_table)) $show_table = '0';

            $dbhandler->update_global_option_value('wholesale_price_show_table',$show_table);
            $dbhandler->update_global_option_value('woocommerce_price_table_show_as',$show_table_as);
            $dbhandler->update_global_option_value('woocommerce_price_table_header_bgcolor',$header_bgcolor);
            
            $dbhandler->update_global_option_value('woocommerce_price_table_border_color',$header_border_color);
            $dbhandler->update_global_option_value('woocommerce_price_table_header_text_color',$header_text_color);
            
            ?>
            <div class="notice notice-success">
            <p><?php _e( "Your settings have been saved.", 'wholesale-price' ); ?></p>
            </div>
<?php
        }
        else
        {
            die( __('Failed security check','wholesale-price') );
        }
        
}
?>

<div class="wwprice">
    <form name="wholesale_price_settings" id="wholesale_price_settings" method="post">
    <!-----Dialogue Box Starts----->
    <div class="content">
      <div class="wwpheader">
        <?php _e( 'Wholesale Price','wholesale-price' ); ?>
      </div>
     
      <div class="wwpsubheader">
        <?php
		//Show subheadings or message or notice
		?>
      </div>
      <div class="wwprow">
        <div class="wwpfield">
          <?php _e( 'Show Price Table','wholesale-price' ); ?>
        </div>
        <div class="wwpinput">
            <input name="wholesale_price_show_table" id="wholesale_price_show_table" type="checkbox" class="wholesale_price_toggle" value="1" style="display:none;"  onclick="wholesale_price_toggle_show_hide(this,'wholesale_price_show_table_html')" <?php checked($dbhandler->get_global_option_value('wholesale_price_show_table'),'1'); ?>   />
          <label for="wholesale_price_show_table"></label>
        </div>
          <div class="wwpnote"><?php _e('Show Wholesale Price table on Product page.','wholesale-price');?></div>
      </div>  
        <div class="childfieldsrow" id="wholesale_price_show_table_html" style=" <?php if($dbhandler->get_global_option_value('wholesale_price_show_table','0')== '1'){echo 'display:block;';} else { echo 'display:none;';} ?>">
                <div class="wwprow">
                  <div class="wwpfield">
                    <?php _e( 'Table Show as','wholesale-price' ); ?>
                  </div>
                <div class="wwpinput">
          <select name="woocommerce_price_table_show_as" id="woocommerce_price_table_show_as">
            <option value="always" <?php selected($dbhandler->get_global_option_value('woocommerce_price_table_show_as','always'),'always'); ?>><?php _e('Show Always','wholesale-price');?></option>
            <option value="onclick" <?php selected($dbhandler->get_global_option_value('woocommerce_price_table_show_as','always'),'onclick'); ?>><?php _e('Click on Info Icon','wholesale-price');?></option>
        </select>
          <div class="errortext"></div>
        </div>
                <div class="wwpnote"><?php _e('option to choose table visibility on product page.','wholesale-price');?></div>
                </div> 
            
            
             <div class="wwprow">
                  <div class="wwpfield">
                    <?php _e( 'Table Header Background Color','wholesale-price' ); ?>
                  </div>
                <div class="wwpinput">
                    <input name="woocommerce_price_table_header_bgcolor" id="woocommerce_price_table_header_bgcolor" type="text" value="<?php echo $dbhandler->get_global_option_value('woocommerce_price_table_header_bgcolor','#e1e1e1');?>" class="wholesale-price-color">
            
          <div class="errortext"></div>
        </div>
                <div class="wwpnote"><?php _e('option to choose table visibility on product page.','wholesale-price');?></div>
                </div> 
            
            
             <div class="wwprow">
                  <div class="wwpfield">
                    <?php _e( 'Table Border Color','wholesale-price' ); ?>
                  </div>
                <div class="wwpinput">
                    <input name="woocommerce_price_table_border_color" id="woocommerce_price_table_border_color" type="text" value="<?php echo $dbhandler->get_global_option_value('woocommerce_price_table_border_color','#e1e1e1');?>" class="wholesale-price-color">
            
          <div class="errortext"></div>
        </div>
                <div class="wwpnote"><?php _e('option to choose table visibility on product page.','wholesale-price');?></div>
                </div> 
            
             <div class="wwprow">
                  <div class="wwpfield">
                    <?php _e( 'Table Header Text Color','wholesale-price' ); ?>
                  </div>
                <div class="wwpinput">
                    <input name="woocommerce_price_table_header_text_color" id="woocommerce_price_table_header_text_color" type="text" value="<?php echo $dbhandler->get_global_option_value('woocommerce_price_table_header_text_color','#000000');?>" class="wholesale-price-color">
            
          <div class="errortext"></div>
        </div>
                <div class="wwpnote"><?php _e('option to choose table visibility on product page.','wholesale-price');?></div>
                </div> 
            
        </div>

    
     
      <div class="buttonarea"> 
        <?php wp_nonce_field('save_wholesale_price_settings'); ?>
          <input type="submit" value="<?php _e('Save','wholesale-price');?>" name="submit_settings" id="submit_settings"/>
        <div class="all_error_text" style="display:none;"></div>
      </div>
    </div>
  </form>
</div>
