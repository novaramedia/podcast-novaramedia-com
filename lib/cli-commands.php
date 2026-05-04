<?php
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Novara podcast theme CLI commands.
 */
class NM_Podcast_CLI {

	/**
	 * Rewrite GCS direct audio URLs to the Cloudflare-proxied hostname.
	 *
	 * Finds all PowerPress enclosure postmeta rows where the URL points to
	 * storage.googleapis.com/audiofiles.novara.io and rewrites them to
	 * audiofiles.novara.io.
	 *
	 * ## OPTIONS
	 *
	 * [--live]
	 * : Apply changes. Omit for a dry run.
	 *
	 * ## EXAMPLES
	 *
	 *     wp nm fix-audio-urls
	 *     wp nm fix-audio-urls --live
	 *
	 * @when after_wp_load
	 */
	public static function fix_audio_urls( $args, $assoc_args ) {
		$live = (bool) WP_CLI\Utils\get_flag_value( $assoc_args, 'live', false );

		if ( ! $live ) {
			WP_CLI::line( 'DRY RUN — pass --live to apply changes.' );
			WP_CLI::line( '' );
		}

		global $wpdb;

		$rows = $wpdb->get_results(
			"SELECT meta_id, post_id, meta_key, meta_value
			 FROM {$wpdb->postmeta}
			 WHERE ( meta_key = 'enclosure' OR meta_key LIKE '%:enclosure' )
			   AND meta_value LIKE '%storage.googleapis.com/audiofiles.novara.io/%'"
		);

		if ( empty( $rows ) ) {
			WP_CLI::success( 'No rows with bad URLs found.' );
			return;
		}

		WP_CLI::line( sprintf( 'Found %d row(s) to fix:', count( $rows ) ) );

		$updated = 0;

		foreach ( $rows as $row ) {
			$lines   = explode( "\n", $row->meta_value );
			$old_url = trim( $lines[0] );
			$new_url = preg_replace(
				'#^(https?://)storage\.googleapis\.com/audiofiles\.novara\.io/#',
				'https://audiofiles.novara.io/',
				$old_url
			);

			if ( $new_url === $old_url ) {
				continue;
			}

			$lines[0]  = $new_url;
			$new_value = implode( "\n", $lines );

			WP_CLI::line( sprintf(
				'  post %d [%s]' . PHP_EOL . '    - %s' . PHP_EOL . '    + %s',
				$row->post_id,
				$row->meta_key,
				$old_url,
				$new_url
			) );

			$updated++;

			if ( $live ) {
				$result = $wpdb->update(
					$wpdb->postmeta,
					array( 'meta_value' => $new_value ),
					array( 'meta_id'    => $row->meta_id ),
					array( '%s' ),
					array( '%d' )
				);
				if ( false === $result ) {
					WP_CLI::warning( sprintf( 'Failed to update meta_id %d (post %d).', $row->meta_id, $row->post_id ) );
					$updated--;
				}
			}
		}

		if ( $live ) {
			WP_CLI::success( sprintf( 'Updated %d row(s).', $updated ) );
		} else {
			WP_CLI::line( '' );
			WP_CLI::line( sprintf( '%d row(s) would be updated. Re-run with --live to apply.', $updated ) );
		}
	}
}

WP_CLI::add_command( 'nm fix-audio-urls', array( 'NM_Podcast_CLI', 'fix_audio_urls' ) );
