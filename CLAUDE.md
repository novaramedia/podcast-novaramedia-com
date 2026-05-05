# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

Minimal WordPress theme for `podcast.novaramedia.com` — the podcast RSS/audio hosting subdomain for Novara Media. Not a content site; serves as a landing page linking out to podcast directories and as the WordPress install that hosts RSS feeds and audio files.

## Local development

Uses **DevKinsta** for local WordPress. No build step — no bundler, no compiled assets. Edit PHP/CSS directly; changes are live immediately via DevKinsta's local server.

Plugin dependency: **CMB2** must be active for meta boxes to work.

## Architecture

**Single responsibility per file:**

- `header.php` — all inline CSS lives here; also handles the single-post redirect logic (see below)
- `footer.php` — footer markup + `wp_footer()`
- `index.php` — calls `get_header()` / `get_footer()` only (the landing page content is entirely in `header.php`)
- `lib/meta-boxes.php` — CMB2 meta box: adds `_cmb_redirect` (text URL) field to posts
- `lib/post-types.php` — currently empty; reserved for custom post types if needed
- `functions.php` — enqueues (JS currently commented out), image sizes, includes `lib/`, strips unused WP assets

**Post redirect mechanism:** When viewing a single post, `header.php` reads `_cmb_redirect` meta. If set, it issues a `301` redirect to that URL before any HTML output. This is how podcast episode posts on this WordPress install link back to the canonical episode page on `novaramedia.com`.

**No stylesheet loaded** — `style.css` contains only the WP theme header comment block. All styles are inline in `header.php`.

## Podcast links

The landing page (`header.php`) lists podcasts by name with links to podfollow.com aggregator pages, except Foreign Agent which links directly to `novaramedia.com/category/audio/foreign-agent/`. To add/remove/rename a podcast, edit the `<ul>` in `header.php`.
