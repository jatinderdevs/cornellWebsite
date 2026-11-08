const btnIcons = document.querySelectorAll(".btn-icon");

btnIcons.forEach((x) => {
  console.log(x);
  return (x.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                <rect width="256" height="256" fill="none" />
                <line
                  x1="64"
                  y1="192"
                  x2="192"
                  y2="64"
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="16"
                />
                <polyline
                  points="88 64 192 64 192 168"
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="16"
                />
              </svg>`);
});

document.addEventListener("DOMContentLoaded", () => {
  const header = document.getElementById("header");
  const toggle = document.getElementById("headerToggle");
  const nav = document.getElementById("headerNav");
  const megaTriggers = document.querySelectorAll(".mega-trigger");

  // Create overlay
  const overlay = document.createElement("div");
  overlay.className = "menu-overlay";
  document.body.appendChild(overlay);

  // Header scroll
  window.addEventListener("scroll", () => {
    if (window.scrollY > 40) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });

  // Mobile menu toggle
  toggle.addEventListener("click", () => {
    toggle.classList.toggle("active");
    nav.classList.toggle("active");
    overlay.classList.toggle("active");
    document.body.style.overflow = nav.classList.contains("active")
      ? "hidden"
      : "";
  });

  // Close mobile menu when clicking overlay
  overlay.addEventListener("click", () => {
    toggle.classList.remove("active");
    nav.classList.remove("active");
    overlay.classList.remove("active");
    document.body.style.overflow = "";
  });

  // Mega menu on mobile (accordion)
  megaTriggers.forEach((trigger) => {
    trigger.addEventListener("click", (e) => {
      if (window.innerWidth < 1024) {
        e.preventDefault();
        const parent = trigger.closest(".has-mega");
        parent.classList.toggle("active");

        // Update aria
        const expanded = parent.classList.contains("active");
        trigger.setAttribute("aria-expanded", expanded);
      }
    });
  });

  // GSAP Animations (safe version)
  if (typeof gsap !== "undefined") {
    gsap.from(".hero-title", {
      y: 50,
      opacity: 0,
      duration: 1.1,
      ease: "power3.out",
      delay: 0.2,
    });

    gsap.from(".hero-subtitle", {
      y: 40,
      opacity: 0,
      duration: 1,
      ease: "power3.out",
      delay: 0.4,
    });
  }
});
