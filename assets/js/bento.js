/* =========================================================
   CAMPUS BENTO GRID – lightbox for images, Instagram reels, mp4
   GSAP reveal is optional: it runs only if gsap + ScrollTrigger exist.
   ========================================================= */
(function () {
  "use strict";

  function init() {
    var grid = document.querySelector(".bento-grid");
    var box = document.getElementById("bentoLightbox");
    if (!grid || !box) return;

    var items = Array.prototype.slice.call(
      grid.querySelectorAll(
        '.bento-item[data-type="image"], .bento-item[data-type="reel"]',
      ),
    );
    var stage = box.querySelector(".bento-lightbox__stage");
    var caption = box.querySelector(".bento-lightbox__caption");
    var btnPrev = box.querySelector(".bento-lightbox__prev");
    var btnNext = box.querySelector(".bento-lightbox__next");
    var current = -1;
    var lastFocus = null;

    /* ---------- helpers ---------- */
    function reelEmbedUrl(url) {
      try {
        var u = new URL(url);
        var path = u.pathname.replace(/\/+$/, "");
        if (!/\/embed$/.test(path)) path += "/embed";
        return "https://www.instagram.com" + path + "/";
      } catch (e) {
        return "";
      }
    }

    function buildMedia(item) {
      var type = item.getAttribute("data-type");
      var thumb = item.querySelector("img");
      var el;

      if (type === "reel") {
        el = document.createElement("iframe");
        el.src = reelEmbedUrl(item.getAttribute("data-reel"));
        el.title = "Instagram reel";
        el.allow = "autoplay; encrypted-media; picture-in-picture";
        el.allowFullscreen = true;
        el.setAttribute("scrolling", "no");
      } else if (type === "video") {
        el = document.createElement("video");
        el.src = item.getAttribute("data-video");
        el.controls = true;
        el.autoplay = true;
        el.playsInline = true;
        if (thumb) el.poster = thumb.currentSrc || thumb.src;
      } else {
        el = document.createElement("img");
        el.src =
          item.getAttribute("data-full") || (thumb && thumb.currentSrc) || "";
        el.alt = thumb ? thumb.alt : "";
      }
      return el;
    }

    function captionFor(item) {
      var badge = item.querySelector(".bento-badge");
      var cap = item.querySelector(".bento-caption");
      var parts = [];
      if (badge) parts.push(badge.textContent.trim());
      if (cap) parts.push(cap.textContent.trim());
      return parts.join(" · ");
    }

    /* ---------- open / close / navigate ---------- */
    function show(index) {
      current = (index + items.length) % items.length;
      stage.innerHTML = "";
      stage.appendChild(buildMedia(items[current]));
      caption.textContent = captionFor(items[current]);
    }

    function open(index) {
      lastFocus = document.activeElement;
      box.hidden = false;
      document.body.style.overflow = "hidden";
      show(index);
      box.querySelector(".bento-lightbox__close").focus();
    }

    function close() {
      box.hidden = true;
      stage.innerHTML = ""; // removes iframe/video so playback stops
      document.body.style.overflow = "";
      current = -1;
      if (lastFocus && lastFocus.focus) lastFocus.focus();
    }

    /* ---------- events ---------- */
    items.forEach(function (item, i) {
      item.addEventListener("click", function () {
        open(i);
      });
    });

    box.addEventListener("click", function (e) {
      if (e.target.closest("[data-close]")) close();
    });
    btnPrev.addEventListener("click", function () {
      show(current - 1);
    });
    btnNext.addEventListener("click", function () {
      show(current + 1);
    });

    document.addEventListener("keydown", function (e) {
      if (box.hidden) return;
      if (e.key === "Escape") close();
      else if (e.key === "ArrowLeft") show(current - 1);
      else if (e.key === "ArrowRight") show(current + 1);
      else if (e.key === "Tab") {
        // keep focus inside the dialog
        var f = box.querySelectorAll("button, iframe, video[controls]");
        if (!f.length) return;
        var first = f[0];
        var last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) {
          e.preventDefault();
          last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    });
    var videoTiles = grid.querySelectorAll('.bento-item[data-type="video"]');
    var canHover = window.matchMedia("(hover: hover)").matches;
    var reduceMotion = window.matchMedia(
      "(prefers-reduced-motion: reduce)",
    ).matches;

    videoTiles.forEach(function (tile) {
      var v = tile.querySelector("video");
      if (!v || reduceMotion) return;

      function play() {
        var p = v.play();
        if (p && p.catch) p.catch(function () {});
        tile.classList.add("is-playing");
      }
      function stop() {
        v.pause();
        v.currentTime = 0;
        tile.classList.remove("is-playing");
      }

      if (canHover) {
        tile.addEventListener("mouseenter", play);
        tile.addEventListener("mouseleave", stop);
      } else {
        // phones/tablets have no hover: play while the tile is mostly on screen
        new IntersectionObserver(
          function (entries) {
            entries.forEach(function (e) {
              e.isIntersecting ? play() : stop();
            });
          },
          { threshold: 0.6 },
        ).observe(tile);
      }
    });
    /* ---------- optional GSAP reveal ---------- */
    if (
      typeof gsap !== "undefined" &&
      typeof ScrollTrigger !== "undefined" &&
      window.matchMedia("(prefers-reduced-motion: no-preference)").matches
    ) {
      gsap.registerPlugin(ScrollTrigger);
      gsap.from(grid.querySelectorAll(".bento-item"), {
        y: 36,
        opacity: 0,
        duration: 0.75,
        ease: "power3.out",
        stagger: 0.08,
        scrollTrigger: { trigger: grid, start: "top 82%", once: true },
      });
      gsap.from(".campus-header > *", {
        y: 24,
        opacity: 0,
        duration: 0.7,
        ease: "power3.out",
        stagger: 0.1,
        scrollTrigger: {
          trigger: ".campus-header",
          start: "top 85%",
          once: true,
        },
      });
    }
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
