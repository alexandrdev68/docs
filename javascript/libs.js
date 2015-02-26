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