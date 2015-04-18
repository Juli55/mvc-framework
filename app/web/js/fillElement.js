function fillElement(){
	this.element;
	//sets the Element which should edit
		this.setElement = function(element){
			this.element = $(element);
		};
	//set Content of an htmlElement
		this.setContent = function(call, data){
			$(this.element).closest(call).html(data);
		};
	//set Attribute of an Element
		this.setAttribute = function(call, attribute, value){
			$(this.element).closest(call).attr(attribute, value);
		};
	//returns the Element
		this.getElement = function(){
			return this.element;
		};
}