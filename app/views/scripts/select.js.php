recalculateSelected();

function recalculateSelected() {
	$('.category').each(function(index) {
		var newval = $(this).next().find('.typeCheckbox:checked').length;
		$(this).find('.selectedCount').text(newval);
	});
}

function createQuery() {
	var types = '';
	$('.typeCheckbox:checked').each(function(){
		types = $(this).val() + '/' + types;
	});
	$.get('/check/'+types, function(data) {
		if(data>0) {
			/*alert("There are "+data+" recycle points which fit this selection. Redirecting you to the map...");*/
			window.location.href = '/map/'+types;
		} else {
			alert("There are no recycle points available which allow that combination of types, please de-select some and try again");
		}
	});
}

/*
	This function used to be a simple toggle button.
	But now that I added animations, the order in which
	I toggle matters, so it looks like I have duplicate code.
*/
$('.category').click(function(index) { 
	if(!$(this).hasClass("open")){
		$(this).addClass("open");

		// opens the categories with animation
		var types = $(this).next();
		$(this).next().children().toggle();
		types.slideToggle('slow');
	} else {
		$(this).removeClass("open");

		// closes the categories with animation
		$(this).next().slideToggle('slow',function() {
    		// Animation complete.
    		$(this).next().children().toggle();
  		}););
	}
});

$('.typeInfoButton').click(function(index) { 
	$(this).next().slideToggle('slow'); 
});

$('.typeCheckbox').change(function() {
	recalculateSelected();
});
