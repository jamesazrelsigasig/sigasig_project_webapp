const bindStatusModal = () => {
  const statusModal = document.querySelector('#status-modal');
  if (!statusModal) return;

  const closeStatusModal = () => {
    statusModal.remove();
    document.body.classList.remove('modal-open');
  };

  document.body.classList.add('modal-open');

  statusModal.querySelectorAll('.success-modal-close, [data-close-status]').forEach((button) => {
    button.addEventListener('click', closeStatusModal);
  });

  statusModal.addEventListener('click', (event) => {
    if (event.target === statusModal) closeStatusModal();
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeStatusModal();
  }, { once: true });
};

const initSite = () => {
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

  bindStatusModal();

  const bookingForm = document.querySelector('.booking-form');
  const bookingDate = document.querySelector('#booking-date');
  const bookingSubmit = document.querySelector('#booking-submit');
  const bookingSession = document.querySelector('#booking-session');
  const paymentSummary = document.querySelector('#payment-summary');
  const paymentSession = document.querySelector('#payment-session');
  const paymentAmount = document.querySelector('#payment-amount');
  const updateBookingButton = () => {
    bookingSubmit.textContent = bookingDate.value ? `Book Now - ${bookingDate.value}` : 'Book Now';
  };
  const updatePaymentSummary = () => {
    const paymentDetails = {
      Portraits: 'Starting at PHP 6,500',
      'Weddings & Events': 'Starting at PHP 35,000',
      'Brand & Commercial': 'Custom quote'
    }[bookingSession.value];

    if (!paymentDetails) {
      paymentSummary.hidden = true;
      return;
    }

    paymentSession.textContent = `Session: ${bookingSession.value}`;
    paymentAmount.textContent = paymentDetails;
    paymentSummary.hidden = false;
  };

  if (bookingForm && bookingDate && bookingSubmit && bookingSession && paymentSummary && paymentSession && paymentAmount) {
    bookingDate.addEventListener('change', updateBookingButton);
    bookingSession.addEventListener('change', updatePaymentSummary);
    updateBookingButton();
    updatePaymentSummary();
    bookingForm.addEventListener('submit', () => {
      bookingSubmit.disabled = true;
    });
  }

  document.querySelectorAll('.faq-q').forEach((button) => {
    button.addEventListener('click', () => {
      const item = button.closest('.faq-item');
      if (!item) return;
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
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSite, { once: true });
} else {
  initSite();
}
