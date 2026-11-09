/* =========================================================
   COURSES SECTION – full-bleed stacking panels
   GSAP + ScrollTrigger
   ========================================================= */
(function () {
  "use strict";

  function init() {
    if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") {
      console.warn("Courses: GSAP / ScrollTrigger not found.");
      return;
    }

    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.config({ ignoreMobileResize: true });

    const section = document.querySelector("#courses");
    if (!section) return;

    const panels = gsap.utils.toArray(section.querySelectorAll(".course-panel"));
    if (!panels.length) return;

    const mm = gsap.matchMedia();

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
        const bg = panel.querySelector(".course-bg");
        const contentItems = panel.querySelectorAll(
          ".course-label, .course-title, .course-overview, .included-title, .included-list li, .course-actions"
        );

        // Later panels sit above earlier ones
        panel.style.zIndex = i + 1;

        /* ---- 1. Pin every panel except the last ---- */
        if (i !== last) {
          ScrollTrigger.create({
            trigger: panel,
            start: () =>
              panel.offsetHeight < window.innerHeight
                ? "top top"
                : "bottom bottom",
            end: "+=100%",          // stay pinned while next panel covers it
            pin: true,
            pinSpacing: false,
            anticipatePin: 1,
            invalidateOnRefresh: true,
          });

          /* ---- 2. Slight push-back / fade as next panel covers ---- */
          gsap.to(panel.querySelector(".course-wrapper"), {
            scale: 0.94,
            opacity: 0.6,
            ease: "none",
            scrollTrigger: {
              trigger: panels[i + 1],
              start: "top bottom",
              end: "top top",
              scrub: true,
              invalidateOnRefresh: true,
            },
          });
        }

        /* ---- 3. Background parallax zoom ---- */
        if (bg) {
          gsap.fromTo(
            bg,
            { scale: 1.18 },
            {
              scale: 1,
              ease: "none",
              scrollTrigger: {
                trigger: panel,
                start: "top bottom",
                end: "bottom top",
                scrub: true,
                invalidateOnRefresh: true,
              },
            }
          );
        }

        /* ---- 4. Content reveal (once) ---- */
        gsap.from(contentItems, {
          y: 30,
          opacity: 0,
          duration: 0.75,
          ease: "power3.out",
          stagger: 0.06,
          scrollTrigger: {
            trigger: panel,
            start: "top 70%",
            once: true,
          },
        });
      });

      // Cleanup
      return () => {
        panels.forEach((p) => (p.style.zIndex = ""));
      };
    });

    // Refresh after images load
    window.addEventListener("load", () => ScrollTrigger.refresh());
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();