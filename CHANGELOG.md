# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.0] - 2026-05-06

### Security

- Fixed open redirect vulnerability in single-post redirect: replaced raw `header('Location: …')` with `wp_safe_redirect()`, which validates the redirect destination against an allowlist
- Fixed PHP notice when `_cmb_redirect` post meta is absent by using `get_post_meta()` with the `$single` parameter instead of indexing the full meta array
- Added `allowed_redirect_hosts` filter to permit intentional cross-domain redirects to `novaramedia.com`

## [1.2.0] - 2026-05-06

### Added

- Webpack build pipeline with Stylus compilation and nm-stylus-library design system

### Changed

- Landing page layout and styles updated to match current novaramedia.com design
- Updated podcast directory links

## [1.1.0] - 2026-05-05

### Added

- Hook to auto-rewrite GCS direct audio URLs to Cloudflare-proxied hostname on every PowerPress episode save
- WP-CLI command (`wp nm fix-audio-urls`) to bulk-rewrite enclosure URLs across the back-catalogue

## [1.0.0] - 2022-05-23

Initial versioned release.
