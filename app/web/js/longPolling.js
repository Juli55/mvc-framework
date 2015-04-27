function longPolling(){
	var self = this;
	//poll the server
		this.poll = function(url, pushFunction){
			var stop = false;
			$.ajax({
				url: url,
				dataType: 'json',
			})
			.done(function(data){
				stop = true;
				pushFunction(data);
			})
			.always(function(){
				if(!stop){
					self.poll(url, pushFunction);
				}
			 });
		};
}