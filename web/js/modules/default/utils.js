var m;
function showForm(adress) {
	$.post(adress, {}, function(data) {
		$( "#ajax-div" ).empty().append(data);
		$('#list-ajax-div').fadeOut('fast', function() {
			$( "#ajax-div" ).fadeIn();
		});
	});
}
function setIdClic(e, id) {
	 var rightclick;
	 var e = window.event || e;
	 if (e.which) rightclick = (e.which == 3);
	 else if (e.button) rightclick = (e.button == 2);
	 if(rightclick) m = id;
}
function goBack() {
	$('#ajax-div').fadeOut('fast', function() {
		$("#list-ajax-div").fadeIn();
		$('#lytHrchy').empty();
		$('#lytHrchy').html($('#tpltLstHrchy').html());
	});
}
function setHasError(id){
	$(id).parent().parent().removeClass('has-success')
	$(id).parent().parent().addClass('has-error');
}
function setHasSuccess(id){
	$(id).parent().parent().removeClass('has-error')
	$(id).parent().parent().addClass('has-success');
}
function removeAllSet(id) {
	$(id).parent().parent().removeClass('has-error')
	$(id).parent().parent().removeClass('has-success')
}

// Fonction d'affichage de couleur sur le champ passé en id
function animError(id){
    $(id).animate({
            backgroundColor: "#DF0101"
    }, 300);
    $(id).animate({
            backgroundColor: "white"
    }, 300);
    $(id).animate({
            backgroundColor: "#DF0101"
    }, 300);
    $(id).animate({
            backgroundColor: "white"
    }, 300);
}