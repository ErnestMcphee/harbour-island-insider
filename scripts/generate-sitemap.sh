#!/usr/bin/env bash
# =============================================================
# Harbour Island Insider — sitemap generator
#
# Scans ./frontend for *.html pages (excluding 404, drafts,
# and files starting with _), derives per-file lastmod from
# the file's most recent git commit date, assigns priority +
# changefreq based on path, and writes frontend/sitemap.xml.
#
# Env:
#   SITE_URL   Base URL with no trailing slash.
#              Defaults to the GitHub Pages URL.
# =============================================================

set -euo pipefail

SITE_URL="${SITE_URL:-https://ernestmcphee.github.io/harbour-island-insider}"
FRONTEND_DIR="${FRONTEND_DIR:-frontend}"
OUT="${FRONTEND_DIR}/sitemap.xml"

if [[ ! -d "$FRONTEND_DIR" ]]; then
  echo "error: ${FRONTEND_DIR}/ not found (run from repo root)" >&2
  exit 1
fi

# Resolve each page's rules.
# prints: "<priority>|<changefreq>" for a given relative path.
rules_for() {
  local rel="$1"
  case "$rel" in
    index.html)              echo "1.0|weekly" ;;
    blog.html)               echo "0.9|weekly" ;;
    articles/*.html)         echo "0.9|monthly" ;;
    where-to-stay.html)      echo "0.8|monthly" ;;
    about.html)              echo "0.5|yearly" ;;
    *)                       echo "0.6|monthly" ;;
  esac
}

# Get a page's lastmod from git (YYYY-MM-DD). Falls back to today
# if the file isn't tracked yet (e.g. first commit of a new page).
lastmod_for() {
  local path="$1"
  local d
  d=$(git log -1 --format=%cs -- "$path" 2>/dev/null || true)
  if [[ -z "$d" ]]; then
    d=$(date -u +%Y-%m-%d)
  fi
  echo "$d"
}

# URL-safe relative path. Our filenames are plain ASCII so no encoding needed,
# but we strip a leading './' and collapse any accidental double slashes.
canon_path() {
  local p="$1"
  p="${p#./}"
  # Root page is served at '/', not '/index.html'
  if [[ "$p" == "index.html" ]]; then
    echo ""
  else
    echo "$p"
  fi
}

# Collect candidate pages (portable: works on macOS bash 3.2 and Linux bash 5).
PAGES_LIST=$(
  cd "$FRONTEND_DIR"
  find . -type f -name '*.html' \
    ! -name '404.html' \
    ! -name '_*' \
    ! -name 'draft-*' \
    | sed 's|^\./||' \
    | sort
)

if [[ -z "$PAGES_LIST" ]]; then
  echo "error: no html pages found under ${FRONTEND_DIR}/" >&2
  exit 1
fi

# Count pages.
n=$(printf '%s\n' "$PAGES_LIST" | grep -c .)

# Write sitemap.
{
  echo '<?xml version="1.0" encoding="UTF-8"?>'
  echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
  echo ''
  while IFS= read -r rel; do
    [[ -z "$rel" ]] && continue
    rules=$(rules_for "$rel")
    priority="${rules%|*}"
    changefreq="${rules#*|}"
    lastmod=$(lastmod_for "$FRONTEND_DIR/$rel")
    canon=$(canon_path "$rel")
    loc="${SITE_URL}/${canon}"
    printf '  <url>\n'
    printf '    <loc>%s</loc>\n' "$loc"
    printf '    <lastmod>%s</lastmod>\n' "$lastmod"
    printf '    <changefreq>%s</changefreq>\n' "$changefreq"
    printf '    <priority>%s</priority>\n' "$priority"
    printf '  </url>\n\n'
  done <<< "$PAGES_LIST"
  echo '</urlset>'
} > "$OUT"

echo "wrote $OUT ($n urls, base=${SITE_URL})"
