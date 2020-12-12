// JavaScript Document

$(document).ready(function () {

  $('.first-button').on('click', function () {

    $('.animated-icon1').toggleClass('open');
  });

});

$(function () {
  $(document).scroll(function () {
    var $nav = $(".fixed-top");
	var $dropdown = $(".dropdown-menu");
    $nav.toggleClass('scrolled', $(this).scrollTop() > 1);
	$dropdown.toggleClass('scrolled', $(this).scrollTop() > 1);
  });
});