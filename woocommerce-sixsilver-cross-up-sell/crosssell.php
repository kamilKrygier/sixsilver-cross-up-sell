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
        if ( isset($loop) && $loop->have_posts())  
        { 
            //create products
            echo '<div class="crosssell-wrapper"><h3>Może cię także zainteresować</h3><ul class="products columns-4 ">';
            while ( $loop->have_posts() ) : $loop->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            if(!wp_is_mobile())
                echo do_shortcode('</ul><p style="text-align: center;"><div class="x-btn x-btn-transparent x-btn-square x-btn-regular show-more" title="Zobacz więcej" style="outline: currentcolor none medium;">Zobacz więcej</div></p></div><script>var showMore = false;jQuery(".show-more").click("slow", function(){if(showMore == false){jQuery(".crosssell-wrapper > ul > li").fadeIn();jQuery(".show-more").text("ZOBACZ MNIEJ");showMore = true;}else if(showMore == true){var elements = jQuery(".crosssell-wrapper > ul > li").length;for(var i = 4;i <= elements - 1; i++){jQuery(".crosssell-wrapper > ul > li").eq(i).fadeOut();}jQuery(".show-more").text("ZOBACZ WIĘCEJ");showMore = false;}});</script>');
        } 
        wp_reset_postdata();
    }   
}
add_action('woocommerce_after_single_product', 'sixsilver_crosssell');
?>