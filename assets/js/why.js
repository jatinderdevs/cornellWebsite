document.addEventListener("DOMContentLoaded", () => {
  // Only run if GSAP is loaded
  if (typeof gsap === "undefined") return;

  gsap.registerPlugin(ScrollTrigger);

  // Animate left content
  gsap.from(".wt-left", {
    opacity: 0,
    x: -40,
    duration: 0.9,
    ease: "power3.out",
    scrollTrigger: {
      trigger: ".why-testimonial-section",
      start: "top 80%",
    },
  });

  // Animate right image + card
  gsap.from(".wt-right", {
    opacity: 0,
    x: 40,
    duration: 0.9,
    delay: 0.15,
    ease: "power3.out",
    scrollTrigger: {
      trigger: ".why-testimonial-section",
      start: "top 80%",
    },
  });

  // Stats count-up effect (optional nice touch)
  const stats = document.querySelectorAll(".wt-stat-number");
  stats.forEach((stat) => {
    const finalValue = stat.textContent;
    if (finalValue.includes("+") || finalValue.includes(".")) {
      // Keep original for rating and + numbers
      return;
    }
  });
});
document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".wt-slide");
  const dots = document.querySelectorAll(".wt-dot");
  let current = 0;
  let autoPlay;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("active", i === index);
    });
    dots.forEach((dot, i) => {
      dot.classList.toggle("active", i === index);
    });
    current = index;
  }

  // Dot click
  dots.forEach((dot) => {
    dot.addEventListener("click", () => {
      showSlide(Number(dot.dataset.index));
      resetAutoPlay();
    });
  });

  // Auto play
  function startAutoPlay() {
    autoPlay = setInterval(() => {
      let next = (current + 1) % slides.length;
      showSlide(next);
    }, 5000);
  }

  function resetAutoPlay() {
    clearInterval(autoPlay);
    startAutoPlay();
  }

  startAutoPlay();
});
