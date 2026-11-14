/**
 * Reviews carousel – scroll-snap based, supports multiple instances.
 * Arrows + dots + keyboard + "Read more" for long reviews.
 */
(function () {
  "use strict";

  function init(root) {
    var track = root.querySelector(".rv-track");
    var cards = Array.prototype.slice.call(root.querySelectorAll(".rv-card"));
    var dotsWrap = root.querySelector(".rv-dots");
    var prev = root.querySelector('.rv-arrow[data-dir="-1"]');
    var next = root.querySelector('.rv-arrow[data-dir="1"]');
    var carousel = root.querySelector(".rv-carousel");
    if (!track || !cards.length) return;

    /* ----- Read more (only where text is actually clamped) ----- */
    function checkClamp() {
      cards.forEach(function (card) {
        var p = card.querySelector(".rv-text p");
        var btn = card.querySelector(".rv-more");
        if (!p || !btn) return;
        if (card.classList.contains("is-open")) {
          btn.hidden = false;
          return;
        }
        btn.hidden = !(p.scrollHeight > p.clientHeight + 1);
      });
    }
    cards.forEach(function (card) {
      var btn = card.querySelector(".rv-more");
      if (!btn) return;
      btn.addEventListener("click", function () {
        var open = card.classList.toggle("is-open");
        btn.setAttribute("aria-expanded", String(open));
        btn.textContent = open ? "Show less" : "Read more";
      });
    });

    /* ----- Avatars: drop broken images, initial shows instead ----- */
    cards.forEach(function (card) {
      var img = card.querySelector(".rv-avatar img");
      if (img)
        img.addEventListener("error", function () {
          img.remove();
        });
    });

    /* ----- Dots ----- */
    var dots = cards.map(function (_, i) {
      var b = document.createElement("button");
      b.type = "button";
      b.className = "rv-dot";
      b.setAttribute("aria-label", "Go to review " + (i + 1));
      b.addEventListener("click", function () {
        goTo(i);
      });
      dotsWrap.appendChild(b);
      return b;
    });

    function step() {
      var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
      return cards[0].getBoundingClientRect().width + gap;
    }

    function goTo(i) {
      track.scrollTo({ left: i * step(), behavior: "smooth" });
    }

    function update() {
      var max = track.scrollWidth - track.clientWidth;
      var atStart = track.scrollLeft <= 2;
      var atEnd = track.scrollLeft >= max - 2;
      var idx =
        atEnd && max > 0
          ? cards.length - 1
          : Math.round(track.scrollLeft / step());

      dots.forEach(function (d, i) {
        var on = i === idx;
        d.classList.toggle("is-active", on);
        if (on) d.setAttribute("aria-current", "true");
        else d.removeAttribute("aria-current");
      });
      if (prev) prev.disabled = atStart;
      if (next) next.disabled = atEnd;
      carousel.classList.toggle("is-static", max <= 2);
    }

    function shift(dir) {
      track.scrollBy({ left: dir * step(), behavior: "smooth" });
    }
    if (prev)
      prev.addEventListener("click", function () {
        shift(-1);
      });
    if (next)
      next.addEventListener("click", function () {
        shift(1);
      });

    track.addEventListener("keydown", function (e) {
      if (e.key === "ArrowRight") {
        e.preventDefault();
        shift(1);
      }
      if (e.key === "ArrowLeft") {
        e.preventDefault();
        shift(-1);
      }
    });

    var raf = null;
    track.addEventListener(
      "scroll",
      function () {
        if (raf) return;
        raf = requestAnimationFrame(function () {
          update();
          raf = null;
        });
      },
      { passive: true },
    );

    window.addEventListener("resize", function () {
      checkClamp();
      update();
    });
    if (document.fonts && document.fonts.ready)
      document.fonts.ready.then(function () {
        checkClamp();
        update();
      });

    checkClamp();
    update();
  }

  function boot() {
    Array.prototype.forEach.call(
      document.querySelectorAll("[data-reviews]"),
      init,
    );
  }
  if (document.readyState === "loading")
    document.addEventListener("DOMContentLoaded", boot);
  else boot();
})();
