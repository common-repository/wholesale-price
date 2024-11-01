(function( $ ) 
{
    'use strict';
    $(document).ready(function()
    {

        var a = jQuery('#wholesale_price_repeater_div_container').html();

        jQuery('.wholesale_price_add_more').click(function(){
            jQuery('.wholesale_price_min_max_div_container').append(a);
        });

    });


    $(document).on('click','.wholesale_price_remove_btn',function(){
        $(this).parent('div').remove();
    });

    $( '.wholesale-price-color' ).wpColorPicker();
         


})( jQuery );


function wholesale_price_toggle_show_hide(obj,primary,secondary,trinary)
{	
	a = jQuery(obj).is(':checked');
	if (a == true)
	 {
		jQuery('#'+primary).show(500);
		if(secondary!='')
		{
			jQuery('#'+secondary).hide(500);
		}
		if(trinary!='')
		{
			jQuery('#'+trinary).hide(500);
		}
		
	}
	else 
	{
		jQuery('#'+primary).hide(500);
		if(secondary!='')
		{
			jQuery('#'+secondary).show(500);
		}
		if(trinary!='')
		{
			jQuery('#'+trinary).show(500);
		}
               
	}
	
}
