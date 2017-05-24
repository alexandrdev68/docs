Pbank.
	
var MyDate = {
		Lang : {ru : [
				'января',
				'февраля',
				'марта',
				'апреля',
				'мая',
				'июня',
				'июля',
				'августа',
				'сентября',
				'октября',
				'ноября',
				'декабря'
		        ],
		        ua : [
		              
		              ]
		},
		getDateString : function(date, divider, getArray, needTime){
			needTime = (needTime === undefined ? true : needTime);
			getArray = (getArray === undefined ? false : getArray);
			var time = '';
			var month = date.getUTCMonth() + 1;
			var day = date.getUTCDate();
			var year = date.getUTCFullYear();
			var monthWord = MyDate.Lang['ru'][month];
			if(needTime) time = MyDate.getTimeString(date, ':', false);
			if(getArray === true){
				return new Array((day < 10 ? '0' + day : day), (month < 10 ? '0' + month : month), String(year), time, monthWord);
			}else return (day < 10 ? '0' + day : day) + divider + (monthWord) + divider  + year + time;
		},
		getTimeString : function(date, divider, needDays){
			needDays = (needDays === undefined ? true : needDays);
			var days = 0;
			if(needDays === true){
				days = MyDate.getDays(date.getTime());
			}
			var hours = date.getUTCHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();
			return (days == 0 ? ' ' : days + ' д. ') + hours + divider + (minutes < 10 ? '0' + minutes : minutes) + divider + (seconds < 10 ? '0' + seconds : seconds);
		},
		getDays : function(difference){
			return Math.floor(difference / (1000 * 60 * 60 * 24));
		}
}


var inArray = function(arraySource, find){
	if(typeof(arraySource) != 'object') return false;
	if(typeof(find) == 'object'){
		for(var num = 0; num < arraySource.length; num++){
			for(var fnum = 0; fnum < find.length; fnum++){
				if(arraySource[num] === find[fnum]) return num;
			}
		}
		return -1;
	}else if(typeof(find) == 'string' || typeof(find) == 'number'){
		for(var num = 0; num < arraySource.length; num++){
			if(arraySource[num] === find) return num;
		}
		return -1;
	}else return false;
}




var toType = function(type, value){
		switch(type){
		case 'string' :
			return String(value);
			break;
		case 'integer' :
			return parseInt(value);
			break;
		case 'float' :
			return parseFloat(value);
			break;
		case 'strToArray':
			return value.split(',');
			break;
		case 'strToArrayFloat':
			var tmp = value.split(',');
			for(var num = 0; num < tmp.length; num++){
				tmp[num] = toType('float', tmp[num]);
			}
			return tmp;
			break;
		default:
			return value;
		}
	};
	
	//обект, помогающий облегчить валидацию полей
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
    
    /*Функция возвращает навигационную цепочку
     входные параметры: curr_page - текущая страница; pages - всего страниц; len - длина вывода цепочки (>=6)
     возвращает индексный массив, где значениями являются номера страниц и:-
     "curr" - означает, что страница является текущей;
     "pred" - кнопка "Предыдущая страница";
     "next"- кнопка "Следующая страница";
     "all" - кнопка "Вывести все";
     "first" - обычно выводится как троеточие вначале цепочки;
     "last" - обычно выводится как троеточие в конце цепочки.

     индекс "current" - номер текущей страницы
     */
    function build_page(curr_page, pages, len) {
        let index;
        let val;
        let result = [];
        curr_page = parseInt(curr_page);
        pages = parseInt(pages);
        len = parseInt(len);
        //длинна цепочки не может быть меньше 6
        if (len < 6) return false;
        if (pages <= len) {
            index = 0;
            if (curr_page > 1) {
                result[index] = 'pred';
                index++;
            }
            for (let c = 1; c <= pages; c++) {
                if (c == curr_page) {
                    result[index] = 'curr';
                    index++;
                } else {
                    result[index] = c;
                    index++;
                }
            }
            if (curr_page < pages) {
                result[index] = 'next';
                index++;
            }
            index++;
            result[index] = "all";
        } else if (pages > len) {
            index = 0;
            val = 1;
            if (curr_page > 1) {
                result[index] = 'pred';
                index++;
            }
            if (curr_page == val) {
                result[index] = "curr";
                index++;
                val++;
            }
            result[index] = val;
            index++;
            val++;
            if (curr_page <= Math.ceil((len - 1) / 2)) {
                //текущая страница в первой половине видимости
                for (let c = 1; c <= (len - 2); c++) {
                    if (curr_page == val) {
                        result[index] = "curr";
                        index++;
                        val++;
                    }
                    result[index] = val;
                    index++;
                    val++;
                }
                result[index] = "last";
                index++;
                result[index] = pages;
                index++;
                if (curr_page < pages) result[index] = "next";
                index++;
                result[index] = "all";
                result['current'] = curr_page;
                return result;

            } else {
                //текущая страница за пределами видимости
                result[index] = "first";
                index++;
                val = pages - (len + 1);
                if ((curr_page + Math.ceil((len - 1) / 2)) > pages) {
                    for (let c1 = val; c1 < pages; c1++) {
                        if (curr_page == val) {
                            result[index] = "curr";
                            index++;
                            val++;
                        }
                        result[index] = val;
                        index++;
                        val++;
                        if (curr_page < pages) result[index] = "next"; else result[index] = "curr";
                    }
                } else {
                    val = curr_page - (len - 4) / 2;
                    for (let c = 1; c <= (len - 4); c++) {
                        if (curr_page == val) {
                            result[index] = "curr";
                            index++;
                            val++;
                        }
                        result[index] = val;
                        index++;
                        val++;
                    }
                    result[index] = "last";
                    index++;
                    result[index] = pages;
                    index++;
                    if (curr_page < pages) result[index] = "next";
                }
            }
        }
        index++;
        result[index] = 'all';
        result['current'] = curr_page;
        return result;
    }