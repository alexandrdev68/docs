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
            if($curr_page < $pages)    $result[$index] = "next";
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
                    if($curr_page < $pages)    $result[$index] = "next"; else $result[$index] = "curr";
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
            if($curr_page < $pages)    $result[$index] = "next";
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
function declension($value, $arDeclens){    //$value-число; $arDeclens - массив склонений типа [значение]=>['склонение']
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
?>
<script>
//то же для javascript
	Pbank.declension = function(params){
		params = params  || {};
		this.declensions = params.declensions || {};
		
		Pbank.declension.prototype.getWord = function(num){
			var ak;
			if(num > 20){
				ak = num % 10;
			}else{
				ak = num % 100;
			}
			for(var n in this.declensions){
				if(n == ak){
					return this.declensions[n];
				}
				return this.declensions[0];
			}
		}
	}
</script>
<?
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

//недоделанный класс для обращения к ПТКС из яваскрипт
<script>
function queryPTKS(params){
    params = params || {};
    this.type = params.type || 'POST';
    this.query = params.query || '';
    this.params = params.params || {};
    this.queryString = '';
    this.init = function(){
        this.queryString = queryPTKS.getQueryString(this.params);
    };
    this.go = function(){
        var obj = this;
        $.ajax({
            url: 'wwxwx',
            type: obj.type,
            data: obj.queryString,
            dataType: 'json',
            success: function(response) {
            if(response.status == 'ok' || response.status == 'wallet-info' || response.status == 'approve-group-by-accountant'){
                ajax_complete_handler();
                funct(response);
            }else if(response.status !== undefined && response.status == 'bad'){
                message.show(response.details !== undefined ? response.details.message : response.message, 3000);
                setTimeout('ajax_complete_handler', 1000);
            }else{
                ajax_complete_handler();
                error(response);
            }
            },
            error: function(response){
                
            }
        });
    };
    
    queryPTKS.prototype.getQueryString = function(query){
        query = query || this.params;
        var qstr = '?';
        for(var i in query){
            qstr += i + '=' + query[i] + '&';
        }
        return qstr.substr(0, (qstr.length - 1));
    }
}
</script>

/*очень полезный класс для работы с табличными данными
в качестве параметров указываются названия переменных и их подпись в заголовке таблицы лучше посмотреть на примере:
<script>
example = new tableFromData({
        head : {
            walletId : 'Номер кошелька',
            amount : 'Сумма начисления',
            commission : 'Комиссия',
            closed : 'Дата пополнения',
            comment : 'Комментарий',
            id : '<input type="checkbox" name="selectReportBike">'
        },
        content : {
			id : '<input type="checkbox" data-id="#$#" name="selectReportBike">' //#$# - сюда подставится переменная
		},
        classes : 'report_table _reportTable',
        counter : true
    });
</script>
вызов наполнения свойства table:
example.fill(data);
где data = массив объектов вида [ {‘walletId’ : 2342424234, ‘amount’ : 23444, ‘commission’ : 100}, {‘walletId’ : 2342424234, ‘amount’ : 23444, ‘commission’ : 100}]
после остается только вставить html:
$(‘.tableContainer’).html(example.table);

classes - названия классов в теге <table>

counter - если true, будет первая колонка с номерами рядов
*/
<script>
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
    this.cellTemp = '';
    
    this.fill = function(data){
        data = data || {};
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
                	this.cellTemp = this.content[v].split('#$#');
                	this.cellTemp = this.cellTemp[0] + 
                					(data[d][v] === undefined ? '' : data[d][v]) + 
                					this.cellTemp[1];
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
    
    tableFromData.createHead = function(me){
        me.table = '<table class="' + me.classes + '"><tbody><tr>';
        if(me.counter) me.table += '<th>№</th>';
        for(var v in me.head){
            me.table += '<th>' + me.head[v] + '</th>';
        }
        me.table += '</tr>'
    };
}


//класс для работы с сообщениями в бутстрапе
function cMessage(template){
    
    template.header = template.header || 'оплата';
    template.text = template.text || 'some text';
    template.button_text = template.button_text || 'ok';
    template.id = template.id || 'gm-transfer-modal-success';
    template.tclass = template.tclass || 'modal gm-modal hide';
    template.container = template.container || '#gm-container';
    template.type = template.type || 'success';
    
    this.container = $(template.container);
    
    this.temp_id = template.id;
    
    this.body = '<div id="' + template.id + '" class="' + template.tclass +
                '" tabindex="-1" role="dialog" aria-labelledby="gm-payment-modal-label" aria-hidden="true">' +
                '<div class="modal-header">' +
                '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>' +
                '<h3 id="gm-payment-modal-label">' + template.header + '</h3>' + '</div>' +
                '<div class="modal-body' + (template.type == '' ? '' : ' gm-modal-body-' + template.type + '">') +
                '<p class="gm-modal-status">' + template.text + '</p></div>' +
                '<div class="modal-footer gm-modal-footer">' +
                '<button class="btn " data-dismiss="modal" aria-hidden="true">' + template.button_text + '</button></div></div>';
    
    cMessage.init = function(self){
        if(document.getElementById(self.temp_id) !== null){
            console.log('element with id #' + self.temp_id + ' was created on this page');
            return false;
        }
        $(self.body).prependTo(self.container);
    };
    
    this.show = function(text){
        self  = this;
        if(text !== null){
            $('#' + self.temp_id + ' p').text(text);
        }
        $('#' + self.temp_id).modal('show');
    };
    
    this.hide = function(){
        $('#' + self.temp_id).modal('hide');
    };
    
    cMessage.init(this);
}
</script>

Пример использования функции сообщений:
<script>
var myMessage = new cMessage({
        header : 'Оплата',
        id : 'gm-transfer-modal-success', //id - шка сообщения (по ней мы его вызываем если сообщение с таким id уже было создано - выводится сообщение в консоль и выполнение прерывается)
        button_text : 'OK',
        tclass : 'modal gm-modal hide', //bootsrap - овский класс (определяет как появляется)
        text : 'Оплата прошла успешно',
        container : '#gm-container', //куда пихаем HTML
        type : 'success' //тип сообщения (success, error)
    });
</script>
можно задавать только какой-то один параметр, остальные будут заданы по умолчанию:
<script>
var myMessage = new cMessage({
        id : 'gm-transfer-modal-success',
        header : 'Оплата',
        text : 'Оплата прошла успешно'
    });
</script>
вызов сообщения:

myMessage.show(); или так:

myMessage.show('другое сообщение');


прячем сообщение принудительно:

myMessage.hide()

//Функция центрирования елемента страницы по центру относительно документа
<script>
function toCenter(element){
    if(element instanceof Object) {
        var elPosX = ($(document).width() + $(document).scrollLeft()) / 2 - $(element).width() / 2;
        var elPosY = ($(document).height() + $(document).scrollTop()) / 2 - $(element).height() / 2;
        $(element).css({top : elPosY, left : elPosX});
    };
};
</script>

//Полезные регулярки
<script>
var regPseudonim = {
        wallid : '^[0-9]{14,14}$',
        text128 : '[a-zA-Z0-9а-яА-ЯїЇґҐ,\\\'\"\;\:\.єЄ?!@#\$%\^\&\*\(\)/]{0,128}',
        amount : '^([0-9]{1,})$|^[0-9]{1,}[.,](?:[0-9]{1,2})$',
    mail:’^[a-zA-Z0-9][-._a-zA-Z0-9]+@(?:[-a-zA-Z0-9]+\.)+[a-zA-Z]{2,6}$’
};
//Замена запятой на точку в js
number = number.split(',').join('.');
</script>



//Функция формирует строку xml-вида из переданного ей массива (рекурсивная функция)
пример: 
<?
$arFields = array('param'=>array(
                              'login'=>'GM',
                              'function'=>'GMDebtQuery',
                              'request'=>array(
                                'ClientsShipmentRef'=>'000001'
                              ),
                              'request_id'=>'',
                              'wait'=>1,
                              'sign'=>'signature'
                            )
                        ));

$this->stringXML = '<?xml version="1.0" encoding="UTF-8"?>';
$this->stringXML = $this->parseFields($arFields, $this->stringXML);


function parseFields($arInline, $stringXML = ''){
      
    foreach($arInline as $fieldName=>$fieldValue){
    if(is_array($fieldValue)){
      $stringXML .= '<'.$fieldName.'>'.$this->parseFields($fieldValue).'</'.$fieldName.'>';
    }else{
      $stringXML .= '<'.$fieldName.'>'.$fieldValue.'</'.$fieldName.'>';
    }
    }
    return $stringXML;
  }
?>