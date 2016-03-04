/*
 * Функція для організації моделі та відображення в javascript.
 * Приклад:
 *  
 */
function VTemplate(params){
	params = params || {};
	
	if(!!params.tmpName)
		this.tmpName = params.tmpName;
	else
		return false;
	
	if(!!params.functions)
		this.functions = params.functions;
	
	if(!!params.eventFunctions)
		this.eventFunctions = params.eventFunctions;
	
	VTemplate.prototype.addTextNode = function(element, text){
		var textNode = document.createTextNode(text);
		element.appendChild(textNode);
	};
	
	VTemplate.prototype.textNode = function(element, text){
		if(element.childNodes.length > 0){
			for(var i = 0; i < element.childNodes.length; i++)
				element.removeChild(element.childNodes[i]);
		}
		element.appendChild(document.createTextNode(text));
	};
	
	
	if (document.addEventListener) {
		
		VTemplate.prototype.addEvent = function(elem, type, handler) {
			elem.addEventListener(type, handler, false)
		}
		VTemplate.prototype.removeEvent = function(elem, type, handler) {
			elem.removeEventListener(type, handler, false)
		}
	}else{
		VTemplate.prototype.addEvent = function(elem, type, handler) {
			elem.attachEvent("on" + type, handler)
		}
		VTemplate.prototype.removeEvent = function(elem, type, handler) {
			elem.detachEvent("on" + type, handler)
		}
	}
	
	this.workElement = {};
	
	this.afterRender = params.afterRender || function(tempElements){
		
	};
	
	this.init = function(){
		var self = this;
		this.addEvent(window, 'load', function(){self.eventRender.call(self)});
	}
	
	VTemplate.prototype.eventRender = function(element){
		element = element || null;
		var self = this;
		if(element !== null){
			if(element.length === undefined)
				element = [element];
			var tempElements = element;
		}else{
			var tempElements = document.querySelectorAll('[data-vtemplate_' + self.tmpName + ']');
			if(tempElements.length == 0)
				return false;
		}
		var tmpSplit = [];
		var index = 'vtemplate_' + self.tmpName;
		var target = '';
		var targetVariable = '';
		for(var num = 0; num < tempElements.length; num++){
			dataValue = tempElements[num].dataset[index];
			tmpSplit = dataValue.split('=', 2);
			target = tmpSplit[0];
			targetVariable = tmpSplit[1];
			switch(target){
				case 'event'://event=click:order_click
					var fSplit = targetVariable.split(':', 2);
					if(typeof(self.eventFunctions[fSplit[1]]) != 'function'){
						console.log('function: "' + fSplit[1] + '" not set in ' + tempElements[num].outerHTML);
						continue;
					}
					self.addEvent(tempElements[num], fSplit[0], self.eventFunctions[fSplit[1]]);
					break;
			}
		}
		self.afterRender(tempElements);
	}
	
	VTemplate.prototype.render = function(data, element){
		element = element || null;
		var self = this;
		if(!!!data){
			console.log('data is not defined in template render function. template name: ' + self.tmpName);
			return false;
		}
		if(element !== null){
			if(element.length === undefined)
				element = [element];
			var tempElements = element;
		}else{
			var tempElements = document.querySelectorAll('[data-vtemplate_' + self.tmpName + ']');
			if(tempElements.length == 0)
				return false;
		}
		var tmpSplit = [];
		var dataValue = '';
		var index = 'vtemplate_' + self.tmpName;
		var target = '';
		var targetVariable = '';
		//console.log(tempElements);
		for(var num = 0; num < tempElements.length; num++){
			
			dataValue = tempElements[num].dataset[index];
			tmpSplit = dataValue.split('=', 2);
			target = tmpSplit[0];
			targetVariable = tmpSplit[1];
			if(target != 'function'){
				targetVariable = 'data.' + targetVariable;
				if(!!!eval(targetVariable))
					continue;
				targetVariable = eval(targetVariable);
			}
			
			switch(target){
				case 'text':
					self.textNode(tempElements[num], targetVariable);
					break;
				case 'value':
					tempElements[num].value = targetVariable;
					break;
				case 'src':
					tempElements[num].setAttribute('src', targetVariable);
					break;
				case 'function':
					var fSplit = targetVariable.split(':', 2);
					if(fSplit[1] == '*'){
						fSplit[1] = 'data';
					}else{
						fSplit[1] = 'data.' + fSplit[1];
					}
					if(!!!eval(fSplit[1]))
						continue;
					fSplit[1] = eval(fSplit[1]);
					if(typeof(self.functions[fSplit[0]]) != 'function'){
						console.log('function: "' + fSplit[0] + '" not set in ' + tempElements[num].outerHTML);
						continue;
					}
					self.workElement = tempElements[num];
					self.functions[fSplit[0]](fSplit[1]);
					break;
		}
		self.afterRender(tempElements);
	};
	}
	this.init();
}