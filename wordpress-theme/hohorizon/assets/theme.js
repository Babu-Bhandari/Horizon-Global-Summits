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
  if (!video || window.matchMedia("(max-width: 700px)").matches) return;
  video.addEventListener("loadeddata", () => {
    video.hidden = false;
  });
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
    units.days.textContent = String(Math.floor(total / 86400)).padStart(2, "0");
    units.hours.textContent = String(Math.floor((total % 86400) / 3600)).padStart(2, "0");
    units.minutes.textContent = String(Math.floor((total % 3600) / 60)).padStart(2, "0");
    units.seconds.textContent = String(total % 60).padStart(2, "0");
  };
  paint();
  window.setInterval(paint, 1000);
}

function initIntro() {
  const intro = document.querySelector("#intro");
  const count = document.querySelector("#intro-pct");
  const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  if (!intro) {
    document.body.classList.add("is-ready");
    return;
  }
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

initHeader();
initFilters();
initVideo();
initClock();
initIntro();
initReveal();
initCookie();
if (localStorage.getItem("hohorizon-cookie") === "accept") loadAnalytics();
