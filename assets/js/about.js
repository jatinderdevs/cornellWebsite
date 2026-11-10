// Smooth scroll for any internal anchors on the about page
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

//Make sure GSAP + ScrollTrigger are loaded before this

gsap.registerPlugin(ScrollTrigger);

const videoSection = document.querySelector('.about-img');
const videoInner   = document.querySelector('.about-img-inner');

if (videoSection && videoInner) {
  gsap.fromTo(videoInner,
    {
      width: '40vw',
      maxWidth: '480px',
      borderRadius: '16px'
    },
    {
      width: '100vw',
      maxWidth: '100vw',
      borderRadius: '0px',
      ease: 'none',
      scrollTrigger: {
        trigger: videoSection,
        start: 'top top',
        end: 'bottom top',
        scrub: true,
        pin: true,
        anticipatePin: 1
      }
    }
  );
}