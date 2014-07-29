$(document).ready(function(){
	if ($('#mymodcomments-content-tab').attr('data-scroll') == 'true')
		$.scrollTo('#mymodcomments-content-tab', 1200);
});

$(document).ready(function () {
	$('.rating').rating();
});