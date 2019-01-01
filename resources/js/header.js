jQuery(function($) {
  function handleResize(e) {
    $('header').height($(window).height());
  }

  $(window).resize(handleResize);

  handleResize();
});
