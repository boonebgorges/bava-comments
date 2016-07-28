<?php
/**
 * Plugin Name: Bava Comments
 * Version: 0.1-alpha
 * Description: Nobody comments like the Bava. Nobody!
 * Author: Boone Gorges
 * Author URI: https://boone.gorg.es
 * Plugin URI: https://commons.gc.cuny.edu
 * Text Domain: bava-comments
 * Domain Path: /languages
 */

function bava_comments_filter( $comment ) {
	$img_regex = '#^(https?://\S+\.(gif|jpg|png))\s*$#m';
	$comment = preg_replace_callback( $img_regex, 'bava_comments_convert_to_img_tag_callback', $comment );

	$giphy_regex = '#^https?://giphy\.com/gifs/([^/]+?)$#m';
	$comment = preg_replace_callback( $giphy_regex, 'bava_comments_convert_giphy_callback', $comment );

	return $comment;
}
add_filter( 'comment_text', 'bava_comments_filter', 5 );

function bava_comments_img_template() {
	return '<img src="%s" class="bava-comments-image" />';
}

function bava_comments_convert_to_img_tag_callback( $matches ) {
	bava_comments_has_embeds( true );
	return sprintf(
		bava_comments_img_template(),
		esc_url( $matches[1] )
	);
}

function bava_comments_convert_giphy_callback( $matches ) {
	bava_comments_has_embeds( true );
	$parts = explode( '-', $matches[1] );
	$base = array_pop( $parts );
	$url = 'https://media.giphy.com/media/' . $base . '/giphy.gif';
	return sprintf(
		bava_comments_img_template(),
		esc_url( $url )
	);
}

function bava_comments_has_embeds( $set = null ) {
	static $has_embeds = false;

	if ( null !== $set ) {
		$has_embeds = (bool) $set;
	}

	return $has_embeds;
}

function bava_comments_footer_style() {
	if ( ! bava_comments_has_embeds() ) {
		return;
	}

	?>
<style type="text/css">
.bava-comments-image {
	max-width: 100%;
}
</style>
	<?php
}
add_action( 'wp_footer', 'bava_comments_footer_style' );
