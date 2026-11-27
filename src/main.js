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
          <li><a href="/#about">${icon("about")}About</a></li>
          <li><a href="/#next-meet">${icon("conference")}Conference</a></li>
          <li><a href="/speakers.html">${icon("speakers")}Speakers</a></li>
          <li><a href="/#contact">${icon("contact")}Contact Us</a></li>
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

const CONFERENCES = [
  {
    name: "GCC Tax Leadership Summit & Awards 2027",
    location: "Dubai, United Arab Emirates",
    month: "March 2027",
    region: "GCC",
    image: "https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1000&q=80",
    alt: "Dubai skyline at sunset",
  },
  {
    name: "European Tax Leadership Summit & Awards 2027 - Viva La ViDA",
    location: "Madrid, Spain",
    month: "May 2027",
    region: "Europe",
    image: "https://images.unsplash.com/photo-1539037116277-4db20889f2d4?auto=format&fit=crop&w=1000&q=80",
    alt: "Madrid's Gran Vía at dusk",
  },
  {
    name: "APAC CFO Assembly & Awards 2027",
    location: "India",
    month: "July 2027",
    region: "APAC",
    image: "https://images.unsplash.com/photo-1587474260584-136574528ed5?auto=format&fit=crop&w=1000&q=80",
    alt: "India Gate in New Delhi at dawn",
  },
  {
    name: "2nd APAC CFO Assembly & Awards 2027",
    location: "India",
    month: "September 2027",
    region: "APAC",
    image: "https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=1000&q=80",
    alt: "The Taj Mahal reflected in its pool",
  },
  {
    name: "GCC CFO Assembly & Awards 2027",
    location: "United Arab Emirates",
    month: "November 2027",
    region: "GCC",
    image: "https://images.unsplash.com/photo-1518684079-3c830dcef090?auto=format&fit=crop&w=1000&q=80",
    alt: "Aerial view of the Dubai coastline",
  },
];

function initConferences() {
  const pin = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>';
  const cal = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>';
  document.querySelectorAll("[data-conferences]").forEach((grid) => {
    grid.innerHTML = CONFERENCES.map((c) => {
      const [monthName, year] = c.month.split(" ");
      return `
      <article class="conf-card">
        <div class="conf-media">
          <img src="${c.image}" alt="${c.alt}" loading="lazy" />
          <span class="conf-date"><strong>${monthName.slice(0, 3)}</strong>${year}</span>
          <span class="conf-region">${c.region}</span>
        </div>
        <div class="conf-body">
          <h3>${c.name}</h3>
          <ul class="conf-meta">
            <li>${pin}${c.location}</li>
            <li>${cal}${c.month}</li>
          </ul>
          <a class="conf-link" href="/#contact">Request invitation<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </article>`;
    }).join("");
  });
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

function initEvents() {
  const panels = [...document.querySelectorAll("[data-event]")];
  if (!panels.length) return;
  const selected = new URLSearchParams(location.search).get("event") || "flagship";
  const known = panels.some((panel) => panel.dataset.event === selected);
  const active = known ? selected : "flagship";
  panels.forEach((panel) => panel.classList.toggle("is-on", panel.dataset.event === active));
}

const COUNTRIES = ["Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cabo Verde","Cambodia","Cameroon","Canada","Central African Republic","Chad","Chile","China","Colombia","Comoros","Congo","Costa Rica","Croatia","Cuba","Cyprus","Czechia","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Eswatini","Ethiopia","Fiji","Finland","France","Gabon","Gambia","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","North Korea","North Macedonia","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","Sudan","Suriname","Sweden","Switzerland","Syria","Tajikistan","Tanzania","Thailand","Timor-Leste","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe"];

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

const INBOX = "connect@horizonglobalsummits.com";

const FIELD_LABELS = {
  name: "Name",
  organisation: "Company / Organisation",
  email: "Email",
  phone: "Contact number",
  enquiry: "I want to",
  role: "Job title",
  country: "Country",
  message: "Message",
  gathering: "Gathering",
  industry: "Industry",
  interest: "Interest",
};

function initForms() {
  document.querySelectorAll(".site-form").forEach((form) => {
    form.addEventListener("submit", async (event) => {
      event.preventDefault();
      const error = form.querySelector(".form-error");
      const button = form.querySelector('[type="submit"]');
      if (error) error.hidden = true;
      if (form.elements.hz_trap?.value) {
        if (error) {
          error.hidden = false;
          error.textContent = "The message could not be sent.";
        }
        return;
      }
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      const data = new FormData(form);
      const kind = form.dataset.kind || "contact";
      const payload = {
        _subject: `Horizon Global Summits ${kind}`,
        _template: "table",
        _captcha: "false",
      };
      for (const [key, value] of data.entries()) {
        if (key === "hz_trap" || key === "phone_code" || String(value).trim() === "") continue;
        const label = FIELD_LABELS[key] || key;
        const code = key === "phone" ? form.elements.phone_code?.selectedOptions[0]?.dataset.short : "";
        payload[label] = code ? `${code} ${value}` : value;
        if (key === "email") payload._replyto = value;
      }
      if (button) button.disabled = true;
      try {
        const response = await fetch(`https://formsubmit.co/ajax/${INBOX}`, {
          method: "POST",
          headers: { "Content-Type": "application/json", Accept: "application/json" },
          body: JSON.stringify(payload),
        });
        const result = await response.json().catch(() => ({}));
        if (!response.ok || (result.success !== true && result.success !== "true")) {
          const detail = String(result.message || "");
          if (/activat/i.test(detail)) {
            throw new Error(`A confirmation email was sent to ${INBOX}. Open it, activate the form, then send this message again.`);
          }
          throw new Error("send failed");
        }
        form.reset();
        if (button) button.disabled = false;
        showSentPopup();
      } catch (err) {
        if (error) {
          error.hidden = false;
          error.textContent = /activat/i.test(err?.message || "")
            ? err.message
            : `The message could not be sent. Please email ${INBOX} directly.`;
        }
        if (button) button.disabled = false;
      }
    });
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

const LINKEDIN_URL = "https://www.linkedin.com/company/horizon-global-summits/";
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
      <p class="ok-pop-eyebrow">Message sent</p>
      <h2 id="ok-pop-title">We'll Connect With You Shortly</h2>
      <p class="ok-pop-text">Thank you for reaching out to Horizon Global Summits. Our team will get back to you soon.</p>
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

renderChrome();
initHeader();
initFilters();
initConferences();
initConferenceScroll();
initHeroVideo();
initEvents();
initCountries();
initPhoneFields();
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
initLinkedInPopup();
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
