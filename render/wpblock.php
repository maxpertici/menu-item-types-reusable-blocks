<?php

$block_id = get_field( 'mitypes_wpblock_selector', $item->ID );


if( isset( $block_id ) && (int) $block_id > 0 ){

    $wpblock_tags = apply_filters( 'mitypes_wpkses_wpblock_tags', wp_kses_allowed_html('post') );

    echo wp_kses( $args->before, $wpblock_tags ) ;
    echo '<div' . $attributes . '>';
    echo wp_kses( $args->link_before, $wpblock_tags ) ;

    $content_post  = get_post( $block_id );
    $block_content = $content_post->post_content;
    $reusable_block = apply_filters( 'the_content',  $block_content ) ;

    echo wp_kses( $reusable_block, $wpblock_tags ) ;
    echo wp_kses( $args->link_after, $wpblock_tags ) ;

    echo '</div>';
    echo wp_kses( $args->after, $wpblock_tags ) ;

}