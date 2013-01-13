/* Author:
	Matthew Wilber: mattw@click3x.com
*/

// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(document).ready(function() {

	$('#brands_list tbody').sortable({
		helper: fixHelper,
		update: function() {
		$.ajax({
			type: "POST",
			url: "brands/editorder",
			data: $('#brands_list tbody').sortable('serialize'),
			success: function() {
				//alert('data saved');
			}
		});
		}
		}).disableSelection();
		
	$('.dialog').dialog({ autoOpen: false });
});

$('.join').qtip({
	content: {
		text: 'Loading...', // The text to use whilst the AJAX request is loading
		ajax: {
			url: 'empty', // this is overridden in the plugin
			type: 'GET', // POST or GET
			data: {} // Data to pass along with your request
		},
	},
	position: {
			my: 'top center',
			at: 'bottom center'
	},
	style: {
		classes: 'qtip-dark qtip-rounded'
	}
});

/*

$(this).attr('ref');

*/