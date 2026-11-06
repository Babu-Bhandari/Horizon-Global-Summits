import { defineConfig } from "vite";

const pages = [
  "index",
  "about",
  "mission",
  "events",
  "event",
  "programme",
  "speakers",
  "partners",
  "membership",
  "become-a-partner",
  "invitation",
  "contact",
  "privacy",
  "terms",
];

export default defineConfig({
  server: {
    port: 5173,
    strictPort: false,
    watch: {
      ignored: ["**/*.mp4"],
    },
  },
  build: {
    rollupOptions: {
      input: Object.fromEntries(pages.map((name) => [name, `${name}.html`])),
    },
  },
});
