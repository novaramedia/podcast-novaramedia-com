<?php
/**
 * Rewrites GCS direct audio URLs to the Cloudflare-proxied hostname.
 *
 * Hooks into added_post_meta / updated_post_meta so it fires immediately
 * after PowerPress saves each enclosure row — no re-query needed.
 *
 * Bad:  https://storage.googleapis.com/audiofiles.novara.io/path/file.mp3
 * Good: https://audiofiles.novara.io/path/file.mp3
 */

add_action( 'added_post_meta',   'nm_fix_enclosure_meta', 10, 4 );
add_action( 'updated_post_meta', 'nm_fix_enclosure_meta', 10, 4 );

function nm_fix_enclosure_meta( $meta_id, $object_id, $meta_key, $meta_value ) {
	if ( $meta_key !== 'enclosure' && ! preg_match( '/^_.+:enclosure$/', $meta_key ) ) {
		return;
	}

	$rewritten = nm_rewrite_enclosure_value( $meta_value );
	if ( $rewritten === $meta_value ) {
		return;
	}

	global $wpdb;
	$wpdb->update(
		$wpdb->postmeta,
		array( 'meta_value' => $rewritten ),
		array( 'meta_id'    => $meta_id ),
		array( '%s' ),
		array( '%d' )
	);
}

/**
 * Rewrites the URL (first line) of a PowerPress enclosure meta value.
 * Enclosure format: URL\nfilesize\ntype\nduration
 */
function nm_rewrite_enclosure_value( $value ) {
	$lines    = explode( "\n", $value );
	$lines[0] = nm_rewrite_audio_url( trim( $lines[0] ) );
	return implode( "\n", $lines );
}

function nm_rewrite_audio_url( $url ) {
	return preg_replace(
		'#^(https?://)storage\.googleapis\.com/audiofiles\.novara\.io/#',
		'https://audiofiles.novara.io/',
		$url
	);
}
