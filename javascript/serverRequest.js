/**
 * function - constructor for ajax requests used jquery lib
 */
function serverRequest(params){
	params = params || {};
    this.type = params.type || 'POST';
    this.events = params.events || 'on';
    this.url = params.url || window.location.href;
    this.query = params.query || '';
    this.data = params.data || '';
    if(params.traditional !== undefined) this.traditional = params.traditional;
    else this.traditional = false;
    if(params.queryDataFormat !== undefined) this.queryDataFormat = params.queryDataFormat;
    else this.queryDataFormat = 'url';
    if(params.processData !== undefined) this.processData = params.processData;
    else this.processData = false;
    this.need_auth = (params.need_auth !== undefined ? params.need_auth : false);
    if(params.contentType !== undefined) this.contentType = params.contentType;
    else this.contentType = false;
    
    this.success = function(response){
		//some functional here
    };
    
    if(params.success !== undefined) this.success = params.success;
    
    
    this.error = function(response){
    	//ajax error handler
		
    	console.log('Error on server, try again later');
    };
    
    if(params.error !== undefined) this.error = params.error;
    
    
    
    this.send = function(sparams){
        var self = this;
        sparams = sparams || {};
        if(sparams.type !== undefined) self.type = sparams.type;
        if(sparams.events !== undefined) self.events = sparams.events;
        if(sparams.url !== undefined) self.url = sparams.url;
        if(sparams.data !== undefined) self.data = sparams.data;
        if(sparams.query !== undefined) self.query = sparams.query;
        if(sparams.error !== undefined) self.error = sparams.error;
        if(sparams.success !== undefined) self.success = sparams.success;
        if(sparams.contentType !== undefined) self.contentType = sparams.contentType;
        if((this.queryDataFormat == 'json' || this.queryDataFormat == 'JSON') && self.data !== '') self.data = $.toJSON(self.data);
        var ajax_params = {
    		url: self.url + self.query,
            type: self.type,
            data: self.data,
            dataType : 'json',
            processData : true,
            success: function(response) {
            	self.success(response);
            },
            error: function(response){
            	self.error(response);
            }
        };
        
        if(this.contentType !== false) ajax_params.contentType = this.contentType;
        
        jQuery.ajax(ajax_params);
    };

};