/* ============================================================
   VALENTINES RESORT & MARINA — SCRIPTS
   ============================================================ */

/* --- Navbar scroll behaviour --- */
(function () {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;
  let lastY = 0;

  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    if (y > 60) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
    lastY = y;
  }, { passive: true });
})();

/* --- Mobile hamburger menu --- */
(function () {
  const btn   = document.getElementById('navHamburger');
  const links = document.getElementById('navLinks');
  if (!btn || !links) return;

  btn.addEventListener('click', () => {
    const open = links.classList.toggle('open');
    btn.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  });

  // Close on link click
  links.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', () => {
      links.classList.remove('open');
      btn.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
})();

/* --- Scroll-reveal animation --- */
(function () {
  const els = document.querySelectorAll('.reveal');
  if (!els.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.12 });

  els.forEach(el => observer.observe(el));
})();

/* --- Sticky booking bar (shows after scrolling past hero) --- */
(function () {
  const bar = document.getElementById('bookingBar');
  if (!bar) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > window.innerHeight * 0.7) {
      bar.classList.add('visible');
    } else {
      bar.classList.remove('visible');
    }
  }, { passive: true });
})();

/* --- Smooth scroll to booking section --- */
function scrollToBooking() {
  const section = document.getElementById('booking');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    // Pre-fill dates from sticky bar
    const barIn  = document.getElementById('barCheckin');
    const barOut = document.getElementById('barCheckout');
    const fIn    = document.getElementById('checkin');
    const fOut   = document.getElementById('checkout');
    if (barIn && fIn && barIn.value)   fIn.value  = barIn.value;
    if (barOut && fOut && barOut.value) fOut.value = barOut.value;
  }
}

/* --- Booking form submission --- */
function submitBooking(e) {
  e.preventDefault();
  const form    = document.getElementById('bookingForm');
  const confirm = document.getElementById('bookingConfirmation');
  if (!form || !confirm) return;

  // Simulate submission
  const btn = form.querySelector('button[type="submit"]');
  btn.textContent = 'Sending…';
  btn.disabled = true;

  setTimeout(() => {
    form.style.display    = 'none';
    confirm.style.display = 'block';
  }, 1200);
}

/* --- Newsletter form submission --- */
function subscribeNewsletter(e) {
  e.preventDefault();
  const form    = document.getElementById('newsletterForm');
  const confirm = document.getElementById('newsletterConfirmation');
  if (!form || !confirm) return;

  const btn = form.querySelector('button[type="submit"]');
  btn.textContent = 'Subscribing…';
  btn.disabled = true;

  setTimeout(() => {
    form.style.display    = 'none';
    confirm.style.display = 'block';
  }, 1000);
}

/* --- Testimonials slider --- */
(function () {
  const track = document.getElementById('testimonialsTrack');
  const prev  = document.getElementById('prevBtn');
  const next  = document.getElementById('nextBtn');
  const dots  = document.querySelectorAll('.slider-dot');
  if (!track) return;

  let current   = 0;
  const cards   = track.querySelectorAll('.testimonial-card');
  const total   = Math.ceil(cards.length / 2); // 2 visible at once on desktop

  function goTo(idx) {
    current = Math.max(0, Math.min(idx, cards.length - 1));
    // On mobile show one card, on desktop shift by card width
    const cardW  = cards[0].offsetWidth + 28; // gap
    track.style.transform = `translateX(-${current * cardW}px)`;
    dots.forEach((d, i) => d.classList.toggle('active', i === Math.floor(current / (window.innerWidth > 768 ? 2 : 1))));
  }

  if (prev) prev.addEventListener('click', () => goTo(current - (window.innerWidth > 768 ? 2 : 1)));
  if (next) next.addEventListener('click', () => goTo(current + (window.innerWidth > 768 ? 2 : 1)));
  dots.forEach((d, i) => d.addEventListener('click', () => goTo(i * (window.innerWidth > 768 ? 2 : 1))));

  // Auto-advance every 6s
  let autoTimer = setInterval(() => {
    const step = window.innerWidth > 768 ? 2 : 1;
    const next  = current + step;
    goTo(next >= cards.length ? 0 : next);
  }, 6000);

  track.addEventListener('mouseenter', () => clearInterval(autoTimer));
  track.addEventListener('mouseleave', () => {
    autoTimer = setInterval(() => {
      const step = window.innerWidth > 768 ? 2 : 1;
      const n = current + step;
      goTo(n >= cards.length ? 0 : n);
    }, 6000);
  });
})();

/* --- Reading progress bar (blog posts) --- */
(function () {
  const bar = document.getElementById('readingProgress');
  if (!bar) return;
  window.addEventListener('scroll', () => {
    const doc  = document.documentElement;
    const pct  = (doc.scrollTop / (doc.scrollHeight - doc.clientHeight)) * 100;
    bar.style.width = pct + '%';
  }, { passive: true });
})();

/* --- Estimated read time --- */
(function () {
  const body = document.querySelector('.post-body');
  const el   = document.getElementById('readTimeDisplay');
  if (!body || !el) return;
  const words = body.innerText.trim().split(/\s+/).length;
  const mins  = Math.max(1, Math.round(words / 200));
  el.textContent = mins + ' min read';
})();

/* --- Set min dates on booking inputs --- */
(function () {
  const today = new Date().toISOString().split('T')[0];
  ['checkin','checkout','barCheckin','barCheckout'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.min = today;
  });

  // checkout must be after checkin
  const checkin = document.getElementById('checkin');
  const checkout = document.getElementById('checkout');
  if (checkin && checkout) {
    checkin.addEventListener('change', () => {
      checkout.min = checkin.value;
      if (checkout.value && checkout.value <= checkin.value) checkout.value = '';
    });
  }
})();

/* --- Share buttons (blog posts) --- */
function shareFacebook() {
  window.open('https://facebook.com/sharer/sharer.php?u=' + encodeURIComponent(location.href), '_blank', 'width=600,height=400');
}
function shareTwitter() {
  const title = document.title;
  window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(location.href) + '&text=' + encodeURIComponent(title), '_blank', 'width=600,height=400');
}
function shareEmail() {
  const title = document.title;
  location.href = 'mailto:?subject=' + encodeURIComponent(title) + '&body=' + encodeURIComponent('I thought you might enjoy this: ' + location.href);
}

/* --- Copy link to clipboard --- */
function copyLink() {
  navigator.clipboard.writeText(location.href).then(() => {
    const btn = document.getElementById('copyLinkBtn');
    if (btn) { btn.textContent = '✓ Copied!'; setTimeout(() => btn.textContent = '🔗 Copy Link', 2000); }
  });
}
