$('input[type="submit"]').mousedown(function(){
  $(this).css('background', '#2ecc71');
});
$('input[type="submit"]').mouseup(function(){
  $(this).css('background', '#1abc9c');
});

$('#loginform').click(function(){
  $('.login').fadeToggle('slow');
  $('.regiter').hide();
   $('#regiterform').removeClass('green');
  $(this).toggleClass('green');
});

$('#regiterform').click(function(){
  $('.regiter').fadeToggle('slow');
   $('.login').hide();
   $('#loginform').removeClass('green');
  $('#loginform').removeClass('a1');
  $(this).toggleClass('green');
});