function formValidate(){
	//get the Data from Ajax and then change the DOM if changes in the validations
		this.getData = function(input, route, setValidation, validationArray){
    		$.ajax({
		      url: route,
		      data: input.serialize(),
		      dataType: 'json',
		    })
		    .done(function(data){
		    	change = getChange(data, validationArray);
		    	setValidation(change, input);
		    });
		};
	//setArray
		var getChange = function(data, validationArray){
			internValidationArray = validationArray;
			change = {};
			//fill Form if it is empty
				if(jQuery.isEmptyObject(internValidationArray)){
				    $.each(data, function(name, value){
				    	internValidationArray[name] = {};
				    	internValidationArray[name].valid = value.valid;
				    	internValidationArray[name].errorMsg = value.errorMsg;
				    });
				    change = internValidationArray;
				}else{
					//check if something different
						$.each(data, function(name, value){
							if(name in internValidationArray){
								//check valid
									if('valid' in internValidationArray[name]){
										if(value.valid !== internValidationArray[name].valid){
											if(jQuery.isEmptyObject(change[name])){
												change[name] = {}
											}
											change[name].valid = value.valid;
											internValidationArray[name].valid = value.valid;
										}
									}
									if(value.valid === false){
										if(value.errorMsg !== internValidationArray[name].errorMsg){
											if(jQuery.isEmptyObject(change[name])){
												change[name] = {}
											}
											change[name].errorMsg = value.errorMsg;
											internValidationArray[name].errorMsg = value.errorMsg;
										}
									}
							}else{
								internValidationArray[name] = {};
				    			internValidationArray[name].valid = value.valid;
				    			internValidationArray[name].errorMsg = value.errorMsg;
				    			change.valid = this.validateArray[name];
							}
						});
				}
				console.log(internValidationArray);
				return change;
		};
}