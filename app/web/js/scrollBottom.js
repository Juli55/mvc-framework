function scrollBottom(){
	var $win = $(window);
	//sets the Element which should edit
		this.detect = function(scrollFunction){
			$(window).scroll(function()
			{
			    if($(window).scrollTop() + window.innerHeight == $(document).height())
			    {
			    	scrollFunction();
			    }
			});
		};
}