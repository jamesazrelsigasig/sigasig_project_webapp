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

  document.querySelectorAll('.faq-q').forEach((button) => {
    button.addEventListener('click', () => {
      const item = button.closest('.faq-item');
      const opened = item.classList.toggle('open');
      button.setAttribute('aria-expanded', String(opened));
      const indicator = button.querySelector('span');
      if (indicator) indicator.textContent = opened ? '−' : '+';
    });
  });
});
