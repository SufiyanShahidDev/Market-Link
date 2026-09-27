document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.alert').forEach(el => { setTimeout(() => { const instance = bootstrap.Alert.getOrCreateInstance(el); instance.close() }, 5000) });
  document.querySelectorAll('form[onsubmit]').forEach(form => form.addEventListener('submit', e => { if (form.getAttribute('onsubmit')?.includes('confirm(')) { return; } }));
});

window.addEventListener('load', () => {
  const loader = document.getElementById('pageLoader');
  if (loader) {
    loader.classList.add('is-hidden');
    setTimeout(() => loader.remove(), 400);
  }
});

/* Global skeleton-template navigation state */
(function () {
  const loader = document.getElementById('pageLoader');
  if (!loader) return;

  const showLoader = () => loader.classList.remove('is-hidden');
  const hideLoader = () => {
    loader.classList.add('is-hidden');
    window.setTimeout(() => { if (loader.parentNode) loader.remove(); }, 350);
  };

  // Keep skeleton visible until every page asset has loaded.
  if (document.readyState === 'complete') hideLoader();
  else window.addEventListener('load', hideLoader, { once: true });

  // Show the full skeleton before navigating to another internal page.
  document.addEventListener('click', (event) => {
    const link = event.target.closest('a[href]');
    if (!link || event.defaultPrevented || link.target === '_blank') return;
    if (link.hasAttribute('download') || link.getAttribute('href')?.startsWith('#')) return;
    const href = link.href;
    if (!href || new URL(href, location.href).origin !== location.origin) return;
    if (link.getAttribute('href')?.startsWith('javascript:')) return;
    showLoader();
  });

  // Give POST pages the same skeleton transition while the request is submitted.
  document.addEventListener('submit', (event) => {
    if (event.defaultPrevented) return;
    showLoader();
  }, true);

  // Back/forward cache: show skeleton again when a cached page is restored.
  window.addEventListener('pageshow', (event) => {
    if (event.persisted) hideLoader();
  });
})();
