/* =========================================================
   COURSES SECTION – stacking panels (GSAP + ScrollTrigger)
   Requires gsap and ScrollTrigger to be loaded before this file.
   ========================================================= */
(function () {
  "use strict";

  function init() {
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
      console.warn("Courses: GSAP / ScrollTrigger not found.");
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    // Stops mobile address-bar show/hide from re-measuring and jumping
    ScrollTrigger.config({ ignoreMobileResize: true });

    const section = document.querySelector("#courses");
    if (!section) return;

    const panels = gsap.utils.toArray(
      section.querySelectorAll(".course-panel"),
    );
    if (!panels.length) return;

    const mm = gsap.matchMedia();

    // Everything animated lives here, so users who prefer reduced
    // motion simply get a normal, readable list of cards.
    mm.add("(prefers-reduced-motion: no-preference)", () => {
      const last = panels.length - 1;

      /* ---- Header intro ---- */
      gsap.from(section.querySelectorAll(".courses-header > *"), {
        y: 28,
        opacity: 0,
        duration: 0.8,
        ease: "power3.out",
        stagger: 0.12,
        scrollTrigger: {
          trigger: ".courses-header",
          start: "top 85%",
          once: true,
        },
      });

      panels.forEach((panel, i) => {
        const card = panel.querySelector(".course-card");
        const img = panel.querySelector(".course-image img");
        const items = panel.querySelectorAll(
          ".course-number, .course-meta, .course-name, .course-code, .course-desc, .course-tag, .course-speaker",
        );

        // Later cards must paint above earlier (pinned) ones
        panel.style.zIndex = i + 1;

        /* ---- 1. Pin every panel except the last ----
           Panels shorter than the viewport pin at the top; taller ones
           (small phones) pin at the bottom so all content is readable. */
        if (i !== last) {
          ScrollTrigger.create({
            trigger: panel,
            start: () =>
              panel.offsetHeight < window.innerHeight
                ? "top 100px"
                : "bottom bottom",
            pin: true,
            pinSpacing: false,
            anticipatePin: 1,
            invalidateOnRefresh: true,
          });

          /* ---- 2. Push the card back as the next one covers it ---- */
          gsap.to(card, {
            scale: 0.92,
            opacity: 0,
            ease: "none",
            scrollTrigger: {
              trigger: panels[i + 1],
              start: "top 50%",
              end: "top top",
              scrub: true,
              invalidateOnRefresh: true,
            },
          });
        }

        /* ---- 3. Image parallax zoom while the panel slides in ---- */
        if (img) {
          gsap.fromTo(
            img,
            { scale: 1.22 },
            {
              scale: 1,
              ease: "none",
              scrollTrigger: {
                trigger: panel,
                start: "top bottom",
                end: "top top",
                scrub: true,
                invalidateOnRefresh: true,
              },
            },
          );
        }

        /* ---- 4. Content reveal (plays once) ---- */
        gsap.from(items, {
          y: 26,
          opacity: 0,
          duration: 0.7,
          ease: "power3.out",
          stagger: 0.07,
          scrollTrigger: {
            trigger: panel,
            start: "top 65%",
            once: true,
          },
        });
      });

      // Cleanup when the media query stops matching
      return () => {
        panels.forEach((p) => (p.style.zIndex = ""));
      };
    });

    // Images change layout height once loaded
    window.addEventListener("load", () => ScrollTrigger.refresh());
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
