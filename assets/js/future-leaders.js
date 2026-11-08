/* =========================================================
   FUTURE LEADERS SECTION - scroll reveal (no libraries needed)
   ========================================================= */
// Scroll-reveal (IntersectionObserver)
(function () {
  var els = document.querySelectorAll('.fl-reveal');
  if (!('IntersectionObserver' in window)) {
    els.forEach(function (e) { e.classList.add('is-in'); });
    return;
  }
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (en) {
      if (en.isIntersecting) {
        en.target.classList.add('is-in');
        io.unobserve(en.target);
      }
    });
  }, { threshold: 0.15 });
  els.forEach(function (e) { io.observe(e); });
})();
