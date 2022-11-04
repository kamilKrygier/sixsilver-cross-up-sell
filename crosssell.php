<?php
function sixsilver_crosssell()
{
    //if is single-product page
    if(is_product())
    {
        //import file with cross-sell arguments
        include('crosssell-args.php');
        //if $loop is set in croosssell-args.php
        //$loop is set while one of if-s with arguments is correct
        if ( isset($loop) && $loop->post_count >= 4)  
        { 
            //create products
            echo '<div class="crosssell-wrapper swipeable swipeable-desktop"><h3>Może cię także zainteresować</h3><ul class="products columns-4 ">';
            while ( $loop->have_posts() ) : $loop->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            echo '</ul></div>';
            
            // echo '</div>';
            wp_reset_postdata();
        }
        
    }   
}
add_action('woocommerce_after_single_product', 'sixsilver_crosssell');
?>