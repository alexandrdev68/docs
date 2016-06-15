(function(object){
	var CustomReg = {
		validate : function(string, type){
			var r_obj = new RegExp(CustomReg.reg_strings[type]);
			return r_obj.test(string);
		},
		filter : function(string, type){
			r_obj = new RegExp(CustomReg.filter_strings[type]);
			return r_obj.test(string);
		},
		filter_strings : {
			email : '[a-zA-Z0-9\-._@]+',
			name : '^[a-zA-Z]+$',
			cvv : '^[0-9]+$',
			phone : '^[\+0-9]+$',
			number : '^[0-9]+$'
		},
		reg_strings : {
			email : '^[a-zA-Z0-9][-._a-zA-Z0-9]+@(?:[-a-zA-Z0-9]+\.)+[a-zA-Z]{2,6}$',
			name : '[a-zA-Z]{2,}',
			cvv : '^[0-9]{3,3}$',
			phone : '^[\+]{0,1}[0-9]{12,12}$',
			number : '^[0-9]{4,4}$'
		}
	}
	
	$('form._acquring_main_form input').on('keydown', function(event){
		
		var field_type = $(event.target).data('field_type');
		var field_value = event.key;
		
		if(field_value == 'Backspace' || field_value == 'Tab' ||
				event.keyCode == 40 || event.keyCode == 37
				|| event.keyCode == 39 || event.keyCode == 38
				|| field_value == 'Delete' || field_value == 'Enter') return true;
		
		if(CustomReg.filter(field_value, field_type) === false){
			event.stopPropagation();
			return false;
		}
	});
	
	$('form._acquring_main_form input').on('keyup', function(event){
			
		var return_without_last_char = function(string){
			return string.substring(0, (string.length - 1));
		};

		var field_type = $(event.target).data('field_type');
		var field_value = $(event.target).val();
		
		if(CustomReg.validate(field_value, field_type) === true){
			$(event.target).css('border-color', 'rgba(82, 168, 236, 0.8)');
			$(event.target).css('box-shadow', 'inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6)');
		}else if(CustomReg.validate(field_value, field_type) === false){
			$(event.target).css('border-color', 'rgb(233, 50, 45)');
			$(event.target).css('box-shadow', 'inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgb(233, 50, 45)');
		}

		if(CustomReg.filter(field_value, field_type) === false){
			event.target.value = return_without_last_char(field_value);
		}
		
	});
	
	$('form._acquring_main_form input').on('change', function(event){
		var field_type = $(event.target).data('field_type');
		var field_value = $(event.target).val();
		
		if(CustomReg.validate(field_value, field_type) === true){
			$(event.target).css('border-color', 'rgba(82, 168, 236, 0.8)');
			$(event.target).css('box-shadow', 'inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6)');
		}else if(CustomReg.validate(field_value, field_type) === false){
			$(event.target).css('border-color', 'rgb(233, 50, 45)');
			$(event.target).css('box-shadow', 'inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgb(233, 50, 45)');
		}
	});
})();