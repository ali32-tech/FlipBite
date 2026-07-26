document.addEventListener('DOMContentLoaded', () => {
  // Form submission handler
  const form = document.getElementById('audit-form');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      form.style.display = 'none';
      const successState = document.getElementById('success-state');
      if (successState) {
        successState.classList.add('active');
      }
    });
  }
});
