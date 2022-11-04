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
    $category = array();
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

    //assign first term to $product_kolor-zlota
    $kolorZlotaPierscionki = $terms[0]->term_id;

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

//Up-sell for category_id 143 (Pierścionki zaręczynowe)
if(in_array(143, $product_cat_id))
{
    foreach($product_cat_id as $term){
        $current_term = get_term($term, 'product_cat');
        if( !str_starts_with($current_term->name, 'Pierścionki zaręczynowe') )
            array_push($category, $current_term->term_id);
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
                'taxonomy' => 'pa_kolor-zlota',
                'field' => 'term_id',
                'terms' => $kolorZlotaPierscionki
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $category
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'outofstock',
                'compare' => 'NOT LIKE',
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
                    'taxonomy' => 'pa_kolor-zlota',
                    'field' => 'term_id',
                    'terms' => $kolorZlotaPierscionki
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $category
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'outofstock',
                    'compare' => 'NOT LIKE',
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
                        'taxonomy' => 'pa_kolor-zlota',
                        'field' => 'term_id',
                        'terms' => $kolorZlotaPierscionki
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $category
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'outofstock',
                        'compare' => 'NOT LIKE',
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
                            'terms' => $category
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'outofstock',
                            'compare' => 'NOT LIKE',
                        )
                    ),
                );
                $loop = new WP_Query( $args );
            }
        }
    }
}
//Up-sell for category_id 233 or 665 and not1564 and not664 (Biżuteria, not limited edition and not biżuteria męska)
else if((in_array(233, $product_cat_id) && !in_array(1564, $product_cat_id) && !in_array(664, $product_cat_id)) || (in_array(665, $product_cat_id) && !in_array(1564, $product_cat_id) && !in_array(664, $product_cat_id)))
{
    foreach($product_cat_id as $term)
    {
        $current_term = get_term($term, 'product_cat');
        if( !str_starts_with($current_term->name, 'Biżuteria z') ) 
            array_push($category, $current_term->term_id);
    }

    //trim/erase few unwanted terms from array
    $category = array_diff($category, array( 233, 665, 2288, 2048, 1871 ));
    $wanted_Children = array_diff($category, get_term_children( 665, 'product_cat' ));
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
                'value'   => 'outofstock',
                'compare' => 'NOT LIKE',
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
                    'value'   => 'outofstock',
                    'compare' => 'NOT LIKE',
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
                        'value'   => 'outofstock',
                        'compare' => 'NOT LIKE',
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
                            'value'   => 'outofstock',
                            'compare' => 'NOT LIKE',
                        )
                    ),
                );
                $loop = new WP_Query( $args );
            }
        }
    }
}

//Up-sell for category_id 1564 (LIMITED EDITION)
else if(in_array(1564, $product_cat_id))
{
//     $wanted_Children = array_diff($product_cat_id, get_term_children(233, 'product_cat'));
//     $wanted_Children = array_diff($wanted_Children, array(233 ));
//     $temp1 = array_diff(get_term_children(233, 'product_cat'), array_diff(get_term_children(233, 'product_cat'), $product_cat_id));

//     foreach($temp1 as $term){
//         $current_term = get_term($term, 'product_cat');
//         if( !str_starts_with($current_term->name, 'Biżuteria z') )
//             array_push($wanted_Children, $current_term->term_id);
//     }
//     array_merge($wanted_Children, $temp);

//     $category_not_in = array_diff(get_term_children(233, 'product_cat'), $wanted_Children);

    foreach($product_cat_id as $term)
    {
        $current_term = get_term($term, 'product_cat');
        if( !str_starts_with($current_term->name, 'Biżuteria z') ) 
            array_push($category, $current_term->term_id);
    }


    //trim/erase few unwanted terms from array
    $category = array_diff($category, array( 233, 665, 2288, 2048, 1871, 1564 ));
    $wanted_Children = array_diff($category, get_term_children( 665, 'product_cat' ));

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
                'operator' => 'IN',
                'terms' => $product_kruszec
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $wanted_Children, 
            ),
            // array(
            //     'taxonomy' => 'product_cat',
            //     'field' => 'term_id',
            //     'operator' => 'NOT IN',
            //     'terms' => $category_not_in, 
            // ),
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
                    'operator' => 'IN',
                    'terms' => $product_kruszec
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $wanted_Children, 
                ),
                // array(
                //     'taxonomy' => 'product_cat',
                //     'field' => 'term_id',
                //     'operator' => 'NOT IN',
                //     'terms' => $category_not_in, 
                // ),
                
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
                        'taxonomy' => 'pa_surowiec',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => 237
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $wanted_Children, 
                    ),
                    // array(
                    //     'taxonomy' => 'product_cat',
                    //     'field' => 'term_id',
                    //     'operator' => 'NOT IN',
                    //     'terms' => $category_not_in, 
                    // ),
                )
            );
            $loop = new WP_Query( $args );
        }
    }
}

// Up-sell for category_id 664 (Biżuteria męska)
else if(in_array(664, $product_cat_id))
{
    $wanted_Children = 0;
    $categories = array(1581, 1260, 1582, 1583);
    // $wanted_Children = array_diff($product_cat_id, $remove);
    for($i = 0; $i <= count($product_cat_id); $i++){
        switch($product_cat_id[$i]){
            case 1581:
                $wanted_Children = 1581;
                break;
            case 1260:
                $wanted_Children = 1260;
                break;
            case 1582:
                $wanted_Children = 1582;
                break;
            case 1583:
                $wanted_Children = 1583;
                break;
        }
    }


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
                'terms' => $wanted_Children
            ),
        ),
        'meta_query' => array(
            array(
                'key'     => '_stock_status',
                'value'   => 'outofstock',
                'compare' => 'NOT LIKE',
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
                    'terms' => $wanted_Children
                ),
            ),
            'meta_query' => array(
                array(
                    'key'     => '_stock_status',
                    'value'   => 'outofstock',
                    'compare' => 'NOT LIKE',
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
                        'terms' => $wanted_Children
                    ),
                ),
                'meta_query' => array(
                    array(
                        'key'     => '_stock_status',
                        'value'   => 'outofstock',
                        'compare' => 'NOT LIKE',
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
                            'terms' => $wanted_Children
                        ),
                    ),
                    'meta_query' => array(
                        array(
                            'key'     => '_stock_status',
                            'value'   => 'outofstock',
                            'compare' => 'NOT LIKE',
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
                                'taxonomy' => 'pa_marka',
                                'field' => 'term_id',
                                'terms' => $product_marka
                            ),
                        ),
                        'meta_query' => array(
                            array(
                                'key'     => '_stock_status',
                                'value'   => 'outofstock',
                                'compare' => 'NOT LIKE',
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
                            ),
                            'meta_query' => array(
                                array(
                                    'key'     => '_stock_status',
                                    'value'   => 'outofstock',
                                    'compare' => 'NOT LIKE',
                                )
                            ),
                        );
                        $loop = new WP_Query( $args );
                    }
                }
            }
        }
    }
    
}

//Up-sell for category_id 170 (Obrączki ślubne)
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
                'taxonomy' => 'pa_kolor-zlota',
                'field' => 'term_id',
                'terms' => $kolorZlotaPierscionki
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => 170
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
                    'taxonomy' => 'pa_kolor-zlota',
                    'field' => 'term_id',
                    'terms' => $kolorZlotaPierscionki
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => 170
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
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => 170
                    ),
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
?>