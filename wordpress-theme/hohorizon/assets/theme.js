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
    units.days.textContent = String(Math.floor(total / 86400)).padStart(2, "0");
    units.hours.textContent = String(Math.floor((total % 86400) / 3600)).padStart(2, "0");
    units.minutes.textContent = String(Math.floor((total % 3600) / 60)).padStart(2, "0");
    units.seconds.textContent = String(total % 60).padStart(2, "0");
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

initHeader();
initFancySelects();
initFilters();
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
