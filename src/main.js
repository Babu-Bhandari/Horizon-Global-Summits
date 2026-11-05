const NAV = [
  {
    href: "/about.html",
    label: "About",
    id: "about",
    children: [{ href: "/mission.html", label: "Our Mission", id: "mission" }],
  },
  { href: "/programme.html", label: "Agenda", id: "programme" },
  { href: "/speakers.html", label: "Speakers", id: "speakers" },
  {
    href: "/partners.html",
    label: "Partners",
    id: "partners",
    children: [
      { href: "/membership.html", label: "Membership", id: "membership" },
      { href: "/become-a-partner.html", label: "Become a Partner", id: "partner" },
    ],
  },
  { href: "/events.html", label: "Media", id: "events" },
  { href: "/contact.html", label: "Contact", id: "contact" },
];

const page = document.body.dataset.page || "home";

function current(id) {
  if (id === page) return ' aria-current="page"';
  return "";
}

function link(item) {
  const child = (item.children || [])
    .map((entry) => `<a href="${entry.href}"${current(entry.id)}>${entry.label}</a>`)
    .join("");
  const menu = child ? `<div class="dropdown">${child}</div>` : "";
  const active = item.id === page || (item.children || []).some((entry) => entry.id === page);
  return `<div class="menu-item"><a href="${item.href}"${active ? ' aria-current="page"' : ""}>${item.label}</a>${menu}</div>`;
}

function renderChrome() {
  const header = document.querySelector("#site-header");
  const footer = document.querySelector("#site-footer");
  if (header) {
    header.className = "site-header";
    header.innerHTML = `
      <a class="logo" href="/">
        <strong>HOHORIZON<br />GLOBAL<br />AFFAIRS</strong>
        <span>Forum</span>
      </a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">Menu</button>
      <nav class="nav" id="site-nav" aria-label="Primary">
        ${NAV.map(link).join("")}
        <a class="btn nav-cta" href="/become-a-partner.html">Become a partner</a>
        <a class="btn nav-cta" href="/invitation.html">Request an invite</a>
      </nav>
      <div class="header-actions">
        <a class="btn" href="/become-a-partner.html">Become a partner</a>
        <a class="btn" href="/invitation.html">Request an invite</a>
      </div>
    `;
  }
  if (footer) {
    footer.className = "site-footer";
    footer.innerHTML = `
      <div>
        <a class="logo" href="/"><strong>HOHORIZON<br />GLOBAL<br />AFFAIRS</strong><span>Forum</span></a>
        <p style="margin-top:16px;max-width:28rem;color:rgba(251,250,247,.78)">An invitation-led forum for executives, investors, policymakers and operators who need a quieter room for serious conversations.</p>
        <div class="socials" aria-label="Social media">
          <span>LinkedIn — to be added</span>
          <span>Instagram — to be added</span>
          <span>YouTube — to be added</span>
          <span>Facebook — to be added</span>
        </div>
      </div>
      <div>
        <h2>Quick links</h2>
        <ul>
          <li><a href="/about.html">About Us</a></li>
          <li><a href="/mission.html">Our Mission</a></li>
          <li><a href="/membership.html">Membership</a></li>
          <li><a href="/contact.html">Contact</a></li>
          <li><a href="/privacy.html">Privacy Policy</a></li>
          <li><a href="/terms.html">Terms &amp; Conditions</a></li>
        </ul>
      </div>
      <div>
        <h2>Explore</h2>
        <ul>
          <li><a href="/events.html">Events</a></li>
          <li><a href="/programme.html">Programme</a></li>
          <li><a href="/speakers.html">Speakers</a></li>
          <li><a href="/partners.html">Partners</a></li>
          <li><a href="/become-a-partner.html">Become a Partner</a></li>
          <li><a href="/invitation.html">Request an invitation</a></li>
        </ul>
      </div>
      <div>
        <h2>Contact</h2>
        <ul>
          <li>Email to be confirmed</li>
          <li>Venue to be confirmed</li>
        </ul>
        <form class="site-form" style="margin-top:18px" data-kind="newsletter">
          <label>Newsletter<input type="email" name="email" required autocomplete="email" placeholder="Email address" /></label>
          <label class="hp" aria-hidden="true">Website<input name="website" tabindex="-1" autocomplete="off" /></label>
          <button class="btn" type="submit">Subscribe</button>
          <p class="form-error" hidden></p>
        </form>
        <div class="thanks" hidden><p>Thank you. This preview has no mailing list connected yet.</p></div>
      </div>
      <div class="fineprint">
        <span>© ${new Date().getFullYear()} HOHORIZON GLOBAL AFFAIRS</span>
        <span>Placeholders are not confirmed facts.</span>
      </div>
    `;
  }
}

function initHeader() {
  const header = document.querySelector(".site-header");
  if (!header) return;
  const toggle = header.querySelector(".nav-toggle");
  const onScroll = () => header.classList.toggle("is-solid", window.scrollY > 20);
  onScroll();
  window.addEventListener("scroll", onScroll, { passive: true });
  toggle?.addEventListener("click", () => {
    const open = header.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", String(open));
  });
  header.querySelectorAll("a").forEach((anchor) => {
    anchor.addEventListener("click", () => {
      header.classList.remove("is-open");
      toggle?.setAttribute("aria-expanded", "false");
    });
  });
}

function initFilters() {
  const bar = document.querySelector(".filters");
  if (!bar) return;
  const buttons = [...bar.querySelectorAll("button")];
  const items = [...document.querySelectorAll("[data-topic]")];
  const apply = (topic) => {
    buttons.forEach((button) => button.setAttribute("aria-pressed", String(button.dataset.filter === topic)));
    items.forEach((item) => {
      item.hidden = topic !== "all" && item.dataset.topic !== topic;
    });
  };
  bar.addEventListener("click", (event) => {
    const button = event.target.closest("button");
    if (!button) return;
    apply(button.dataset.filter);
  });
}

function initEvents() {
  const panels = [...document.querySelectorAll("[data-event]")];
  if (!panels.length) return;
  const selected = new URLSearchParams(location.search).get("event") || "flagship";
  const known = panels.some((panel) => panel.dataset.event === selected);
  const active = known ? selected : "flagship";
  panels.forEach((panel) => panel.classList.toggle("is-on", panel.dataset.event === active));
}

function initForms() {
  document.querySelectorAll(".site-form").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const error = form.querySelector(".form-error");
      if (form.website?.value) {
        if (error) {
          error.hidden = false;
          error.textContent = "The note could not be sent.";
        }
        return;
      }
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      const to = (document.body.dataset.email || "").trim();
      const data = new FormData(form);
      const kind = form.dataset.kind || "note";
      if (to) {
        const body = [...data.entries()]
          .filter(([key]) => key !== "website")
          .map(([key, value]) => `${key}: ${value}`)
          .join("\n");
        window.location.href = `mailto:${to}?subject=${encodeURIComponent(`HOHORIZON ${kind}`)}&body=${encodeURIComponent(body)}`;
      }
      const thanks = form.nextElementSibling;
      if (thanks?.classList.contains("thanks")) {
        const copy = thanks.querySelector("p");
        if (copy && to) copy.textContent = "Your mail app should open with this note.";
        if (copy && !to) {
          copy.textContent = "This preview has no inbox connected yet. Add an address to data-email on the page and the form will open a mail draft.";
        }
        form.hidden = true;
        thanks.hidden = false;
      }
    });
  });
}

function initVideo() {
  const video = document.querySelector(".hero-video");
  if (!video || window.matchMedia("(max-width: 700px)").matches) return;
  video.addEventListener("loadeddata", () => video.hidden = false);
  video.addEventListener("error", () => {
    video.hidden = true;
  });
  video.hidden = true;
}

function initCookie() {
  if (localStorage.getItem("hohorizon-cookie")) return;
  const banner = document.createElement("div");
  banner.className = "cookie";
  banner.innerHTML = `
    <p>This site can store a cookie preference on this device. Analytics stays off until a measurement ID is added.</p>
    <div class="actions">
      <button class="btn" type="button" data-cookie="accept">Accept</button>
      <button class="btn btn-ink" type="button" data-cookie="decline">Decline</button>
    </div>
  `;
  banner.addEventListener("click", (event) => {
    const choice = event.target.closest("button")?.dataset.cookie;
    if (!choice) return;
    localStorage.setItem("hohorizon-cookie", choice);
    banner.remove();
    if (choice === "accept") loadAnalytics();
  });
  document.body.append(banner);
}

function loadAnalytics() {
  const id = (document.body.dataset.ga || "").trim();
  if (!id || document.querySelector(`script[data-ga="${id}"]`)) return;
  const script = document.createElement("script");
  script.async = true;
  script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(id)}`;
  script.dataset.ga = id;
  document.head.append(script);
  window.dataLayer = window.dataLayer || [];
  window.gtag = function gtag() { window.dataLayer.push(arguments); };
  window.gtag("js", new Date());
  window.gtag("config", id);
}

function initClock() {
  const clock = document.querySelector(".clock");
  if (!clock) return;
  const target = Date.parse(clock.dataset.countdown || "");
  if (Number.isNaN(target)) return;
  const units = {
    days: clock.querySelector("[data-unit='days']"),
    hours: clock.querySelector("[data-unit='hours']"),
    minutes: clock.querySelector("[data-unit='minutes']"),
    seconds: clock.querySelector("[data-unit='seconds']"),
  };
  const paint = () => {
    const left = Math.max(0, target - Date.now());
    const total = Math.floor(left / 1000);
    const days = Math.floor(total / 86400);
    const hours = Math.floor((total % 86400) / 3600);
    const minutes = Math.floor((total % 3600) / 60);
    const seconds = total % 60;
    units.days.textContent = String(days).padStart(2, "0");
    units.hours.textContent = String(hours).padStart(2, "0");
    units.minutes.textContent = String(minutes).padStart(2, "0");
    units.seconds.textContent = String(seconds).padStart(2, "0");
  };
  paint();
  window.setInterval(paint, 1000);
}

function initIntro() {
  const intro = document.querySelector("#intro");
  const count = document.querySelector("#intro-pct");
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  if (!intro) return;
  if (reduce) {
    intro.remove();
    document.body.classList.add("is-ready");
    return;
  }
  document.body.classList.add("is-intro");
  const start = performance.now();
  const duration = 2200;
  const step = (now) => {
    const progress = Math.min(1, (now - start) / duration);
    const value = Math.round(progress * 100);
    if (count) count.textContent = String(value).padStart(3, "0");
    if (progress < 1) {
      requestAnimationFrame(step);
      return;
    }
    intro.classList.add("is-leaving");
    document.body.classList.remove("is-intro");
    window.setTimeout(() => document.body.classList.add("is-ready"), 420);
    window.setTimeout(() => intro.remove(), 1100);
  };
  requestAnimationFrame(step);
}

function initReveal() {
  const nodes = document.querySelectorAll(".section, .event-card, .topic, .speaker, .card, .stat");
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
  nodes.forEach((node) => node.classList.add("reveal"));
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add("is-in");
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.18 }
  );
  nodes.forEach((node) => observer.observe(node));
}

renderChrome();
initHeader();
initFilters();
initEvents();
initForms();
initVideo();
initClock();
initIntro();
initReveal();
initCookie();
if (localStorage.getItem("hohorizon-cookie") === "accept") loadAnalytics();
