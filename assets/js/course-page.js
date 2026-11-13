/**
 * Course page interactions
 * - sticky section nav + scroll-spy
 * - read more / pathway tabs / English score selector
 * - unit search, filter and expand
 * - FAQ accordion
 * - scroll reveal + mobile enquiry bar
 */
(function () {
  "use strict";

  var $ = function (s, c) {
    return (c || document).querySelector(s);
  };
  var $$ = function (s, c) {
    return Array.prototype.slice.call((c || document).querySelectorAll(s));
  };
  var reduceMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;

  /* ---------- Read more (overview) ---------- */
  var prose = $("#ccProse");
  var proseBtn = $("#ccProseToggle");
  if (prose && proseBtn) {
    proseBtn.addEventListener("click", function () {
      var open = prose.classList.toggle("is-clamped") === false;
      proseBtn.setAttribute("aria-expanded", String(open));
      $("span", proseBtn).textContent = open ? "Show less" : "Read more";
    });
  }

  /* ---------- Tabs (pathways) ---------- */
  $$("[data-tabs]").forEach(function (root) {
    var tabs = $$('[role="tab"]', root);
    var panels = $$('[role="tabpanel"]', root);

    function activate(tab, focus) {
      tabs.forEach(function (t) {
        var on = t === tab;
        t.classList.toggle("is-active", on);
        t.setAttribute("aria-selected", String(on));
        t.tabIndex = on ? 0 : -1;
      });
      panels.forEach(function (p) {
        var on = p.id === tab.getAttribute("aria-controls");
        p.hidden = !on;
        p.classList.toggle("is-active", on);
      });
      if (focus) tab.focus();
    }

    tabs.forEach(function (tab, i) {
      tab.addEventListener("click", function () {
        activate(tab);
      });
      tab.addEventListener("keydown", function (e) {
        var n = null;
        if (e.key === "ArrowRight") n = tabs[(i + 1) % tabs.length];
        if (e.key === "ArrowLeft")
          n = tabs[(i - 1 + tabs.length) % tabs.length];
        if (n) {
          e.preventDefault();
          activate(n, true);
        }
      });
    });
  });

  /* ---------- English score selector ---------- */
  var eng = $("#ccEnglish");
  if (eng) {
    var val = $("#ccScoreVal");
    var note = $("#ccScoreNote");
    $$("button", eng).forEach(function (btn) {
      btn.addEventListener("click", function () {
        $$("button", eng).forEach(function (b) {
          var on = b === btn;
          b.classList.toggle("is-active", on);
          b.setAttribute("aria-pressed", String(on));
        });
        val.textContent = btn.dataset.score;
        note.textContent = btn.dataset.note;
      });
    });
  }

  /* ---------- Units: search + filter + expand ---------- */
  var unitsRoot = $("#ccUnits");
  if (unitsRoot) {
    var rows = $$(".cc-unit", unitsRoot);
    var search = $("#ccUnitSearch");
    var filterBtns = $$("[data-filter]", unitsRoot);
    var toggle = $("#unitsToggle");
    var count = $("#ccUnitCount");
    var empty = $("#ccUnitEmpty");
    var limit = parseInt(unitsRoot.dataset.visible, 10) || 8;
    var state = { type: "all", q: "", expanded: false };

    // remember original titles so we can highlight matches safely (text nodes only)
    rows.forEach(function (r) {
      var t = $(".cc-unit-title", r);
      t.dataset.orig = t.textContent;
    });

    function highlight(el, q) {
      var text = el.dataset.orig;
      el.textContent = "";
      if (!q) {
        el.textContent = text;
        return;
      }
      var i = text.toLowerCase().indexOf(q);
      if (i === -1) {
        el.textContent = text;
        return;
      }
      el.appendChild(document.createTextNode(text.slice(0, i)));
      var m = document.createElement("mark");
      m.textContent = text.slice(i, i + q.length);
      el.appendChild(m);
      el.appendChild(document.createTextNode(text.slice(i + q.length)));
    }

    function render() {
      var q = state.q.trim().toLowerCase();
      var filtering = state.type !== "all" || q !== "";
      var matches = rows.filter(function (r) {
        return (
          (state.type === "all" || r.dataset.type === state.type) &&
          (q === "" || r.dataset.search.indexOf(q) !== -1)
        );
      });
      var showAll = filtering || state.expanded;

      rows.forEach(function (r) {
        var idx = matches.indexOf(r);
        var show = idx !== -1 && (showAll || idx < limit);
        r.hidden = !show;
        if (show) highlight($(".cc-unit-title", r), q);
      });

      empty.hidden = matches.length !== 0;

      var shown = showAll ? matches.length : Math.min(limit, matches.length);
      count.textContent = "Showing " + shown + " of " + rows.length + " units";

      if (toggle) {
        // The toggle only matters for the unfiltered list
        toggle.hidden = filtering || rows.length <= limit;
        toggle.setAttribute("aria-expanded", String(state.expanded));
        toggle.textContent = state.expanded
          ? "Show fewer units"
          : "See all " + rows.length + " units";
      }
    }

    filterBtns.forEach(function (b) {
      b.addEventListener("click", function () {
        state.type = b.dataset.filter;
        filterBtns.forEach(function (x) {
          var on = x === b;
          x.classList.toggle("is-active", on);
          x.setAttribute("aria-pressed", String(on));
        });
        render();
      });
    });

    if (search)
      search.addEventListener("input", function () {
        state.q = search.value;
        render();
      });

    if (toggle) {
      toggle.addEventListener("click", function () {
        state.expanded = !state.expanded;
        render();
        if (!state.expanded) {
          var top =
            unitsRoot.getBoundingClientRect().top + window.pageYOffset - 140;
          window.scrollTo({
            top: top,
            behavior: reduceMotion ? "auto" : "smooth",
          });
        }
      });
    }

    render();
  }

  /* ---------- FAQ accordion ---------- */
  var faqItems = $$(".cc-faq-item");
  function setFaq(item, open) {
    var q = $(".cc-faq-q", item);
    var a = $(".cc-faq-a", item);
    item.classList.toggle("active", open);
    q.setAttribute("aria-expanded", String(open));
    a.style.maxHeight = open ? a.scrollHeight + "px" : "0px";
  }
  faqItems.forEach(function (item) {
    $(".cc-faq-q", item).addEventListener("click", function () {
      var open = !item.classList.contains("active");
      faqItems.forEach(function (o) {
        if (o !== item) setFaq(o, false);
      });
      setFaq(item, open);
    });
  });
  window.addEventListener("resize", function () {
    faqItems.forEach(function (i) {
      if (i.classList.contains("active"))
        $(".cc-faq-a", i).style.maxHeight =
          $(".cc-faq-a", i).scrollHeight + "px";
    });
  });

  /* ---------- Scroll-spy for sticky nav ---------- */
  var navList = $("#ccSubnavList");
  var navLinks = navList ? $$("a", navList) : [];
  var spyBlocks = $$("[data-spy]");

  function setActive(id) {
    navLinks.forEach(function (a) {
      var on = a.getAttribute("href") === "#" + id;
      a.classList.toggle("is-active", on);
      if (on) a.setAttribute("aria-current", "true");
      else a.removeAttribute("aria-current");
      if (on && navList.scrollWidth > navList.clientWidth) {
        // keep active pill visible on small screens (scroll only the nav, not the page)
        var target = a.offsetLeft - (navList.clientWidth - a.offsetWidth) / 2;
        navList.scrollTo({
          left: target,
          behavior: reduceMotion ? "auto" : "smooth",
        });
      }
    });
  }

  function spy() {
    var line = window.innerHeight * 0.3;
    var current = spyBlocks[0];
    spyBlocks.forEach(function (b) {
      if (b.getBoundingClientRect().top <= line) current = b;
    });
    if (current) setActive(current.id);
  }

  /* ---------- Reveal + mobile bar ---------- */
  var bar = $("#ccMobileBar");
  var hero = $(".course-hero");
  var cta = $("#enquire");

  function barState() {
    if (!bar || !hero) return;
    var pastHero = hero.getBoundingClientRect().bottom < 0;
    var ctaVisible =
      cta && cta.getBoundingClientRect().top < window.innerHeight * 0.9;
    bar.classList.toggle("is-shown", pastHero && !ctaVisible);
  }

  if ("IntersectionObserver" in window && !reduceMotion) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) {
            e.target.classList.add("is-visible");
            io.unobserve(e.target);
          }
        });
      },
      { rootMargin: "0px 0px -8% 0px", threshold: 0.05 },
    );
    $$(".cc-block").forEach(function (b) {
      io.observe(b);
    });
  } else {
    $$(".cc-block").forEach(function (b) {
      b.classList.add("is-visible");
    });
  }

  var ticking = false;
  function onScroll() {
    if (ticking) return;
    ticking = true;
    window.requestAnimationFrame(function () {
      spy();
      barState();
      ticking = false;
    });
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  window.addEventListener("resize", onScroll);
  spy();
  barState();
})();
