<?php


/*Функция возвращает навигационную цепочку
входные параметры: $curr_page - текущая страница; $pages - всего страниц; $len - длина вывода цепочки (>=6)
возвращает индексный массив, где значениями являются номера страниц и:-
"curr" - означает, что страница является текущей;
"pred" - кнопка "Предыдущая страница";
"next"- кнопка "Следующая страница";
"all" - кнопка "Вывести все";
"first" - обычно выводится как троеточие вначале цепочки;
"last" - обычно выводится как троеточие в конце цепочки.

индекс "current" - номер текущей страницы
*/
function build_page($curr_page, $pages, $len){
	//длинна цепочки не может быть меньше 6
	if($len < 6) return false;
	if($pages <= $len){
		$index = 1;
		if($curr_page > 1){
		$result[$index] = 'pred';
		$index++;
		}
		for($c = 1; $c <= $pages; $c++){
			if($c == $curr_page){
				$result[$index] = 'curr';
				$index++;
			}else{
				$result[$index] = $c;
				$index++;
			}
		}
		if($curr_page < $pages){
			$result[$index] = 'next';
			$index++;
		}
		$index++; $result[$index] = "all";
	}elseif($pages > $len){
		$index = 1;
		$val = 1;
		if($curr_page > 1){
			$result[$index] = 'pred';
			$index++;
		}
		if($curr_page == $val){
			$result[$index] = "curr";
			$index++; $val++;
		}
		$result[$index] = $val;
		$index++; $val++;
		if($curr_page <= ceil(($len-1)/2)){
			//текущая страница в первой половине видимости
			for($c = 1; $c<=($len-2); $c++){
				if($curr_page == $val){
					$result[$index] = "curr";
					$index++; $val++;
				}
				$result[$index] = $val;
				$index++; $val++;
			}
			$result[$index] = "last";
			$index++;
			$result[$index] = $pages; $index++;
			if($curr_page < $pages)	$result[$index] = "next";
			$index++; $result[$index] = "all";
			$result['current'] = $curr_page; return $result;
			break;
		}else{
			//текущая страница за пределами видимости
			$result[$index] = "first";
			$index++;
			$val = $pages-$len+1;
			if(($curr_page+ceil(($len-1)/2)) > $pages){
				for($c = $val; $c< $pages; $c++){
					if($curr_page == $val){
						$result[$index] = "curr";
						$index++; $val++;
					}
					$result[$index] = $val;
					$index++; $val++;
					if($curr_page < $pages)	$result[$index] = "next"; else $result[$index] = "curr";
				}
			}else{
			$val = $curr_page - ($len-4)/2;
			for($c = 1; $c<=($len-4); $c++){
					if($curr_page == $val){
						$result[$index] = "curr";
						$index++; $val++;
					}
					$result[$index] = $val;
					$index++; $val++;
				}
			$result[$index] = "last";
			$index++;
			$result[$index] = $pages; $index++;
			if($curr_page < $pages)	$result[$index] = "next";
			}
		}
		}
	$index++;
	$result[$index] = 'all';
	$result['current'] = $curr_page;
	return $result;
};

/*-----------------------------------------------------------------------------------------*/

//функция генерации пароля возвращает 4 варианта пароля в индексном массиве
function passwGen($count){
       $tmpArr = Array();
       for($i=1; $i<=$count*2; $i++){
               switch(rand(0,2)){
                       case 0:$val = rand(48, 57);
                       break;
                       case 1:$val = rand(65, 90);
                       break;
                       case 2:$val = rand(97, 122);
                       break;
               };
               $tmpArr[$i] = chr($val);
       };
       for($i=1; $i<=$count; $i++){
               $tmpArr['string'] .= $tmpArr[rand(1,$count)];
               $tmpArr['string1'] .= $tmpArr[($i*2)];
               $tmpArr['string2'] .= $tmpArr[($i+$count)];
               $tmpArr['string3'] .= $tmpArr[$i];

       };
       $res[] = $tmpArr['string'];$res[] = $tmpArr['string1'];$res[] =
$tmpArr['string2'];$res[] = $tmpArr['string3'];
       return $res;
};

/*-----------------------------------------------------------------------------------------*/

//Преобразовывает данные выбранные из БД к 3-х мерному индексному массиву
	function db2Array($data){
		$arr = array();
		while($row = mysql_fetch_assoc($data)){
			$arr[] = $row;
		}
		return $arr;
	}
	
/*-----------------------------------------------------------------------------------------*/
	
//Фильтрует данные переданные через поля ввода на предмет тэгов и пробелов, числа преобразует к целому
	function dataFilter($data, $i='s'){
		if($i=='s'){
			return trim(stripslashes(strip_tags($data)));
		} elseif($i=='i'){
			return (int)$data;
		}
			
	};


/*-----------------------------------------------------------------------------------------*/
	
	//склонение слова в зависимости от числа
function declension($value, $arDeclens){	//$value-число; $arDeclens - массив склонений типа [значение]=>['склонение']
											//[0]=>стандартное склонение, под другими значениями принимаються исключения (числа от 10 до 20 выводятся как стандарт)
	if($value>20){
		$ak = fmod($value, 10);
	}else{
		$ak = fmod($value, 100);
	};
	foreach($arDeclens as $index=>$decl){
		if($ak == $index){
			return $decl;
			break;
		};
	};
	return $arDeclens[0];
};

/*
Пример вызова функции declension:

$arDeclens = Array(
					0=>'секунд',
					1=>'секунда',
					2=>'секунди',
					3=>'секунди',
					4=>'секунди',
					
				);
 for ($i = 0; $i <= 500; $i++){ 
	echo "<pre>";
	echo $i." - ".declension($i, $arDeclens);
	echo "</pre>";
}
*/

/*-----------------------------------------------------------------------------------------*/

//Функция сортирует массив вида {array(0=>array('price=>1200', 'looop'=>'...',...),...)} по полю 'price' (если $direct = true в возрастающем порядке, иначе по убыванию)
function item_sort($prod, $direct){
	$akk = array();//массив для хранения промежуточных значений
	for($c = 0; $c < count($prod); $c++){
		$akk[0] = (int)$prod[$c]['price'];
		$findtiny = false;//триггер нахождения самого маленького числа в массиве (true, если найдено, по умолчанию - false)
		for($i=$c;$i < count($prod);$i++){
			$akk[2] = (int)$prod[$i]['price'];
			if($direct){ //если по возрастанию то...
				if($akk[2] < $akk[0]){
					$findtiny = true;
					$akk[0] = $akk[2];
					$akk[1] = $i;
				};
			}else{ //по убыванию...
				if($akk[2] > $akk[0]){
					$findtiny = true;
					$akk[0] = $akk[2];
					$akk[1] = $i;
				};
			}
		};
		if($findtiny){
			$a1 = $akk[1];
			$akk[3] = $prod[$c];
			$prod[$c] = $prod[$a1];
			$prod[$a1] = $akk[3];
		}
	};
	return $prod;
};

/*-----------------------------------------------------------------------------------------*/

//вытаскивает значения после ? в строчке url (для замены GET)
function myGet_id($myurl){
		$npos = strpos($myurl,'?');
		$length = strlen($myurl)-$npos;
		$myurl = substr($myurl, $npos+1, $length);
		$myval = array();
		$npos = strpos($myurl,'=');
		$a1 = substr($myurl, 0, $npos);
		$length = strlen($myurl)-$npos+1;
		$myval[$a1] = substr($myurl, $npos+1, $length);
		return $myval;// возвращает индексный массив типа "индекс"=>"значение"
};// строку /goods/posuda/?id=12 вернет "id"=>12

/*-----------------------------------------------------------------------------------------*/
?>

<?
//Функция делает выборку из базы данных и возвращает результат в виде массива
function get_list($query){
	$result = mysql_query($query);
	while($arResult[] = mysql_fetch_array($result, MYSQL_ASSOC)){
		
	};
	array_pop($arResult);
	return $arResult;
}

/*-----------------------------------------------------------------------------------------*/

//функция для извлечения определенных элементов массива, указанных в параметре($arGet - искомые значения в массиве $arSource)
function get_elements_array($arGet, $arSource){
	$arReturn = array();
	foreach($arSource as $source){
		foreach($arGet as $value){
			if(in_array($value, $source)) $arReturn[] = $source;
		}
	}
	return $arReturn;
};

/*-----------------------------------------------------------------------------------------*/

//вставляет внутрь массива другой массив со смещением ключей
//$array - массив куда надо вставить, $pos - номер позиции, $value - вставляемое значение
    public function insert_in_array($array, $pos, $value){
         array_splice($array, $pos, 0, $value);
         return $array;
    }
    
/*-----------------------------------------------------------------------------------------*/
?>

<script>
//Функция для форматирования числа к "бухгалтерскому" виду 1 223 45.98 вместо 122345.98
numberFormat : function(number){
		number = number.toString();
		if(!/(^[0-9]{1,}[\.\,]{0,1}[0-9]{0,}$)/.test(number)) return false;
		number = number.split(',').join('.');
		var arNum = number.split('.');
		var numLen = arNum[0].length;
		if(numLen <= 3) return number;
		var numFormatted = [];
		var sep = 3;
		var inc = Math.ceil(numLen / 3 - 1);
		var g = numLen - 1 + inc;
		for(var i = g; i >= 0; i--){
			numFormatted[g] = arNum[0][i - inc];
			sep--;
			if(sep == 0){
				g--;
				numFormatted[g] = ' ';
				sep = 3;
			}
			g--;
		}
		numFormatted = numFormatted.join('');
		return numFormatted += arNum.length == 1 ? '' : '.' + arNum[1]; 
	}
</script>
<?
//возвращает количество времени мжду датами в виде ассоциативного массива (смотри код)
static protected function GetTimeBetween($date1 , $date2){
		date_default_timezone_set('Europe/London');
		$datetime1 = new DateTime(date('d-m-Y H:i:s', $date1));
		$datetime2 = new DateTime(date('d-m-Y H:i:s', $date2));
		$interval = $datetime1->diff($datetime2); 
		$arRet['days'] = $interval->format('%d');
		$arRet['hours'] = $interval->format('%H');
		$arRet['minutes'] = $interval->format('%i');
		$arRet['seconds'] = $interval->format('%s');
		return $arRet;
	}
?>