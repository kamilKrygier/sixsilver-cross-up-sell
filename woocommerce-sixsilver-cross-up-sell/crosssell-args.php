<?php 
    global $product;
    $args = '';
    $product_cat_id = '';
    $category = '';
    $productCount = '';
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
    $kamien = array();
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
    //assign term to $product_marka
    $product_cat_id = $terms[0]->term_id;
    // foreach ($terms as $term) {
    //     $product_cat_id = $term->term_id;
    //     break;
    // }

    //get parent category
    $parentcats = get_ancestors($product_cat_id, 'product_cat');
    //if there will be no parent category, assing current
    if(!empty($parentcats))
        $category = $parentcats;
    else $category = $product_cat_id;
    //how many products show an mobile and desktop
    if(wp_is_mobile())
        $productCount = 4;
        else $productCount = 12;
    //arguments
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $productCount,
        'hide_empty' => true,
        'post__not_in' => array($product->get_ID()),
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
                'taxonomy' => 'pa_asortyment',
                'field' => 'term_id',
                'terms' => $product_asortyment,
                'operator' => 'NOT IN'
            ),
            // array(
            //     'taxonomy' => 'product_cat',
            //     'field' => 'term_id',
            //     'operator' => 'NOT IN',
            //     'terms' => $product_cat_id
            // ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'operator' => 'IN',
                'terms' => $category
            ),
        ),
    );
    $loop = new WP_Query( $args );
    if($loop->post_count < 3)
    {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $productCount,
            'hide_empty' => true,
            'post__not_in' => array($product->get_ID()),
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
                    'taxonomy' => 'pa_asortyment',
                    'field' => 'term_id',
                    'terms' => $product_asortyment,
                    'operator' => 'NOT IN'
                ),
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => $category
                ),
            ),
        );
        $loop = new WP_Query( $args );
        if($loop->post_count < 3)
        {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => $productCount,
                'hide_empty' => true,
                'post__not_in' => array($product->get_ID()),
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'pa_kruszec',
                        'field' => 'term_id',
                        'terms' => $product_kruszec
                    ),
                    array(
                        'taxonomy' => 'pa_asortyment',
                        'field' => 'term_id',
                        'terms' => $product_asortyment,
                        'operator' => 'NOT IN'
                    ),
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'operator' => 'IN',
                        'terms' => $category
                    ),
                ),
            ); 
            $loop = new WP_Query( $args );
            if($loop->post_count < 3)
            {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => $productCount,
                    'hide_empty' => true,
                    'post__not_in' => array($product->get_ID()),
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
                            'terms' => $category
                        ),
                    ),
                );
                $loop = new WP_Query( $args );
                if($loop->post_count < 3)
                {
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => $productCount,
                        'hide_empty' => true,
                        'post__not_in' => array($product->get_ID()),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'term_id',
                                'operator' => 'IN',
                                'terms' => $category
                            ),
                        ),
                    );
                    $loop = new WP_Query( $args );
                }
            }
        }
    }
?>