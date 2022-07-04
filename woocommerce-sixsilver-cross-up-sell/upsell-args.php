<?php
global $product;
$product_cat_id = '';
$product_kamien = [];
$asortyment_array = '';
$marka_array = '';
$kolor_zlota_array = '';
$surowiec_array = '';
$kamien_array = '';
//get pa_marka terms of product
$terms = get_the_terms( $product->get_ID(), 'product_cat' ); 
//get last category
$terms_count = count($terms) - 1;
$product_cat_id = $terms[$terms_count]->term_id;
//get pa_kamien terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_kamien' );
//assign term to $product_kamien
foreach ($terms as $term) {
array_push($product_kamien, $term->term_id);
break;
}
//get product terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_asortyment' );
//assign first term to $product_asortyment
$product_asortyment = $terms[0]->term_id;
//get pa_surowiec terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_surowiec' );
//assign first term to $product_surowiec
$product_surowiec = $terms[0]->term_id;
//get pa_kolor-zlota terms of product
$terms = get_the_terms( $product->get_ID(), 'pa_kolor-zlota' );
//assign first term to $product_kolorZlota
$product_kolorZlota = $terms[0]->term_id;
$terms = get_the_terms( $product->get_ID(), 'pa_marka' );
//assign first term to $product_asortyment
$product_marka = $terms[0]->term_id;

//assign $asortyment_array
if(isset($product_asortyment) || !empty($product_asortyment) || !is_null($product_asortyment))
$asortyment_array = array(
    'taxonomy' => 'pa_asortyment',
    'field' => 'term_id',
    'terms' => $product_asortyment,
    'operator' => 'IN'
);
else '';

if(isset($product_marka) || !empty($product_marka) || !is_null($product_marka))
{
    $marka_array = array(
        'taxonomy' => 'pa_marka',
        'field' => 'term_id',
        'terms' => $product_marka,
        'operator' => 'IN'
    );
}
else '';

if(isset($product_kolorZlota) || !empty($product_kolorZlota) || !is_null($product_kolorZlota))
$kolor_zlota_array = array(
    'taxonomy' => 'pa_kolor-zlota',
    'field' => 'term_id',
    'terms' => $product_kolorZlota,
    'operator' => 'IN'
);
else '';

if(isset($product_surowiec) || !empty($product_surowiec) || !is_null($product_surowiec))
$surowiec_array = array(
    'taxonomy' => 'pa_surowiec',
    'field' => 'term_id',
    'terms' => $product_surowiec,
    'operator' => 'IN'
);
else '';

if(isset($product_kamien) || !empty($product_kamien) || !is_null($product_kamien))
$kamien_array = array(
    'taxonomy' => 'pa_kamien',
    'field' => 'term_id',
    'terms' => $product_kamien,
    'operator' => 'IN'
);
else '';

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
    $kamien_array,
    $surowiec_array,
    $kolor_zlota_array,
    $marka_array,
    $asortyment_array,
),
'meta_query' => array(
    array(
        'key' => '_price',
        'value' => $product->get_price(),
        'compare' => '>=',
        'type' => 'NUMERIC'
    ),
    array(
        "key"=>"_stock_status", 
        "value"=>"outofstock", 
        "compare"=>"NOT IN",
    ),
),
'post__not_in' => array($product->get_ID())
    
);

$loop = new WP_Query( $args );
if($loop->post_count < 4)
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
        $kamien_array,
        $surowiec_array,
        $asortyment_array,
        $marka_array,
    ),
    'meta_query' => array(
        array(
            'key' => '_price',
            'value' => $product->get_price(),
            'compare' => '>=',
            'type' => 'NUMERIC'
        ),
        array(
            "key"=>"_stock_status", 
            "value"=>"outofstock", 
            "compare"=>"NOT IN",
        ),
    ),
    'post__not_in' => array($product->get_ID())
        
    );
    
    $loop = new WP_Query( $args );
    if($loop->post_count < 4)
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 4,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $product_cat_id
                ),
                $surowiec_array,
                $asortyment_array,
                $marka_array,
            ),
            'meta_query' => array(
                array(
                    'key' => '_price',
                    'value' => $product->get_price(),
                    'compare' => '>=',
                    'type' => 'NUMERIC'
                ),
                array(
                    "key"=>"_stock_status", 
                    "value"=>"outofstock", 
                    "compare"=>"NOT IN",
                ),
            ),
            'post__not_in' => array($product->get_ID()),
                
            );
            
        $loop = new WP_Query( $args );
        if($loop->post_count < 4)
        {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $product_cat_id
                    ),
                    $surowiec_array,
                    $asortyment_array,
                    $marka_array,
                ),
                'post__not_in' => array($product->get_ID()),
                'meta_query' => array(
                    array(
                        "key"=>"_stock_status", 
                        "value"=>"outofstock", 
                        "compare"=>"NOT IN",
                    ),
                ),
                );
                
            $loop = new WP_Query( $args );
            if($loop->post_count < 4)
            {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $product_cat_id,
                        ),
                        $surowiec_array,
                        $marka_array,
                    ),
                    'post__not_in' => array($product->get_ID()),
                    'meta_query' => array(
                        array(
                            "key"=>"_stock_status", 
                            "value"=>"outofstock", 
                            "compare"=>"NOT IN",
                        ),
                    ),
                    );
                    
                $loop = new WP_Query( $args );
                if($loop->post_count < 4)
                {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'terms' => $product_cat_id,
                            ),
                            $surowiec_array,
                        ),
                        'post__not_in' => array($product->get_ID()),
                        'meta_query' => array(
                            array(
                                "key"=>"_stock_status", 
                                "value"=>"outofstock", 
                                "compare"=>"NOT IN",
                            ),
                        ),
                        );
                        
                    $loop = new WP_Query( $args );
                    if($loop->post_count < 4)
                    {
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 4,
                            'tax_query' => array(
                                'relation' => 'AND',
                                $surowiec_array,
                            ),
                            'post__not_in' => array($product->get_ID()),
                            'meta_query' => array(
                                array(
                                    "key"=>"_stock_status", 
                                    "value"=>"outofstock", 
                                    "compare"=>"NOT IN",
                                ),
                            ), 
                            );
                            
                        $loop = new WP_Query( $args );
                    }
                }
            }
        }
    }
} 