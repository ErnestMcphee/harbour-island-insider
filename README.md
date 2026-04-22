# Harbour Island Insider

An independent travel blog for Harbour Island, Bahamas — pink sand beaches, world-class diving, marina life, food, and honest local recommendations.

## Live site

Deployed via GitHub Pages from the [`frontend/`](./frontend) folder on every push to `main`.

## Project layout

```
frontend/          Static HTML/CSS/JS — this is what ships to GitHub Pages
wordpress/         WordPress child theme + custom plugin (migration target)
content/           Article drafts and editorial calendar
docs/              Setup notes
email/             Newsletter templates and Mailchimp automation briefs
seo/               robots.txt, sitemap.xml
social/            Launch kit and social copy
```

## Local preview

```bash
npx serve -p 3456 ./frontend
```

Then open <http://localhost:3456>.

## Editorial note

All recommendations are based on our own independent editorial assessment. We are not commercially affiliated with any resort, marina, or government body. Where a contributor has a direct connection to a property, it is disclosed on the article.
