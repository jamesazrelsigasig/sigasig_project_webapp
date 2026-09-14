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
  const paymentChoice = document.querySelector('#payment-choice');
  const paymentDialog = document.querySelector('#payment-dialog');
  const openPayment = document.querySelector('#open-payment');
  const closePayment = document.querySelector('#close-payment');
  const cancelPayment = document.querySelector('#cancel-payment');
  const savePayment = document.querySelector('#save-payment');
  const paymentPlan = document.querySelector('#booking-payment-plan');
  const paymentMethod = document.querySelector('#booking-payment-method');
  const paymentInstructions = document.querySelector('#payment-instructions');
  const paymentDetails = {
    gcash: 'Send to GCash: James Azrel T. Sigasig - 09937369734.',
    bank_transfer: 'Bank transfer: Visa | James Azrel T. Sigasig | Account 2453 5864 9899 2145.',
    cash: 'Cash payment is collected after the session.',
    card: 'Card payment instructions will be provided after your booking is confirmed.'
  };
  const updateBookingButton = () => {
    bookingSubmit.textContent = bookingDate.value ? `Book Now - ${bookingDate.value}` : 'Book Now';
  };
  const updatePaymentSummary = () => {
    const paymentDetails = {
      Portraits: 'Starting at PHP 6,500',
      'Weddings & Events': 'Starting at PHP 35,000',
      'Brand & Commercial': 'Custom quote'
    }[bookingSession.value];

    if (paymentPlan.value && paymentMethod.value) {
      paymentChoice.textContent = `${paymentPlan.options[paymentPlan.selectedIndex].text} via ${paymentMethod.options[paymentMethod.selectedIndex].text}`;
    } else {
      paymentChoice.textContent = 'No payment preference selected.';
    }

    if (!paymentDetails) {
      paymentSession.textContent = 'Select a session to see the estimated price.';
      paymentAmount.textContent = '';
      paymentSummary.hidden = false;
      return;
    }

    paymentSession.textContent = `Session: ${bookingSession.value}`;
    paymentAmount.textContent = paymentDetails;
    paymentSummary.hidden = false;
  };
  const updatePaymentInstructions = () => {
    const details = paymentDetails[paymentMethod.value];
    paymentInstructions.textContent = details || '';
    paymentInstructions.hidden = !details;
  };

  if (bookingForm && bookingDate && bookingSubmit && bookingSession && paymentSummary && paymentSession && paymentAmount && paymentChoice && paymentDialog && openPayment && closePayment && cancelPayment && savePayment && paymentPlan && paymentMethod && paymentInstructions) {
    bookingDate.addEventListener('change', updateBookingButton);
    bookingSession.addEventListener('change', updatePaymentSummary);
    paymentMethod.addEventListener('change', updatePaymentInstructions);
    openPayment.addEventListener('click', () => {
      paymentDialog.hidden = false;
      document.body.classList.add('modal-open');
      paymentPlan.focus();
    });
    const hidePaymentDialog = () => {
      paymentDialog.hidden = true;
      document.body.classList.remove('modal-open');
    };
    closePayment.addEventListener('click', hidePaymentDialog);
    cancelPayment.addEventListener('click', hidePaymentDialog);
    savePayment.addEventListener('click', () => {
      if (!paymentPlan.value || !paymentMethod.value) {
        paymentPlan.reportValidity();
        paymentMethod.reportValidity();
        return;
      }
      updatePaymentSummary();
      updatePaymentInstructions();
      hidePaymentDialog();
    });
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
