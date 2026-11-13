document.addEventListener("DOMContentLoaded", () => {
  const formUl = document.querySelectorAll(".ss-form-list>li");

  console.log(formUl);

  formUl.forEach((li) => {
    return (li.innerHTML += `<img src="assets/images/icons/pdf.png" alt="">`);
  });

  // Smooth scroll for jump links
  document.querySelectorAll(".ss-jump-pill").forEach((link) => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href");
      if (!href || !href.startsWith("#")) return;

      const target = document.querySelector(href);
      if (!target) return;

      e.preventDefault();
      const offset = 80; // account for sticky nav
      const top =
        target.getBoundingClientRect().top + window.pageYOffset - offset;

      window.scrollTo({
        top,
        behavior: "smooth",
      });
    });
  });

  // Highlight active jump pill on scroll
  const sections = document.querySelectorAll(
    ".ss-section[id], #privacy, #contacts",
  );
  const pills = document.querySelectorAll(".ss-jump-pill");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          pills.forEach((p) => {
            p.classList.toggle("active", p.getAttribute("href") === `#${id}`);
          });
        }
      });
    },
    { rootMargin: "-30% 0px -55% 0px", threshold: 0 },
  );

  sections.forEach((sec) => observer.observe(sec));
});
