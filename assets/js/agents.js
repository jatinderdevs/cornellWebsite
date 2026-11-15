document.addEventListener("DOMContentLoaded", () => {
  // ---------- FAQ accordion ----------
  const faqItems = document.querySelectorAll(".ag-faq-item");

  faqItems.forEach((item) => {
    const question = item.querySelector(".ag-faq-question");

    question.addEventListener("click", () => {
      const isOpen = item.classList.contains("active");

      // Close all
      faqItems.forEach((i) => {
        i.classList.remove("active");
        i.querySelector(".ag-faq-question").setAttribute(
          "aria-expanded",
          "false",
        );
      });

      // Open clicked if it was closed
      if (!isOpen) {
        item.classList.add("active");
        question.setAttribute("aria-expanded", "true");
      }
    });
  });

  // ---------- Agent directory: search + country filter ----------
  const grid = document.getElementById("agent-grid");

  if (grid) {
    const cards = Array.from(grid.querySelectorAll(".ag-agent-card"));
    const searchInput = document.getElementById("agent-search");
    const pills = Array.from(document.querySelectorAll(".ag-filter-pill"));
    const countEl = document.getElementById("agent-count");
    const emptyEl = document.getElementById("agent-none");
    const total = cards.length;
    let activeCountry = "all";

    const plural = (n) => (n === 1 ? "agent" : "agents");

    const applyFilters = () => {
      const q = (searchInput ? searchInput.value : "").trim().toLowerCase();
      let shown = 0;

      cards.forEach((card) => {
        const matchesCountry =
          activeCountry === "all" || card.dataset.country === activeCountry;
        const matchesSearch = !q || card.dataset.search.includes(q);
        const visible = matchesCountry && matchesSearch;

        card.hidden = !visible;
        if (visible) shown++;
      });

      if (countEl) {
        countEl.textContent = `Showing ${shown} of ${total} ${plural(total)}`;
      }
      if (emptyEl) {
        emptyEl.hidden = shown !== 0;
      }
    };

    if (searchInput) {
      searchInput.addEventListener("input", applyFilters);
    }

    pills.forEach((pill) => {
      pill.addEventListener("click", () => {
        activeCountry = pill.dataset.filter;
        pills.forEach((p) => p.classList.toggle("active", p === pill));
        applyFilters();
      });
    });
  }

  // ---------- Smooth scroll for internal anchors ----------
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        e.preventDefault();
        const offset = 80;
        const top =
          target.getBoundingClientRect().top + window.pageYOffset - offset;
        window.scrollTo({ top, behavior: "smooth" });
      }
    });
  });
});
