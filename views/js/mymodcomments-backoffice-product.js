$(document).ready(function() {
	$('.comments-pagination-link').click(function() {
		// Retrieve the ajax link from the “href”
		var url = $(this).attr('href');

		// Make the ajax request
		$.ajax({
			url: url,
		}).done(function(data) {
			$('#product-tab-content-ModuleMymodcomments').html(data);
		});

		// Return false to disable classic link redirection
		return false;
	});
});