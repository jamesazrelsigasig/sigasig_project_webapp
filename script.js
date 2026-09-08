document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.hamb');
  const links = document.querySelector('.nav-links');

  toggle?.addEventListener('click', () => {
    const opened = links?.classList.toggle('mobile-open');
    toggle.setAttribute('aria-expanded', String(Boolean(opened)));
  });

  links?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      links.classList.remove('mobile-open');
      toggle?.setAttribute('aria-expanded', 'false');
    });
  });
});
