jQuery(function($) {

  var stickyModifier = 'navigation-block--sticky';
  var animationClass = 'animated slideInDown';

  function handleStickyStart(e, options) {
    $(e.target).addClass(stickyModifier + ' ' + animationClass);
    $('.navigation-block__link', e.target).addClass(stickyModifier + '__link');
  }

  function handleStickyEnd(e, options) {
    $(e.target).removeClass(stickyModifier + ' ' + animationClass);
    $('.navigation-block__link', e.target).removeClass(stickyModifier + '__link');
  }
  
  $('.js-nav-sticky')
    .on('sticky-start', handleStickyStart)
    .on('sticky-end', handleStickyEnd)
    .sticky({
      topSpacing: 0,
      zIndex: 9999,
    });

  $('.js-nav-tiny-target').tinyNav({
    header: 'MENU',
    active: 'selected',
  });

  $('.js-inner-link').click(function(e) {
    e.preventDefault();
    var selector = $(e.target).attr('href');
    $(document).scrollTo(selector, 700, {easing: 'swing'});
  });
});
