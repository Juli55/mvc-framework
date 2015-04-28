function polling(){
	var self = this;
	//poll the server
		this.poll = function(url, pushFunction, useStop = false, timeout = 2000){
			var stop = false;
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'post'
			})
			.done(function(data){
				pushFunction(data);
				if(useStop){
					stop = true;
				}
			})
			.fail(function(){
				if(useStop){
					stop = false;
				}
			 })
			.always(function(){
				if(!stop){
					setTimeout(
						function(){
					    	self.poll(url, pushFunction);
					  	}, timeout);
				}
			 });
		};
}