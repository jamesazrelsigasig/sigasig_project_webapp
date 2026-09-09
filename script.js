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

  const gallery = document.querySelector('.portfolio-grid');
  if (gallery) {
    const items = [...gallery.querySelectorAll('.portfolio-item')];
    const more = document.querySelector('.load-more-btn');
    let filter = 'all';
    let visible = 6;

    const render = () => {
      const matches = items.filter((item) => filter === 'all' || item.dataset.category === filter);
      items.forEach((item) => {
        item.hidden = !matches.includes(item) || matches.indexOf(item) >= visible;
      });
      if (more) more.hidden = matches.length <= visible;
    };

    document.querySelectorAll('.filter').forEach((button) => {
      button.addEventListener('click', () => {
        filter = button.dataset.filter;
        visible = 6;
        document.querySelectorAll('.filter').forEach((item) => {
          item.classList.toggle('active', item === button);
        });
        render();
      });
    });

    more?.addEventListener('click', () => {
      visible += 3;
      render();
    });

    render();
  }
});
