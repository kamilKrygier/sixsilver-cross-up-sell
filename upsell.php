<?php
function sixsilver_upsell()
{
    //if is single-product page
	if(is_product())
	{
        //import file with up-sell arguments
		include('upsell-args.php');
		
        //if $loop is set in upsell-args.php
        //$loop is set while one of if-s with arguments is correct
        if ( isset($loop) && $loop->post_count >= 4)  
        { 
            //create products
            echo '<div class="upsell-wrapper swipeable swipeable-desktop"><h3>Powiązane produkty</h3><ul class="products columns-4 ">';
            while ( $loop->have_posts() ) : $loop->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            echo '</ul></div>';
        } 
        wp_reset_postdata();
	}
}
add_shortcode('sixsilver-upsell', 'sixsilver_upsell');
?>