//sidnav collapse
$(".button-collapse").sideNav();
//efecto parallax
$(document).ready(function(){
    $('.parallax').parallax();
});

/*$('#activate1').hover(function(){
	$('#dropdown1').trigger('hover')
  //console.log('hover');
});*/

$(document).hover(function(){
    $(".dropdown-button").dropdown()
});

$(document).ready(function(){
    $('.slider').slider();
  });

  $(document).ready(function(){
    $('.carousel').carousel();
  });

  $(document).ready(function(){
    $('.modal').modal();
  });