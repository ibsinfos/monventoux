$(document).ready(function(){

	updateNationality();
	toggleCMLidnummer();

	$('#nationaliteit').change(function(){
		updateNationality();
	});

	$('#cmlid').change(function(){
		toggleCMLidnummer();
	});

	// index
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: "-100:+0"
	});
});

function toggleCMLidnummer(){
	if ( $('#cmlid').is(':checked') ){
		$('#cmlidnummer').slideDown();
		$('label[for="'+$('#cmlidnummer').attr('id')+'"]').slideDown();
	}else{
		$('#cmlidnummer').hide().val(''); 
		$('label[for="'+$('#cmlidnummer').attr('id')+'"]').slideUp();
	}
}


function updateNationality(){
	var value = $('#nationaliteit').val();
	$('#sofinummer').hide();
	$('label[for="'+$('#sofinummer').attr('id')+'"]').hide();
	$('#rijksregisternummer').hide();
	$('label[for="'+$('#rijksregisternummer').attr('id')+'"]').hide();
	if (value == 'BE'){
		$('#rijksregisternummer').slideDown();
		$('label[for="'+$('#rijksregisternummer').attr('id')+'"]').slideDown();
		$('#sofinummer').val('');
	}else if(value == 'NL'){
		$('#sofinummer').slideDown();
		$('label[for="'+$('#sofinummer').attr('id')+'"]').slideDown();
		$('#rijksregisternummer').val('');
	}else{
		$('#rijksregisternummer').val('');
		$('#sofinummer').val('');
	}
}



