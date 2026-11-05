# HOHORIZON GLOBAL AFFAIRS

A multi-page site for an international business forum. It runs locally with Vite.

The preview at localhost is still the static site. The same design is also a WordPress theme in `wordpress-theme/hohorizon`. Upload that folder in Appearance → Themes, then activate it. Edit the hero in Appearance → Customize, and edit pages, events, speakers, sessions, and partners from the admin menu.

## Run it

```bash
npm install
npm run dev
```

Open the address Vite prints, usually http://localhost:5173.

## Edit the site

- Words, dates, venues and buttons live in the HTML page for that section.
- Shared navigation and footer live in `src/main.js`.
- Colours, type and layout live in `src/style.css`.
- Put a hero film at `public/hero.mp4`. On desktop it plays muted, looped and inline. Phones keep the still image.
- Set `data-email="you@example.com"` on each `<body>` when notes should open a mail draft.
- Set `data-ga="G-XXXXXXXX"` on each `<body>` to allow Analytics after a visitor accepts the cookie notice.

Placeholder dates, speakers, logos and figures are labelled. Replace them when the real details exist. Do not publish a sample profile as a confirmed speaker.

## Pages

Home, About, Mission, Events, Event details, Programme, Speakers, Partners, Membership, Become a Partner, Request an Invitation, Contact, Privacy, Terms.
