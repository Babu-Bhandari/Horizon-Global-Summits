const NAV = [
  { href: "/", label: "Home", id: "home" },
  { href: "/#about", label: "About", id: "about" },
  { href: "/#next-meet", label: "Conference", id: "conference" },
  { href: "/#speakers", label: "Speakers", id: "speakers" },
  { href: "/#contact", label: "Contact", id: "contact" },
];

const page = document.body.dataset.page || "home";

function current(id) {
  if (id === page) return ' aria-current="page"';
  return "";
}

const ICON_PATHS = {
  home: '<path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6H10v6H5a1 1 0 0 1-1-1z"/>',
  about: '<circle cx="12" cy="8" r="3"/><path d="M5 19c1.2-3 3.4-4.5 7-4.5S17.8 16 19 19"/>',
  conference: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M8 3v4M16 3v4M7 11h10M12 11v5"/>',
  programme: '<rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/>',
  speakers: '<rect x="9" y="3" width="6" height="10" rx="3"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M8 21h8"/>',
  partners: '<circle cx="8" cy="9" r="2.4"/><circle cx="16" cy="9" r="2.4"/><path d="M3.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5M11.5 18.5c.7-2.4 2.3-3.5 4.5-3.5s3.8 1.1 4.5 3.5"/>',
  events: '<rect x="3" y="6" width="18" height="12" rx="2"/><path d="m10 9 5 3-5 3z"/>',
  contact: '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
  pin: '<path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
  clock: '<circle cx="12" cy="12" r="8"/><path d="M12 8v5l3 2"/>',
  phone: '<path d="M8 4h3l1.4 3.4-1.8 1.1a11 11 0 0 0 4.9 4.9l1.1-1.8L21 13v3a2 2 0 0 1-2.2 2A16 16 0 0 1 6 5.2 2 2 0 0 1 8 4z"/>',
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
  const links = {
    linkedin: "https://www.linkedin.com/company/horizon-global-summits/",
  };
  const href = links[id];
  if (href) {
    return `<a href="${href}" aria-label="${label}">${icon(id)}</a>`;
  }
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
      <a class="logo" href="/" aria-label="Horizon Global Summits">
        <img class="logo-for-dark" src="/logo-horizon.png" alt="" />
        <img class="logo-for-light" src="/logo-horizon-dark.png" alt="" />
      </a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" aria-label="Open menu"><span class="nav-toggle-mark" aria-hidden="true"><span class="nav-toggle-box"></span></span><span class="nav-toggle-label">MENU</span></button>
      <nav class="nav" id="site-nav" aria-label="Primary">
        ${NAV.map(link).join("")}
      </nav>
      <div class="header-actions">
        <button class="theme-toggle" type="button" aria-pressed="false" aria-label="Switch to light mode"><svg class="theme-icon theme-icon-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 3v2M12 19v2M3 12h2M19 12h2M5.2 5.2l1.4 1.4M17.4 17.4l1.4 1.4M18.8 5.2l-1.4 1.4M6.6 17.4l-1.4 1.4"/></svg><svg class="theme-icon theme-icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 14.5A8 8 0 1 1 9.5 4 6.5 6.5 0 0 0 20 14.5z"/></svg></button>
      </div>
    `;
  }
  if (footer) {
    footer.className = "site-footer";
    footer.innerHTML = `
      <div>
        <a class="logo" href="/" aria-label="Horizon Global Summits"><img class="logo-for-dark" src="/logo-horizon.png" alt="" /><img class="logo-for-light" src="/logo-horizon-dark.png" alt="" /></a>
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
          <li><a href="/#next-meet">${icon("conference")}Conference</a></li>
          <li><a href="/#contact">${icon("contact")}Contact</a></li>
          <li><a href="/privacy.html">${icon("privacy")}Privacy Policy</a></li>
          <li><a href="/terms.html">${icon("terms")}Terms &amp; Conditions</a></li>
        </ul>
      </div>
      <div>
        <h2>Contact</h2>
        <ul>
          <li><a href="mailto:connect@horizonglobalsummits.com">${icon("contact")}connect@horizonglobalsummits.com</a></li>
          <li><span class="contact-line">${icon("pin")}Dubai, United Arab Emirates</span></li>
          <li><span class="contact-line">${icon("clock")}09:30 AM to 5:30 PM GST (UTC+4)</span></li>
        </ul>
      </div>
      <div class="fineprint">
        <span>© ${new Date().getFullYear()} Horizon Global Summits. All Rights Reserved.</span>
        <nav class="legal" aria-label="Legal">
          <a href="/terms.html">Terms and conditions</a>
          <a href="/privacy.html">Privacy</a>
          <a href="/cookies.html">Cookie policy</a>
          <a href="/manage-cookies.html">Manage Cookies</a>
        </nav>
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
  const setOpen = (open) => {
    header.classList.toggle("is-open", open);
    document.body.classList.toggle("nav-open", open);
    toggle?.setAttribute("aria-expanded", String(open));
    toggle?.setAttribute("aria-label", open ? "Close menu" : "Open menu");
  };
  toggle?.addEventListener("click", () => setOpen(!header.classList.contains("is-open")));
  header.querySelectorAll("a").forEach((anchor) => {
    anchor.addEventListener("click", () => setOpen(false));
  });
  document.addEventListener("click", (event) => {
    if (!header.classList.contains("is-open")) return;
    const nav = header.querySelector(".nav");
    if (toggle?.contains(event.target) || nav?.contains(event.target)) return;
    setOpen(false);
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

const COUNTRIES = ["Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Costa Rica","Croatia","Cuba","Cyprus","Czechia","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","North Korea","North Macedonia","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"];

function initFancySelects() {
  const closeAll = (except) => {
    document.querySelectorAll(".fancy-select.is-open").forEach((node) => {
      if (node === except) return;
      node.classList.remove("is-open");
      const panel = node.querySelector(".fancy-select-panel");
      if (panel) panel.hidden = true;
    });
  };
  document.addEventListener("click", (event) => {
    if (!event.target.closest(".fancy-select")) closeAll();
  });
  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") closeAll();
  });
  document.querySelectorAll(".contact-form select").forEach((select) => {
    if (select.closest(".fancy-select")) return;
    const choices = [...select.options].filter((option) => option.value);
    const wrap = document.createElement("div");
    wrap.className = "fancy-select";
    select.after(wrap);
    wrap.append(select);
    const button = document.createElement("button");
    button.type = "button";
    button.className = "fancy-select-button";
    button.setAttribute("aria-haspopup", "listbox");
    const panel = document.createElement("div");
    panel.className = "fancy-select-panel";
    panel.hidden = true;
    const search = document.createElement("input");
    search.type = "search";
    search.className = "fancy-select-search";
    search.placeholder = "Search";
    search.setAttribute("aria-label", "Search");
    if (choices.length <= 8) search.hidden = true;
    const list = document.createElement("div");
    list.className = "fancy-select-list";
    list.setAttribute("role", "listbox");
    panel.append(search, list);
    const paint = () => {
      const current = select.options[select.selectedIndex];
      const empty = !select.value;
      button.innerHTML = `<span class="${empty ? "is-placeholder" : ""}">${current ? current.textContent : "Select"}</span><i aria-hidden="true"></i>`;
    };
    const choose = (option) => {
      select.value = option.value;
      select.dispatchEvent(new Event("change", { bubbles: true }));
      paint();
      wrap.classList.remove("is-open");
      panel.hidden = true;
      search.value = "";
    };
    const build = () => {
      const needle = search.value.trim().toLowerCase();
      const matches = choices.filter((option) => option.textContent.toLowerCase().includes(needle));
      list.replaceChildren();
      if (!matches.length) {
        const empty = document.createElement("p");
        empty.className = "fancy-select-empty";
        empty.textContent = "No matches";
        list.append(empty);
        return;
      }
      matches.forEach((option) => {
        const item = document.createElement("button");
        item.type = "button";
        item.setAttribute("role", "option");
        const selected = option.value === select.value;
        if (selected) item.setAttribute("aria-selected", "true");
        item.innerHTML = `<span></span><i class="fancy-check" aria-hidden="true"></i>`;
        item.querySelector("span").textContent = option.textContent;
        item.addEventListener("click", () => choose(option));
        list.append(item);
      });
      const current = list.querySelector('[aria-selected="true"]');
      if (current) current.scrollIntoView({ block: "nearest" });
    };
    search.addEventListener("input", build);
    search.addEventListener("keydown", (event) => {
      if (event.key !== "Enter") return;
      const first = list.querySelector("button");
      if (!first) return;
      event.preventDefault();
      first.click();
    });
    button.addEventListener("click", () => {
      const willOpen = panel.hidden;
      closeAll(wrap);
      if (!willOpen) {
        wrap.classList.remove("is-open");
        panel.hidden = true;
        return;
      }
      build();
      panel.hidden = false;
      wrap.classList.add("is-open");
      const space = window.innerHeight - button.getBoundingClientRect().bottom;
      panel.classList.toggle("is-up", space < 280 && button.getBoundingClientRect().top > space);
      if (!search.hidden) search.focus({ preventScroll: true });
    });
    wrap.append(button, panel);
    paint();
  });
}

function initCountries() {
  document.querySelectorAll("select[data-countries]").forEach((select) => {
    if (select.options.length > 1) return;
    COUNTRIES.forEach((name) => {
      const option = document.createElement("option");
      option.value = name;
      option.textContent = name;
      select.append(option);
    });
  });
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
        window.location.href = `mailto:${to}?subject=${encodeURIComponent(`Horizon ${kind}`)}&body=${encodeURIComponent(body)}`;
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

function initHero() {
  const hero = document.querySelector("[data-hero]");
  if (!hero) return;
  const reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // Photo slider inside the blob: crossfade with a slow zoom.
  const photos = [...hero.querySelectorAll(".hero-blob img")];
  if (photos.length > 1 && !reduced) {
    let index = 0;
    window.setInterval(() => {
      photos[index].classList.remove("is-on");
      index = (index + 1) % photos.length;
      photos[index].classList.add("is-on");
    }, 5000);
  }

  // Particle network behind the hero.
  const canvas = hero.querySelector(".hero-net-canvas");
  const ctx = canvas?.getContext("2d");
  if (!ctx) return;
  const LINK = 140;
  let width = 0;
  let height = 0;
  let points = [];
  let frame = 0;
  let visible = true;
  const mouse = { x: -9999, y: -9999 };

  const resize = () => {
    const ratio = Math.min(window.devicePixelRatio || 1, 2);
    width = hero.clientWidth;
    height = hero.clientHeight;
    canvas.width = width * ratio;
    canvas.height = height * ratio;
    ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
    const count = Math.max(28, Math.min(110, Math.round((width * height) / 15000)));
    points = Array.from({ length: count }, () => ({
      x: Math.random() * width,
      y: Math.random() * height,
      vx: (Math.random() - 0.5) * 0.5,
      vy: (Math.random() - 0.5) * 0.5,
      r: Math.random() * 1.6 + 1,
      gold: Math.random() < 0.45,
    }));
  };

  const draw = () => {
    ctx.clearRect(0, 0, width, height);
    for (let i = 0; i < points.length; i += 1) {
      const a = points[i];
      for (let j = i + 1; j < points.length; j += 1) {
        const b = points[j];
        const d = Math.hypot(a.x - b.x, a.y - b.y);
        if (d < LINK) {
          ctx.strokeStyle = `rgba(230, 184, 74, ${(1 - d / LINK) * 0.28})`;
          ctx.lineWidth = 0.8;
          ctx.beginPath();
          ctx.moveTo(a.x, a.y);
          ctx.lineTo(b.x, b.y);
          ctx.stroke();
        }
      }
      const m = Math.hypot(a.x - mouse.x, a.y - mouse.y);
      if (m < LINK * 1.3) {
        ctx.strokeStyle = `rgba(255, 255, 255, ${(1 - m / (LINK * 1.3)) * 0.45})`;
        ctx.beginPath();
        ctx.moveTo(a.x, a.y);
        ctx.lineTo(mouse.x, mouse.y);
        ctx.stroke();
      }
    }
    points.forEach((p) => {
      ctx.fillStyle = p.gold ? "rgba(230, 184, 74, 0.85)" : "rgba(255, 255, 255, 0.7)";
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fill();
    });
  };

  const step = () => {
    points.forEach((p) => {
      p.x += p.vx;
      p.y += p.vy;
      if (p.x < 0 || p.x > width) p.vx *= -1;
      if (p.y < 0 || p.y > height) p.vy *= -1;
    });
    draw();
    frame = visible && !document.hidden ? window.requestAnimationFrame(step) : 0;
  };

  const start = () => {
    if (!frame && !reduced) frame = window.requestAnimationFrame(step);
  };

  resize();
  draw();
  window.addEventListener("resize", () => {
    resize();
    draw();
  });
  hero.addEventListener("pointermove", (event) => {
    const box = hero.getBoundingClientRect();
    mouse.x = event.clientX - box.left;
    mouse.y = event.clientY - box.top;
  });
  hero.addEventListener("pointerleave", () => {
    mouse.x = -9999;
    mouse.y = -9999;
  });
  if ("IntersectionObserver" in window) {
    new IntersectionObserver(([entry]) => {
      visible = entry.isIntersecting;
      if (visible) start();
    }).observe(hero);
  }
  document.addEventListener("visibilitychange", () => {
    if (!document.hidden) start();
  });
  start();
}

function initToTop() {
  const button = document.createElement("button");
  button.type = "button";
  button.className = "to-top";
  button.setAttribute("aria-label", "Back to top");
  button.innerHTML = `<svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path d="M6 14l6-6 6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
  button.addEventListener("click", () => {
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    window.scrollTo({ top: 0, behavior: reduce ? "auto" : "smooth" });
  });
  const sync = () => button.classList.toggle("is-on", window.scrollY > 480);
  window.addEventListener("scroll", sync, { passive: true });
  document.body.append(button);
  sync();
}

function initButtonIcons() {
  const icons = {
    "explore our summits": '<circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4c2.2 2.5 3.4 5.2 3.4 8s-1.2 5.5-3.4 8c-2.2-2.5-3.4-5.2-3.4-8s1.2-5.5 3.4-8z"/>',
    "partner with us": '<circle cx="8" cy="8" r="2.4"/><circle cx="16" cy="8" r="2.4"/><path d="M3.8 18c.7-2.3 2.2-3.4 4.2-3.4s3.5 1.1 4.2 3.4M12 18c.6-2 2-3 3.8-3 1.5 0 2.8.7 3.5 2"/>',
    "become a partner": '<circle cx="8" cy="8" r="2.4"/><circle cx="16" cy="8" r="2.4"/><path d="M3.8 18c.7-2.3 2.2-3.4 4.2-3.4s3.5 1.1 4.2 3.4M12 18c.6-2 2-3 3.8-3 1.5 0 2.8.7 3.5 2"/>',
    "request an invite": '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
    "request an invitation": '<path d="M4 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2a2 2 0 0 0 0 4v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2a2 2 0 0 0 0-4z"/><path d="M12 9v6M9 12h6"/>',
  };
  document.querySelectorAll(".btn").forEach((button) => {
    if (button.querySelector(".btn-icon")) return;
    const label = button.textContent.replace(/\s+/g, " ").trim().toLowerCase();
    const path = icons[label];
    if (!path) return;
    button.insertAdjacentHTML(
      "afterbegin",
      `<svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">${path}</svg>`
    );
  });
}

function initTheme() {
  const paint = (theme) => {
    const light = theme === "light";
    if (light) document.documentElement.dataset.theme = "light";
    else delete document.documentElement.dataset.theme;
    localStorage.setItem("hohorizon-theme", light ? "light" : "dark");
    document.querySelectorAll(".theme-toggle").forEach((button) => {
      button.setAttribute("aria-pressed", String(light));
      button.setAttribute("aria-label", light ? "Switch to dark mode" : "Switch to light mode");
    });
  };
  paint(localStorage.getItem("hohorizon-theme") === "light" ? "light" : "dark");
  document.querySelectorAll(".theme-toggle").forEach((button) => {
    button.addEventListener("click", () => {
      paint(document.documentElement.dataset.theme === "light" ? "dark" : "light");
    });
  });
}

function showCookieBanner() {
  if (document.querySelector(".cookie")) return;
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

function cookieStatusText(choice) {
  if (choice === "accept") return "This device is set to accept. Analytics can load when a measurement ID is configured.";
  if (choice === "decline") return "This device is set to decline. Analytics stays off.";
  return "No choice is saved on this device yet.";
}

function initCookie() {
  const status = document.querySelector("[data-cookie-status]");
  const paint = () => {
    if (status) status.textContent = cookieStatusText(localStorage.getItem("hohorizon-cookie"));
  };
  paint();
  document.querySelector(".cookie-manage")?.addEventListener("click", (event) => {
    const choice = event.target.closest("button")?.dataset.cookie;
    if (!choice) return;
    localStorage.setItem("hohorizon-cookie", choice);
    document.querySelector(".cookie")?.remove();
    if (choice === "accept") loadAnalytics();
    paint();
  });
  if (!localStorage.getItem("hohorizon-cookie")) showCookieBanner();
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
initCountries();
initFancySelects();
initForms();
initHero();
initClock();
initSpeakers();
initIntro();
initReveal();
initToTop();
initTheme();
initCookie();
initButtonIcons();
initHeroRule();
if (localStorage.getItem("hohorizon-cookie") === "accept") loadAnalytics();

function initHeroRule() {
  const fit = () => {
    const word = document.querySelector(".hero-here");
    const rule = document.querySelector(".hero .rule");
    const title = document.querySelector(".hero h1");
    if (!word || !rule || !title) return;
    if (window.innerWidth > 700) {
      rule.style.width = "";
      return;
    }
    const range = document.createRange();
    range.selectNodeContents(word);
    const rects = range.getClientRects();
    const rect = rects.length ? rects[rects.length - 1] : range.getBoundingClientRect();
    const width = rect.right - title.getBoundingClientRect().left;
    if (width > 8) rule.style.width = `${Math.round(width)}px`;
  };
  fit();
  window.addEventListener("resize", fit);
  if (document.fonts && document.fonts.ready) document.fonts.ready.then(fit);
}
