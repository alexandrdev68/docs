/*Return table from JSON data
 * Example:
 * discovery_payments = new tableFromData({
		head : {uttn : "Номер ТТН",
			date_begin : "Дата проведення платежу",
			status : "Статус",
			properties : 'Дані платежу',
			id : '',
			id : ''
		},
		content : {
			id : '<span class="_href _id_info _to_delete" data-delete_id="#$#">delete</span>',
			properties : '<small data-id="#id#" data-vtemplate_me_reports="function=set_tree_from_response:*"></small>'
		},
		classes : 'table table-striped _discoveryList discovery_payments',
		counter : true
	});
	
	#$# - inserting current variable
	#anyvariable# - inserting any variable set in data
	
	discovery_payments.fill(data);
	$('._discovery_payments_container').html(discovery_payments.table);
 */

function tableFromData(params){
    params = params || {};
    if(params.head !== undefined) this.head = params.head;
    if(params.content !== undefined) this.content = params.content;
    else this.content = {};
    if(params.classes !== undefined) this.classes = params.classes;
    else this.classes = '';
    this.counter = false;
    if(params.counter !== undefined) this.counter = params.counter;
    this.rowNum = 0;
    this.table = '';
    this.row = '';
    this.cellTemp = '';
    this.data = [];
    
    this.fill = function(data){
        data = data || {};
        this.data = data;
        this.table = '';
        if(data.length == 0) return false;
        tableFromData.createHead(this);
        for(var d in data){
            this.table += '<tr>';
            if(this.counter){
                this.rowNum++;
                this.table += '<td>' + this.rowNum + '</td>';
            }
            for(var v in this.head){
                if(!!this.content[v]){
                	this.cellTemp = this.content[v].split('#');
	                	if(this.cellTemp.length > 1){
	                		if(this.cellTemp[1] == '$'){
	                			this.cellTemp = this.cellTemp[0] + 
	                					(data[d][v] === undefined ? '' : data[d][v]) + 
	                					this.cellTemp[2];
	                		}else{
	                			this.cellTemp = this.cellTemp[0] + 
            					(data[d][this.cellTemp[1]] === undefined ? '' : data[d][this.cellTemp[1]]) + 
            					this.cellTemp[2];
	                		}
                	}
                }else{
                	this.cellTemp = (data[d][v] === undefined ? '' : data[d][v]);
                }
            	this.table += '<td>' + this.cellTemp + '</td>';
            }
            this.table += '</tr>';
        }
        this.table += '</tbody></table>';
        this.rowNum = 0;
    };
    
    this.getRow = function(rowData){
    	rowData = rowData || {};
    	this.row = '';
		this.row += '<tr>';
		if(this.counter){
            this.rowNum++;
            this.row += '<td>' + this.rowNum + '</td>';
        }
		for(var v in this.head){
            if(!!this.content[v]){
            	this.cellTemp = this.content[v].split('#');
            	if(this.cellTemp.length > 1){
            		if(this.cellTemp[1] == '$'){
            			this.cellTemp = this.cellTemp[0] + 
            					(data[d][v] === undefined ? '' : data[d][v]) + 
            					this.cellTemp[2];
            		}else{
            			this.cellTemp = this.cellTemp[0] + 
    					(data[d][this.cellTemp[1]] === undefined ? '' : data[d][this.cellTemp[1]]) + 
    					this.cellTemp[2];
            		}
            	}
            }else{
            	this.cellTemp = (rowData[v] === undefined ? '' : rowData[v]);
            }
        	this.row += '<td>' + this.cellTemp + '</td>';
        }
        this.row += '</tr>';
    };
    
    tableFromData.createHead = function(me){
        me.table = '<table class="' + me.classes + '"><tbody><tr>';
        if(me.counter) me.table += '<th>№</th>';
        for(var v in me.head){
            me.table += '<th>' + me.head[v] + '</th>';
        }
        me.table += '</tr>'
    };
};