(function($){
	"use strict";
	$(function(){

		$('#submit-info-contacto').on('click', function(e){
			e.preventDefault();
			var direccion_mexico  = $('#direccion-mexico').val(),
				telefono_mexico   = $('#telefono-mexico').val(),
				fax_mexico        = $('#fax-mexico').val(),
				direccion_morelia = $('#direccion-morelia').val(),
				telefono_morelia  = $('#telefono-morelia').val();

			jQuery.ajax({
				type: 'POST',
				url: ajax_url,
				data: {
					direccion_mexico: direccion_mexico,
					telefono_mexico: telefono_mexico,
					fax_mexico: fax_mexico,
					direccion_morelia: direccion_morelia,
					telefono_morelia: telefono_morelia,
					action: 'menu_contacto_save'
				},
				success: function(data){
					if(data){
						console.log('data');
						$('#settings-contacto-message').fadeIn('800');
					}
				}, error: function(){
					console.log('error');
				},
				dataType: 'json'
			});
		});
	});
})(jQuery);