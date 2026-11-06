const NAV = [
  { href: "/", label: "Home", id: "home" },
  { href: "/#about", label: "About", id: "about" },
  { href: "/#agenda", label: "Agenda", id: "programme" },
  { href: "/#speakers", label: "Speakers", id: "speakers" },
  { href: "/partners.html", label: "Partners", id: "partners" },
  { href: "/#media", label: "Media", id: "events" },
  { href: "/contact.html", label: "Contact", id: "contact" },
];

const page = document.body.dataset.page || "home";

function current(id) {
  if (id === page) return ' aria-current="page"';
  return "";
}

const ICON_PATHS = {
  home: '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1z"/>',
  about: '<circle cx="12" cy="8" r="3"/><path d="M5 19c1.2-3 3.4-4.5 7-4.5S17.8 16 19 19"/>',
  programme: '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/>',
  speakers: '<rect x="9" y="3" width="6" height="10" rx="3"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M8 21h8"/>',
  partners: '<circle cx="8" cy="9" r="2.4"/><circle cx="16" cy="9" r="2.4"/><path d="M3.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5M11.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5"/>',
  events: '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="m10 9 5 3-5 3z"/>',
  contact: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
  mission: '<circle cx="12" cy="12" r="8"/><path d="M12 8v4l3 2"/>',
  membership: '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/>',
  partner: '<path d="M12 5v14M5 12h14"/>',
  privacy: '<path d="M12 3 5 6v6c0 4.2 2.8 7.2 7 8.5 4.2-1.3 7-4.3 7-8.5V6z"/>',
  terms: '<path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M9 13h6M9 17h6"/>',
  linkedin: '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 10v7M8 7h.01M12 17v-4.2a2 2 0 0 1 4 0V17"/>',
  instagram: '<rect x="4" y="4" width="16" height="16" rx="4"/><circle cx="12" cy="12" r="3.5"/><path d="M17.5 6.5h.01"/>',
  youtube: '<rect x="3" y="6" width="18" height="12" rx="3"/><path d="m10 9 5 3-5 3z"/>',
  facebook: '<path d="M14 8h2V5h-2a3 3 0 0 0-3 3v2H9v3h2v6h3v-6h2.2l.8-3H14V8a1 1 0 0 1 1-1z"/>',
};

function icon(id) {
  return `<svg class="nav-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">${ICON_PATHS[id] || ICON_PATHS.home}</svg>`;
}

function socialIcon(id, label) {
  return `<span aria-label="${label}, to be added">${icon(id)}</span>`;
}

function link(item) {
  const child = (item.children || [])
    .map((entry) => `<a href="${entry.href}"${current(entry.id)}>${icon(entry.id)}${entry.label}</a>`)
    .join("");
  const menu = child ? `<div class="dropdown">${child}</div>` : "";
  const active = item.id === page || (item.children || []).some((entry) => entry.id === page);
  return `<div class="menu-item"><a href="${item.href}"${active ? ' aria-current="page"' : ""}>${icon(item.id)}${item.label}</a>${menu}</div>`;
}

function renderChrome() {
  const header = document.querySelector("#site-header");
  const footer = document.querySelector("#site-footer");
  if (header) {
    header.className = "site-header";
    header.innerHTML = `
      <a class="logo" href="/">
        <strong>HORIZON<br />GLOBAL<br />AFFAIRS</strong>
        <span>FORUM</span>
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
        <a class="logo" href="/"><strong>HOHORIZON<br />GLOBAL<br />AFFAIRS</strong><span>FORUM</span></a>
        <p style="margin-top:16px;max-width:28rem;color:rgba(251,250,247,.78)">An invitation-led forum for executives, investors, policymakers and operators who need a quieter room for serious conversations.</p>
        <div class="socials" aria-label="Social media">
          ${socialIcon("linkedin", "LinkedIn")}
          ${socialIcon("instagram", "Instagram")}
          ${socialIcon("youtube", "YouTube")}
          ${socialIcon("facebook", "Facebook")}
        </div>
      </div>
      <div>
        <h2>Quick links</h2>
        <ul>
          <li><a href="/about.html">${icon("about")}About Us</a></li>
          <li><a href="/mission.html">${icon("mission")}Our Mission</a></li>
          <li><a href="/membership.html">${icon("membership")}Membership</a></li>
          <li><a href="/contact.html">${icon("contact")}Contact</a></li>
          <li><a href="/privacy.html">${icon("privacy")}Privacy Policy</a></li>
          <li><a href="/terms.html">${icon("terms")}Terms &amp; Conditions</a></li>
        </ul>
      </div>
      <div>
        <h2>Explore</h2>
        <ul>
          <li><a href="/events.html">${icon("events")}Events</a></li>
          <li><a href="/programme.html">${icon("programme")}Programme</a></li>
          <li><a href="/speakers.html">${icon("speakers")}Speakers</a></li>
          <li><a href="/partners.html">${icon("partners")}Partners</a></li>
          <li><a href="/become-a-partner.html">${icon("partner")}Become a Partner</a></li>
          <li><a href="/invitation.html">${icon("contact")}Request an invitation</a></li>
        </ul>
      </div>
      <div>
        <h2>Contact</h2>
        <ul>
          <li>Email to be confirmed</li>
          <li>Venue to be confirmed</li>
        </ul>
      </div>
      <div class="fineprint">
        <span>© ${new Date().getFullYear()} Hohorizon Global Affairs. All Rights Reserved.</span>
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
  if (!video) return;
  const start = () => {
    video.hidden = false;
    const play = video.play();
    if (play) play.catch(() => {});
  };
  video.addEventListener("loadeddata", start);
  video.addEventListener("ended", () => {
    video.currentTime = 0;
    start();
  });
  video.addEventListener("error", () => {
    video.hidden = true;
  });
  if (video.readyState >= 2) start();
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

function initCounters() {
  const nodes = [...document.querySelectorAll("[data-count]")];
  if (!nodes.length) return;
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const paint = (node, value) => {
    node.textContent = `${value}${node.dataset.suffix || ""}`;
  };
  const run = (node) => {
    const target = Number(node.dataset.count);
    if (reduce || Number.isNaN(target)) {
      paint(node, target);
      return;
    }
    const start = performance.now();
    const step = (now) => {
      const progress = Math.min(1, (now - start) / 1100);
      const eased = 1 - (1 - progress) ** 3;
      paint(node, Math.round(target * eased));
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        run(entry.target);
        observer.unobserve(entry.target);
      });
    },
    { threshold: 0.6 }
  );
  nodes.forEach((node) => observer.observe(node));
}

function initSpeakers() {
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  document.querySelectorAll(".portrait-row").forEach((row) => {
    const track = row.querySelector(".portrait-track");
    if (!track) return;
    const card = track.querySelector(".portrait");
    const advance = (dir = 1) => {
      const width = card ? card.getBoundingClientRect().width + 16 : 212;
      const max = track.scrollWidth - track.clientWidth;
      if (max <= 4) return;
      if (dir > 0 && track.scrollLeft >= max - 4) track.scrollTo({ left: 0, behavior: "smooth" });
      else if (dir < 0 && track.scrollLeft <= 4) track.scrollTo({ left: max, behavior: "smooth" });
      else track.scrollBy({ left: dir * width, behavior: "smooth" });
    };
    row.querySelectorAll(".portrait-arrow").forEach((button) => {
      button.addEventListener("click", () => advance(Number(button.dataset.dir) || 1));
    });
    if (reduce) return;
    let timer = 0;
    const stop = () => window.clearInterval(timer);
    const start = () => {
      stop();
      if (row.querySelector(".portrait.is-open")) return;
      timer = window.setInterval(() => advance(1), 3200);
    };
    row.addEventListener("mouseenter", stop);
    row.addEventListener("mouseleave", start);
    row.addEventListener("focusin", stop);
    row.addEventListener("focusout", (event) => {
      if (!row.contains(event.relatedTarget)) start();
    });
    start();
  });
  document.querySelectorAll(".portrait-more").forEach((button) => {
    button.addEventListener("click", () => {
      const card = button.closest(".portrait");
      const open = card.classList.toggle("is-open");
      button.setAttribute("aria-expanded", String(open));
    });
  });
}

function initIntro() {
  document.body.classList.add("is-ready");
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
initSpeakers();
initIntro();
initCounters();
initReveal();
initCookie();
if (localStorage.getItem("hohorizon-cookie") === "accept") loadAnalytics();
