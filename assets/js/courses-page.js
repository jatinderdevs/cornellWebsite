document.addEventListener("DOMContentLoaded", () => {
  const pills = document.querySelectorAll(".filter-pill");
  const cards = document.querySelectorAll(".courseCard");

  pills.forEach((pill) => {
    pill.addEventListener("click", () => {
      // Update active state
      pills.forEach((p) => {
        p.classList.remove("active");
        p.setAttribute("aria-pressed", "false");
      });
      pill.classList.add("active");
      pill.setAttribute("aria-pressed", "true");

      const filter = pill.dataset.filter;

      cards.forEach((card) => {
        if (filter === "all" || card.dataset.category === filter) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      });
    });
  });
});
