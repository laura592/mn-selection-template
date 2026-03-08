(function () {
  document.querySelectorAll('[data-ex6-slider]').forEach(function (slider) {
    var slides = slider.querySelectorAll('.exercise-6__slide');
    if (slides.length < 2) return;

    var current = 0;

    function show(index) {
      slides.forEach(function (s, i) {
        s.classList.toggle('is-active', i === index);
      });
    }

    show(0);

    slider.querySelector('.exercise-6__arrow--prev').addEventListener('click', function () {
      current = (current - 1 + slides.length) % slides.length;
      show(current);
    });

    slider.querySelector('.exercise-6__arrow--next').addEventListener('click', function () {
      current = (current + 1) % slides.length;
      show(current);
    });
  });
})();
