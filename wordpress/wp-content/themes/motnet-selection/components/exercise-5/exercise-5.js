(function () {
  document.querySelectorAll('[data-ex5-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      var item = btn.closest('.exercise-5__item');
      var info = item.querySelector('.exercise-5__info');
      if (!info) return;

      var isOpen = !info.hidden;
      info.hidden = isOpen;
      item.classList.toggle('is-open', !isOpen);
    });
  });
})();
