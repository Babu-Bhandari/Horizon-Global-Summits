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
    units.days.textContent = String(Math.floor(total / 86400)).padStart(2, "0");
    units.hours.textContent = String(Math.floor((total % 86400) / 3600)).padStart(2, "0");
    units.minutes.textContent = String(Math.floor((total % 3600) / 60)).padStart(2, "0");
    units.seconds.textContent = String(total % 60).padStart(2, "0");
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

initHeader();
initFilters();
initVideo();
initClock();
initSpeakers();
initIntro();
initCounters();
initReveal();
initCookie();
if (localStorage.getItem("hohorizon-cookie") === "accept") loadAnalytics();
