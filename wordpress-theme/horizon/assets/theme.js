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
  const nodes = document.querySelectorAll(".section, .event-card, .conf-grid .conf-card, .topic, .speaker, .card, .stat");
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

const DIAL_CODES = [["Afghanistan","+93","af"],["Albania","+355","al"],["Algeria","+213","dz"],["Andorra","+376","ad"],["Angola","+244","ao"],["Antigua and Barbuda","+1 268","ag"],["Argentina","+54","ar"],["Armenia","+374","am"],["Australia","+61","au"],["Austria","+43","at"],["Azerbaijan","+994","az"],["Bahamas","+1 242","bs"],["Bahrain","+973","bh"],["Bangladesh","+880","bd"],["Barbados","+1 246","bb"],["Belarus","+375","by"],["Belgium","+32","be"],["Belize","+501","bz"],["Benin","+229","bj"],["Bhutan","+975","bt"],["Bolivia","+591","bo"],["Bosnia and Herzegovina","+387","ba"],["Botswana","+267","bw"],["Brazil","+55","br"],["Brunei","+673","bn"],["Bulgaria","+359","bg"],["Burkina Faso","+226","bf"],["Burundi","+257","bi"],["Cabo Verde","+238","cv"],["Cambodia","+855","kh"],["Cameroon","+237","cm"],["Canada","+1","ca"],["Central African Republic","+236","cf"],["Chad","+235","td"],["Chile","+56","cl"],["China","+86","cn"],["Colombia","+57","co"],["Comoros","+269","km"],["Congo","+242","cg"],["Costa Rica","+506","cr"],["Croatia","+385","hr"],["Cuba","+53","cu"],["Cyprus","+357","cy"],["Czechia","+420","cz"],["Denmark","+45","dk"],["Djibouti","+253","dj"],["Dominica","+1 767","dm"],["Dominican Republic","+1 809","do"],["Ecuador","+593","ec"],["Egypt","+20","eg"],["El Salvador","+503","sv"],["Equatorial Guinea","+240","gq"],["Eritrea","+291","er"],["Estonia","+372","ee"],["Eswatini","+268","sz"],["Ethiopia","+251","et"],["Fiji","+679","fj"],["Finland","+358","fi"],["France","+33","fr"],["Gabon","+241","ga"],["Gambia","+220","gm"],["Georgia","+995","ge"],["Germany","+49","de"],["Ghana","+233","gh"],["Greece","+30","gr"],["Grenada","+1 473","gd"],["Guatemala","+502","gt"],["Guinea","+224","gn"],["Guinea-Bissau","+245","gw"],["Guyana","+592","gy"],["Haiti","+509","ht"],["Honduras","+504","hn"],["Hungary","+36","hu"],["Iceland","+354","is"],["India","+91","in"],["Indonesia","+62","id"],["Iran","+98","ir"],["Iraq","+964","iq"],["Ireland","+353","ie"],["Israel","+972","il"],["Italy","+39","it"],["Jamaica","+1 876","jm"],["Japan","+81","jp"],["Jordan","+962","jo"],["Kazakhstan","+7","kz"],["Kenya","+254","ke"],["Kiribati","+686","ki"],["Kuwait","+965","kw"],["Kyrgyzstan","+996","kg"],["Laos","+856","la"],["Latvia","+371","lv"],["Lebanon","+961","lb"],["Lesotho","+266","ls"],["Liberia","+231","lr"],["Libya","+218","ly"],["Liechtenstein","+423","li"],["Lithuania","+370","lt"],["Luxembourg","+352","lu"],["Madagascar","+261","mg"],["Malawi","+265","mw"],["Malaysia","+60","my"],["Maldives","+960","mv"],["Mali","+223","ml"],["Malta","+356","mt"],["Marshall Islands","+692","mh"],["Mauritania","+222","mr"],["Mauritius","+230","mu"],["Mexico","+52","mx"],["Micronesia","+691","fm"],["Moldova","+373","md"],["Monaco","+377","mc"],["Mongolia","+976","mn"],["Montenegro","+382","me"],["Morocco","+212","ma"],["Mozambique","+258","mz"],["Myanmar","+95","mm"],["Namibia","+264","na"],["Nauru","+674","nr"],["Nepal","+977","np"],["Netherlands","+31","nl"],["New Zealand","+64","nz"],["Nicaragua","+505","ni"],["Niger","+227","ne"],["Nigeria","+234","ng"],["North Korea","+850","kp"],["North Macedonia","+389","mk"],["Norway","+47","no"],["Oman","+968","om"],["Pakistan","+92","pk"],["Palau","+680","pw"],["Palestine","+970","ps"],["Panama","+507","pa"],["Papua New Guinea","+675","pg"],["Paraguay","+595","py"],["Peru","+51","pe"],["Philippines","+63","ph"],["Poland","+48","pl"],["Portugal","+351","pt"],["Qatar","+974","qa"],["Romania","+40","ro"],["Russia","+7","ru"],["Rwanda","+250","rw"],["Saint Kitts and Nevis","+1 869","kn"],["Saint Lucia","+1 758","lc"],["Saint Vincent and the Grenadines","+1 784","vc"],["Samoa","+685","ws"],["San Marino","+378","sm"],["Sao Tome and Principe","+239","st"],["Saudi Arabia","+966","sa"],["Senegal","+221","sn"],["Serbia","+381","rs"],["Seychelles","+248","sc"],["Sierra Leone","+232","sl"],["Singapore","+65","sg"],["Slovakia","+421","sk"],["Slovenia","+386","si"],["Solomon Islands","+677","sb"],["Somalia","+252","so"],["South Africa","+27","za"],["South Korea","+82","kr"],["South Sudan","+211","ss"],["Spain","+34","es"],["Sri Lanka","+94","lk"],["Sudan","+249","sd"],["Suriname","+597","sr"],["Sweden","+46","se"],["Switzerland","+41","ch"],["Syria","+963","sy"],["Tajikistan","+992","tj"],["Tanzania","+255","tz"],["Thailand","+66","th"],["Timor-Leste","+670","tl"],["Togo","+228","tg"],["Tonga","+676","to"],["Trinidad and Tobago","+1 868","tt"],["Tunisia","+216","tn"],["Turkey","+90","tr"],["Turkmenistan","+993","tm"],["Tuvalu","+688","tv"],["Uganda","+256","ug"],["Ukraine","+380","ua"],["United Arab Emirates","+971","ae"],["United Kingdom","+44","gb"],["United States","+1","us"],["Uruguay","+598","uy"],["Uzbekistan","+998","uz"],["Vanuatu","+678","vu"],["Vatican City","+39","va"],["Venezuela","+58","ve"],["Vietnam","+84","vn"],["Yemen","+967","ye"],["Zambia","+260","zm"],["Zimbabwe","+263","zw"]];
const flagImg = (code) => `<img class="flag" src="https://flagcdn.com/w40/${code}.png" alt="" width="20" height="15" loading="lazy" decoding="async">`;

function initPhoneFields() {
  document.querySelectorAll('.contact-form input[name="phone"]').forEach((input) => {
    if (input.closest(".phone-field")) return;
    const select = document.createElement("select");
    select.name = "phone_code";
    select.className = "phone-code";
    select.required = true;
    select.setAttribute("aria-label", "Country code");
    DIAL_CODES.forEach(([name, code, flag]) => {
      const option = document.createElement("option");
      option.value = name;
      option.textContent = `${name} (${code})`;
      option.dataset.short = code;
      option.dataset.flag = flag;
      if (name === "United Arab Emirates") option.defaultSelected = true;
      select.append(option);
    });
    const field = document.createElement("div");
    field.className = "phone-field";
    input.before(field);
    field.append(select, input);
    input.type = "tel";
    input.inputMode = "numeric";
    input.autocomplete = "tel-national";
    input.maxLength = 10;
    input.pattern = "[0-9]{10}";
    input.placeholder = "10 digits";
    input.title = "Enter exactly 10 digits";
    input.addEventListener("input", () => {
      const digits = input.value.replace(/\D/g, "").slice(0, 10);
      if (digits !== input.value) input.value = digits;
      input.setCustomValidity("");
    });
    input.addEventListener("invalid", () => {
      input.setCustomValidity("Enter a 10-digit number, digits only.");
    });
  });
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
      button.innerHTML = `<span class="${empty ? "is-placeholder" : ""}"></span><i aria-hidden="true"></i>`;
      const label = button.querySelector("span");
      label.textContent = current ? current.dataset.short || current.textContent : "Select";
      if (current?.dataset.flag) label.insertAdjacentHTML("afterbegin", flagImg(current.dataset.flag));
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
        if (option.dataset.flag) item.querySelector("span").insertAdjacentHTML("afterbegin", flagImg(option.dataset.flag));
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
    select.form?.addEventListener("reset", () => setTimeout(paint));
  });
}

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

function initConferenceScroll() {
  const track = document.querySelector(".conf-track");
  if (!track) return;
  const prev = document.querySelector("[data-conf-prev]");
  const next = document.querySelector("[data-conf-next]");
  const step = () => {
    const card = track.querySelector(".conf-card");
    const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
    return card ? card.getBoundingClientRect().width + gap : track.clientWidth * 0.8;
  };
  const nav = document.querySelector(".conf-nav");
  const dots = document.querySelector("[data-conf-dots]");
  const maxScroll = () => track.scrollWidth - track.clientWidth;
  // One dot per scroll stop
  const stops = () => (maxScroll() <= 2 ? 1 : Math.ceil((maxScroll() - 2) / step()) + 1);
  const current = () => (track.scrollLeft >= maxScroll() - 2 ? stops() - 1 : Math.round(track.scrollLeft / step()));
  const buildDots = () => {
    if (!dots) return;
    const count = stops();
    if (dots.children.length === count) return;
    dots.innerHTML = "";
    for (let i = 0; i < count; i += 1) {
      const dot = document.createElement("button");
      dot.type = "button";
      dot.className = "conf-dot";
      dot.setAttribute("aria-label", `Go to slide ${i + 1}`);
      dot.addEventListener("click", () => track.scrollTo({ left: Math.min(i * step(), maxScroll()), behavior: "smooth" }));
      dots.append(dot);
    }
  };
  const update = () => {
    const max = maxScroll() - 2;
    // Only show the controls when some tiles don't fit on screen
    if (nav) nav.hidden = max <= 0;
    if (prev) prev.disabled = track.scrollLeft <= 2;
    if (next) next.disabled = track.scrollLeft >= max;
    buildDots();
    const active = current();
    dots?.querySelectorAll(".conf-dot").forEach((dot, i) => {
      dot.classList.toggle("is-active", i === active);
      if (i === active) dot.setAttribute("aria-current", "true");
      else dot.removeAttribute("aria-current");
    });
  };
  prev?.addEventListener("click", () => track.scrollBy({ left: -step(), behavior: "smooth" }));
  next?.addEventListener("click", () => track.scrollBy({ left: step(), behavior: "smooth" }));
  track.addEventListener("scroll", update, { passive: true });
  window.addEventListener("resize", update);
  update();
}

const LINKEDIN_URL = document.body.dataset.linkedin || "https://www.linkedin.com/company/horizon-global-summits/";
const LI_PATH = '<path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/>';

function showSentPopup() {
  if (document.querySelector(".ok-pop")) return;
  const pop = document.createElement("div");
  pop.className = "ok-pop";
  pop.innerHTML = `
    <div class="ok-pop-card" role="dialog" aria-modal="true" aria-labelledby="ok-pop-title">
      <button class="ok-pop-close" type="button" aria-label="Close" data-ok="close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
      <span class="ok-pop-badge" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
      </span>
      <h2 id="ok-pop-title">Thank You!</h2>
      <p class="ok-pop-text">We'll Connect With You Shortly.</p>
      <button class="btn ok-pop-btn" type="button" data-ok="close">Close</button>
    </div>`;
  const close = () => {
    pop.classList.remove("is-open");
    document.removeEventListener("keydown", onKey);
    setTimeout(() => pop.remove(), 300);
  };
  const onKey = (event) => {
    if (event.key === "Escape") close();
  };
  pop.addEventListener("click", (event) => {
    if (event.target === pop || event.target.closest('[data-ok="close"]')) close();
  });
  document.addEventListener("keydown", onKey);
  document.body.append(pop);
  requestAnimationFrame(() => pop.classList.add("is-open"));
  pop.querySelector(".ok-pop-btn").focus({ preventScroll: true });
}

function initSentPopup() {
  const params = new URLSearchParams(window.location.search);
  if (params.get("sent") !== "1") return;
  showSentPopup();
  params.delete("sent");
  params.delete("form");
  const query = params.toString();
  history.replaceState(null, "", window.location.pathname + (query ? `?${query}` : "") + window.location.hash);
}

// The LinkedIn popup shows up to this many times per visit, this many seconds after it was last closed.
// It stops for good once a visitor clicks Follow.
const LI_POPUP_MAX_PER_VISIT = 3;
const LI_POPUP_REPEAT_SECONDS = 45;
let liPopupTimer = 0;

function liPopupCount() {
  try {
    return Number(sessionStorage.getItem("hohorizon-li-count")) || 0;
  } catch (e) {
    return LI_POPUP_MAX_PER_VISIT;
  }
}

function scheduleLinkedInPopup(delay) {
  clearTimeout(liPopupTimer);
  try {
    if (localStorage.getItem("hohorizon-li-followed")) return;
  } catch (e) {
    return;
  }
  if (liPopupCount() >= LI_POPUP_MAX_PER_VISIT) return;
  liPopupTimer = setTimeout(showLinkedInPopup, delay);
}

function initLinkedInPopup() {
  // Add ?linkedin-popup to any page address to see the popup straight away, for testing.
  if (new URLSearchParams(window.location.search).has("linkedin-popup")) {
    setTimeout(showLinkedInPopup, 800);
    return;
  }
  // First time this visit: shortly after load. After that: the normal gap, also across page changes.
  scheduleLinkedInPopup(liPopupCount() === 0 ? 2500 : LI_POPUP_REPEAT_SECONDS * 1000);
}

function showLinkedInPopup() {
  if (document.querySelector(".li-pop, .ok-pop")) {
    scheduleLinkedInPopup(LI_POPUP_REPEAT_SECONDS * 1000);
    return;
  }
  try {
    sessionStorage.setItem("hohorizon-li-count", String(liPopupCount() + 1));
  } catch (e) {}
  const pop = document.createElement("div");
  pop.className = "li-pop";
  pop.innerHTML = `
    <div class="li-pop-card" role="dialog" aria-modal="true" aria-labelledby="li-pop-title">
      <div class="li-pop-hero" aria-hidden="true">
        <span class="li-pop-orb li-pop-orb-a"></span>
        <span class="li-pop-orb li-pop-orb-b"></span>
        <span class="li-pop-ring"></span>
        <span class="li-pop-badge"><svg viewBox="0 0 24 24" fill="currentColor">${LI_PATH}</svg></span>
      </div>
      <button class="li-pop-close" type="button" aria-label="Close" data-li="close">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
      </button>
      <div class="li-pop-body">
        <p class="li-pop-eyebrow">Stay connected</p>
        <h2 id="li-pop-title">Join our community<br />on <span>LinkedIn</span></h2>
        <p class="li-pop-text">Be the first to hear what's next from Horizon Global Summits.</p>
        <ul class="li-pop-perks">
          ${["Summit announcements and dates", "Speaker reveals and agenda updates", "Executive insights and highlights"]
            .map((perk) => `<li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>${perk}</li>`)
            .join("")}
        </ul>
        <a class="li-pop-follow" href="${LINKEDIN_URL}" target="_blank" rel="noopener" data-li="follow">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">${LI_PATH}</svg>
          Follow on LinkedIn
          <svg class="li-pop-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
        <button class="li-pop-later" type="button" data-li="close">Maybe later</button>
      </div>
    </div>
  `;
  const close = () => {
    pop.classList.remove("is-open");
    document.removeEventListener("keydown", onKey);
    setTimeout(() => pop.remove(), 300);
    scheduleLinkedInPopup(LI_POPUP_REPEAT_SECONDS * 1000);
  };
  const onKey = (event) => {
    if (event.key === "Escape") close();
  };
  pop.addEventListener("click", (event) => {
    const action = event.target.closest("[data-li]")?.dataset.li;
    if (action === "follow") {
      localStorage.setItem("hohorizon-li-followed", "1");
      close();
    } else if (action === "close" || event.target === pop) {
      close();
    }
  });
  document.addEventListener("keydown", onKey);
  document.body.append(pop);
  requestAnimationFrame(() => pop.classList.add("is-open"));
  pop.querySelector("[data-li='follow']").focus({ preventScroll: true });
}

initHeader();
initPhoneFields();
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
initConferenceScroll();
initHeroVideo();
initSentPopup();
initWpForms();
initLinkedInPopup();
initHeroRule();

// Hero background video: start on load. If the browser blocks autoplay
// (for example iPhone Low Power Mode), start it on the first touch or scroll.
function initHeroVideo() {
  const video = document.querySelector(".hero-bg-video");
  if (!video) return;
  video.muted = true;
  video.defaultMuted = true;
  video.playsInline = true;
  video.controls = false;
  const play = () => {
    const attempt = video.play();
    if (attempt && attempt.catch) attempt.catch(() => {});
  };
  const events = ["touchstart", "pointerdown", "scroll", "keydown"];
  const onGesture = () => {
    play();
    if (!video.paused) events.forEach((e) => window.removeEventListener(e, onGesture));
  };
  events.forEach((e) => window.addEventListener(e, onGesture, { passive: true }));
  video.addEventListener("playing", () => events.forEach((e) => window.removeEventListener(e, onGesture)), { once: true });
  if (video.readyState >= 2) play();
  else video.addEventListener("loadeddata", play, { once: true });
  play();
  document.addEventListener("visibilitychange", () => { if (!document.hidden && video.paused) play(); });
}

// Send WordPress forms in the background, so the page stays where it is
// and the thank-you popup appears. Without JavaScript the form still posts normally.
function initWpForms() {
  document.querySelectorAll("form.site-form[data-hz-form]").forEach((form) => {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      const button = form.querySelector('[type="submit"]');
      let error = form.querySelector(".form-error");
      if (!error) {
        error = document.createElement("p");
        error.className = "form-error";
        error.setAttribute("role", "alert");
        (button || form.lastElementChild).before(error);
      }
      error.hidden = true;
      if (button) button.disabled = true;
      const data = new FormData(form);
      data.set("ajax", "1");
      try {
        // Post back to this same page; the theme catches it on init (see inc/forms.php).
        const response = await fetch(window.location.pathname + window.location.search, {
          method: "POST",
          body: data,
          credentials: "same-origin",
          headers: { Accept: "application/json" },
        });
        const result = await response.json().catch(() => ({ reason: `http-${response.status}` }));
        if (!response.ok || result.success !== true) throw Object.assign(new Error("send failed"), { result });
        form.reset();
        showSentPopup();
      } catch (err) {
        const result = err.result || { reason: "network" };
        console.warn("Form not sent:", result);
        error.textContent = wpFormErrorText(form, result);
        error.hidden = false;
      } finally {
        if (button) button.disabled = false;
      }
    });
  });
}

// Turn the server's reason code into a message the visitor can act on.
function wpFormErrorText(form, result) {
  const inbox = (document.body.dataset.email || "").trim();
  const emailUs = inbox ? `email ${inbox} directly` : "email us directly";
  const reason = result.reason || "";
  if (reason === "expired") {
    return "This page has been open too long. Refresh the page and send the message again.";
  }
  if (reason === "field") {
    const input = result.field && form.elements[result.field];
    const label = input && input.closest && input.closest("label");
    const name = label ? label.firstChild.textContent.trim() : result.field === "phone_code" ? "Country code" : "a field";
    if (input && input.focus) input.focus();
    return `Please check ${name} and try again.`;
  }
  if (reason === "mail") {
    const detail = result.detail ? ` (Admin note: ${result.detail})` : "";
    return `The site could not email your message. Please try again later, or ${emailUs}.${detail}`;
  }
  if (reason === "network") {
    return `The message could not be sent. Check your connection and try again, or ${emailUs}.`;
  }
  return `The message could not be sent (${reason || "unknown error"}). Please try again, or ${emailUs}.`;
}

// About us: open the CPD certificate full size in a lightbox.
(function initCertLightbox() {
  const triggers = document.querySelectorAll("[data-cert-open]");
  if (!triggers.length) return;
  let modal;
  const build = () => {
    modal = document.createElement("dialog");
    modal.className = "cert-modal";
    modal.setAttribute("aria-label", "CPD Approved Provider certificate");
    modal.innerHTML = '<button type="button" class="cert-modal-close" aria-label="Close">&times;</button><img alt="" />';
    document.body.appendChild(modal);
    modal.querySelector(".cert-modal-close").addEventListener("click", () => modal.close());
    modal.addEventListener("click", (e) => { if (e.target === modal) modal.close(); });
  };
  triggers.forEach((btn) => {
    btn.addEventListener("click", () => {
      const src = btn.getAttribute("data-cert-open");
      if (typeof HTMLDialogElement !== "function") { window.open(src, "_blank", "noopener"); return; }
      if (!modal) build();
      const img = modal.querySelector("img");
      img.src = src;
      img.alt = (btn.querySelector("img") || {}).alt || "CPD certificate";
      modal.showModal();
    });
  });
})();
