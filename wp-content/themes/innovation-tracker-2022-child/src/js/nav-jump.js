(($) => {
  const target = $('.nav-jump');
  const initialized = target.hasClass("initialized");
  if (!initialized) {
    target.addClass("initialized");

    let topTimeout;
    const $body = $('body');
    const $window = $(window);
    const $buttons = target.find(".wp-block-buttons");
    const $clone = $buttons.clone();
    const $stickyWrapper = $("<div class='nav-jump sticky'>");
    const $container = $("<div class='container'></div>");
    $stickyWrapper.append($container);
    $container.append($clone);

    let sticky = false;

    const setSticky = (on) => {
      if (sticky !== on) {
        sticky = on;
        if (on) {
          $body.append($stickyWrapper);
        } else {
          $stickyWrapper.remove();
        }
      }
    }

    const setTop = () => {
      if (topTimeout) clearTimeout(topTimeout);
      topTimeout = setTimeout(() => {
        setSticky($buttons.offset().top - $window.scrollTop() <= 0);
      },1);
    }

    setTop();

    window.addEventListener("scroll",setTop);
    window.addEventListener("resize",setTop);

    const resizeObserver = new ResizeObserver(entries => {
      setTop();
    });

    // start observing a DOM node
    resizeObserver.observe(document.body);
  }
})(jQuery);