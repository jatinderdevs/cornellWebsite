
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          e.preventDefault();
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
    const unitsToggle = document.getElementById('unitsToggle');
    const unitsTable = document.querySelector('.units-table');

    if (unitsToggle && unitsTable) {
      unitsToggle.addEventListener('click', () => {
        const isExpanded = unitsTable.classList.toggle('is-expanded');
        unitsToggle.textContent = isExpanded ? 'Show less' : 'See all 25 units';
      });
    }
  