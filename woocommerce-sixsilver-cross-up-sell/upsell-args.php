<?php
global $product;
$product_cat_id = '';
$product_kamien = '';
$asortyment_array = '';
//get pa_marka terms of product
$terms = get_the_terms( $product->get_ID(), 'product_cat' ); 
//assign term to $product_cat_id
foreach ($terms as $term) {
$product_cat_id = $term->term_id;
break;
}
//get pa_kamien terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_kamien' );
//assign term to $product_kamien
foreach ($terms as $term) {
$product_kamien = $term->term_id;
break;
}
//get product terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_asortyment' );
//assign first term to $product_asortyment
$product_asortyment = $terms[0]->term_id;
//get pa_kruszec terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_kruszec' );
//assign first term to $product_kruszec
$product_kruszec = $terms[0]->term_id;
//get pa_kolor-zlota terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_kolor-zlota' );
//assign first term to $product_kolorZlota
$product_kolorZlota = $terms[0]->term_id;

//assign $asortyment_array
if(isset($product_asortyment) || !empty($product_asortyment))
$asortyment_array = array(
    'taxonomy' => 'pa_asortyment',
    'field' => 'term_id',
    'terms' => $product_asortyment,
    'operator' => 'IN'
);

//arguments
$args = array(
'post_type' => 'product',
'posts_per_page' => 4,
'orderby' => 'price',
'order' => 'desc',
'tax_query' => array(
    'relation' => 'AND',
    array(
        'taxonomy' => 'product_cat',
        'field' => 'term_id',
        'terms' => $product_cat_id
    ),
    array(
        'taxonomy' => 'pa_kamien',
        'field' => 'term_id',
        'terms' => $product_kamien
    ),
    array(
        'taxonomy' => 'pa_kolor-zlota',
        'field' => 'term_id',
        'terms' => $product_kolorZlota
    ),
    array(
        'taxonomy' => 'pa_kruszec',
        'field' => 'term_id',
        'terms' => $product_kruszec
    ),
    $asortyment_array,
),
'meta_query' => array(
    array(
        'key' => '_price',
        'value' => $product->get_price(),
        'compare' => '>=',
        'type' => 'NUMERIC'
    )
),
'post__not_in' => array($product->get_ID())
    
);
$loop = new WP_Query( $args );
if($loop->post_count < 3)
{
    $args = array(
    'post_type' => 'product',
    'posts_per_page' => 4,
    'orderby' => 'price',
    'order' => 'desc',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $product_cat_id
        ),
        array(
            'taxonomy' => 'pa_kamien',
            'field' => 'term_id',
            'terms' => $product_kamien
        ),
        array(
            'taxonomy' => 'pa_kruszec',
            'field' => 'term_id',
            'terms' => $product_kruszec
        ),
        $asortyment_array,
    ),
    'meta_query' => array(
        array(
            'key' => '_price',
            'value' => $product->get_price(),
            'compare' => '>=',
            'type' => 'NUMERIC'
        )
    ),
    'post__not_in' => array($product->get_ID())
        
    );
    $loop = new WP_Query( $args );
    if($loop->post_count < 3)
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 4,
            'orderby' => 'price',
            'order' => 'desc',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $product_cat_id
                ),
                $asortyment_array,
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $product_kruszec
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => '_price',
                    'value' => $product->get_price(),
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                )
            ),
            'post__not_in' => array($product->get_ID())
                
            );
        $loop = new WP_Query( $args );
        if($loop->post_count < 3)
        {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'orderby' => 'price',
                'order' => 'desc',
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $product_cat_id
                    ),
                    $asortyment_array,
                ),
                'meta_query' => array(
                    array(
                        'key' => '_price',
                        'value' => $product->get_price(),
                        'compare' => '>=',
                        'type' => 'NUMERIC'
                    )
                ),
                'post__not_in' => array($product->get_ID())
            );
            $loop = new WP_Query( $args );
            if($loop->post_count < 3)
            {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'orderby' => 'price',
                    'order' => 'desc',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $product_cat_id
                        ),
                        $asortyment_array,
                    ),
                    'post__not_in' => array($product->get_ID())
                );
                $loop = new WP_Query( $args );
                if($loop->post_count < 3)
                {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'orderby' => 'price',
                        'order' => 'desc',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $product_cat_id
                            ),
                        ),
                        'post__not_in' => array($product->get_ID())
                    );
                    $loop = new WP_Query( $args );
                }
            }
        }
    }
}
?>