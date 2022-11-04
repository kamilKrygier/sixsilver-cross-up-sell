<?php 
    global $product;

    $product_cat_id = array();
    $kamien = array();
    $loop = array();
    $args = '';
    $category = '';
    $productCount = '';
    $kolorZlota = '';
    $material = '';
    $exclude = array( $product->get_ID() );

    //get pa_marka terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_marka' );

    //assign first term to $product_marka
    $product_marka = $terms[0]->term_id;

    //get pa_asortyment terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_asortyment' );

    //assign first term to $product_asortyment
    $product_asortyment = $terms[0]->term_id;

    //get pa_kruszec terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_kruszec' );

    //assign first term to $product_kruszec
    $product_kruszec = $terms[0]->term_id;

    //get pa_material terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_material' );

    //assign first term to $product_kruszec
    $material = $terms[0]->term_id;

    //get pa_kolor-zlota terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_kolor-zlota' );

    //assign first term to $product_kruszec
    $kolorZlota = $terms[0]->term_id;

    switch($kolorZlota){
        //  Żółte złoto
        case 210:
            $kolorZlota = 239;
            break;
        //  Białe złoto
        case 212:
            $kolorZlota = 406;
            break;
        //  Żółte i białe złoto
        case 824:
            $kolorZlota = 1501;
            break;
        // Różowe złoto
        case 211:
            $kolorZlota = 405;
            break;
        //  Żółte i różowe złoto
        case 1636:
            $kolorZlota = array(239, 405);
            break;
        //  Białe i różowe złoto
        case 1631:
            $kolorZlota = array(406, 405);
            break;
        //  Żółte, białe i różowe złoto
        case 1637:
            $kolorZlota = array(239, 406, 405);
            break;
    }
    
    //get pa_kamien terms of product
    $terms = get_the_terms( $product->get_ID(), 'pa_kamien' );
    //push all terms to $kamien
    //(all 'kamienie' to array)
    foreach ($terms as $term){
        array_push($kamien, $term->term_id);
        continue;
    }

    //get product_cat terms of product
    $terms = get_the_terms( $product->get_ID(), 'product_cat' ); 
    //push all terms to $product_cat_id
    foreach ($terms as $term) {
        array_push($product_cat_id, $term->term_id);
        continue;
    }

    //how many products show an mobile and desktop
    if(wp_is_mobile())
        $productCount = 24;
        else $productCount = 24;
        
//Cross-sell for category_id 143 (Pierścionki zaręczynowe)
if(in_array(143, $product_cat_id))
{
    array_push($product_cat_id, 1015);
    
    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_kamien',
                'field' => 'term_id',
                'terms' => $kamien
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'field' => 'term_id',
                'terms' => $kolorZlota
            ),
            array(
                'taxonomy' => 'pa_surowiec',
                'field' => 'term_id',
                'terms' => 237
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'NOT IN',
                'terms' => $product_cat_id
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => 'LIKE',
            )
        ),
    );
    $loop = new WP_Query( $args );

    if($loop->post_count < 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $kolorZlota
                ),
                array(
                    'taxonomy' => 'pa_surowiec',
                    'field' => 'term_id',
                    'terms' => array(237),
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'NOT IN',
                    'terms' => $product_cat_id
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => 'LIKE',
                )
            ),
        );
        $loop = new WP_Query( $args );
        if($loop->post_count < 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'pa_surowiec',
                        'field' => 'term_id',
                        'terms' => array(237),
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'NOT IN',
                        'terms' => $product_cat_id
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'instock',
                        'compare' => 'LIKE',
                    )
                ),
            );
            $loop = new WP_Query( $args );
            if($loop->post_count < 4)
            {
                $args = array(
                    'post__not_in' => $exclude,
                    'post_type' => 'product',
                    'posts_per_page' => $productCount,
                    'hide_empty' => true,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'operator' => 'NOT IN',
                            'terms' => $product_cat_id
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'instock',
                            'compare' => 'LIKE',
                        )
                    ),
                );
                $loop = new WP_Query( $args );
            }
        }
    }
}

//Cross-sell for category_id 233 or 665 and not1564 and not664 (Biżuteria, not limited edition and not biżuteria męska)
else if((in_array(233, $product_cat_id) && !in_array(1564, $product_cat_id) && !in_array(664, $product_cat_id)) || (in_array(665, $product_cat_id) && !in_array(1564, $product_cat_id) && !in_array(664, $product_cat_id)))
{
    $category_children = array_diff(get_term_children(233, 'product_cat'), $product_cat_id);
    
    $wanted_Children = array();
    foreach($category_children as $term){
        $current_term = get_term($term, 'product_cat');
        if( !str_starts_with($current_term->name, 'Biżuteria z') )
            array_push($wanted_Children, $current_term->term_id);
    }

    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_kamien',
                'field' => 'term_id',
                'terms' => $kamien
            ),
            array(
                'taxonomy' => 'pa_marka',
                'field' => 'term_id',
                'terms' => $product_marka
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'field' => 'term_id',
                'terms' => $product_kruszec
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $wanted_Children
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => 'LIKE',
            )
        ),
    );
    $loop = new WP_Query( $args );
    if($loop->post_count < 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_marka',
                    'field' => 'term_id',
                    'terms' => $product_marka
                ),
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $product_kruszec
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $wanted_Children
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => 'LIKE',
                )
            ),
        );
        $loop = new WP_Query( $args );
        if($loop->post_count < 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'pa_kruszec',
                        'field' => 'term_id',
                        'terms' => $product_kruszec
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $wanted_Children
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'instock',
                        'compare' => 'LIKE',
                    )
                ),
            );
            $loop = new WP_Query( $args );
            if($loop->post_count < 4)
            {
                $args = array(
                    'post__not_in' => $exclude,
                    'post_type' => 'product',
                    'posts_per_page' => $productCount,
                    'hide_empty' => true,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'operator' => 'IN',
                            'terms' => $wanted_Children
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'instock',
                            'compare' => 'LIKE',
                        )
                    ),
                );
                $loop = new WP_Query( $args );
            }
        }
    }
}

//Cross-sell for category_id 1564 (LIMITED EDITION)
else if(in_array(1564, $product_cat_id))
{
    $category_children = array_diff(get_term_children(233, 'product_cat'), $product_cat_id);
     
    $wanted_Children = array();
    foreach($category_children as $term){
        $current_term = get_term($term, 'product_cat');
        if( !str_starts_with($current_term->name, 'Biżuteria z') )
            array_push($wanted_Children, $current_term->term_id);
    }
 

    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_kamien',
                'field' => 'term_id',
                'terms' => $kamien
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'field' => 'term_id',
                'terms' => $product_kruszec
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $wanted_Children, 
            ),
        )
    );
    $loop = new WP_Query( $args );
    if($loop->post_count < 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $product_kruszec
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $wanted_Children
                ),
            )
        );
        $loop = new WP_Query( $args );
        if($loop->post_count < 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $wanted_Children
                    ),
                )
            );
        }
    }
}

// Cross-sell for category_id 664 (Biżuteria męska)
else if(in_array(664, $product_cat_id))
{
    $category_children = array_diff(get_term_children(664, 'product_cat'), $product_cat_id);

    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_material',
                'field' => 'term_id',
                'terms' => $material
            ),
            array(
                'taxonomy' => 'pa_marka',
                'field' => 'term_id',
                'terms' => $product_marka
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'field' => 'term_id',
                'terms' => $product_kruszec
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $category_children
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => 'LIKE',
            )
        ),
    );
    $loop = new WP_Query( $args );
    if($loop->post_count <= 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_marka',
                    'field' => 'term_id',
                    'terms' => $product_marka
                ),
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $product_kruszec
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $category_children
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => 'LIKE',
                )
            ),
        );
        $loop = new WP_Query( $args );
        if($loop->post_count <= 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'pa_kruszec',
                        'field' => 'term_id',
                        'terms' => $product_kruszec
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $category_children
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'instock',
                        'compare' => 'LIKE',
                    )
                ),
            );
            $loop = new WP_Query( $args );
            if($loop->post_count <= 4)
            {
                $args = array(
                    'post__not_in' => $exclude,
                    'post_type' => 'product',
                    'posts_per_page' => $productCount,
                    'hide_empty' => true,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'operator' => 'IN',
                            'terms' => $category_children
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'instock',
                            'compare' => 'LIKE',
                        )
                    ),
                );
                $loop = new WP_Query( $args );
            }
        }
    }
    
}

//Cross-sell for category_id 170 (Obrączki ślubne)
else if(in_array(170, $product_cat_id))
{
    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_kamien',
                'field' => 'term_id',
                'terms' => $kamien
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'operator' => 'IN',
                'field' => 'term_id',
                'terms' => $kolorZlota
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => 233
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'instock',
                'compare' => 'LIKE',
            )
        ),
    );
    $loop = new WP_Query( $args );
    if($loop->post_count < 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_kruszec',
                    'operator' => 'IN',
                    'field' => 'term_id',
                    'terms' => $kolorZlota
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => 233
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'instock',
                    'compare' => 'LIKE',
                )
            ),
        );
        
        $loop = new WP_Query( $args );
        if($loop->post_count < 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => 233
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'instock',
                        'compare' => 'LIKE',
                    )
                ),
            );
            $loop = new WP_Query( $args );
        }
    }
}

else{
    $args = array(
        'post__not_in' => $exclude,
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'tax_query' => array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'pa_kamien',
                'field' => 'term_id',
                'terms' => $kamien
            ),
            array(
                'taxonomy' => 'pa_marka',
                'field' => 'term_id',
                'terms' => $product_marka
            ),
            array(
                'taxonomy' => 'pa_kruszec',
                'field' => 'term_id',
                'terms' => $product_kruszec
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $product_cat_id
            ),
        ),
    );
    $loop = new WP_Query( $args );
    if($loop->post_count <= 4)
    {
        $args = array(
            'post__not_in' => $exclude,
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,    
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'pa_marka',
                    'field' => 'term_id',
                    'terms' => $product_marka
                ),
                array(
                    'taxonomy' => 'pa_kruszec',
                    'field' => 'term_id',
                    'terms' => $product_kruszec
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $product_cat_id
                ),
            ),
        );
        $loop = new WP_Query( $args );
        if($loop->post_count <= 4)
        {
            $args = array(
                'post__not_in' => $exclude,
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,        
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'pa_kruszec',
                        'field' => 'term_id',
                        'terms' => $product_kruszec
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $product_cat_id
                    ),
                ),
            ); 
            $loop = new WP_Query( $args );
            if($loop->post_count <= 4)
            {
                $args = array(
                    'post__not_in' => $exclude,
                    'post_type' => 'product',
                    'posts_per_page' => $productCount,
                    'hide_empty' => true,            
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'pa_kruszec',
                            'field' => 'term_id',
                            'terms' => $product_kruszec
                        ),
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'operator' => 'IN',
                            'terms' => $product_cat_id
                        ),
                    ),
                );
                $loop = new WP_Query( $args );
                if($loop->post_count <= 4)
                {
                    $args = array(
                        'post__not_in' => $exclude,
                        'post_type' => 'product',
                        'posts_per_page' => $productCount,
                        'hide_empty' => true,                
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'operator' => 'IN',
                                'terms' => $product_cat_id
                            ),
                        ),
                    );
                    $loop = new WP_Query( $args );
                }
            }
        }
    }
}
?>