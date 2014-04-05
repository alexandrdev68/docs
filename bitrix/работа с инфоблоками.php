
<?


//коррекция пейджинга в битрикс
$GLOBALS["NavNum"] = 0; //сбиваем постраничную навигацию, на нужную нам. Если нам нужен PAGEN_1, то пишем значение 0

//распарсивание елементов из текстового файла в массив и добавление их в инфоблок (menuavenue)
$streets = file_get_contents('streets.txt');


$str = explode('</option>', $streets);

foreach($str as $street){
	
	$pos = strpos($street, '>');
	//echo $pos.'<br />';
	
	//echo 'lenght = '.count($street).'<br />';
	$arRes[] = substr($street, ($pos+1), (strlen($street)-$pos));
	}
if(CModule::IncludeModule("iblock"))
		{ 						  
	$el = new CIBlockElement;
for($c = 0; $c<count($arRes); $c++){
	$arLoadProductArray = Array(
  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
  "IBLOCK_SECTION_ID" => 1279,          // элемент лежит в корне раздела
  "IBLOCK_ID"      => 12,
  "NAME"           => $arRes[$c],
  "ACTIVE"         => "Y",            // активен
  "PREVIEW_TEXT"   => "",
  "DETAIL_TEXT"    => ""
  );
  if($PRODUCT_ID = $el->Add($arLoadProductArray))
  echo "New ID: ".$PRODUCT_ID;
else
  echo "Error: ".$el->LAST_ERROR;
}
}
//print_r($arRes);
?>


<?
//осуществляет выборку всех допсвойств елемента и записывает в один массив
if(isset($_POST['custompie'])){ //в $_POST['custompie'] находится ID елемента
		$arToppings['custompie'] = CIBlockElement::GetByID($_POST['custompie'])->Fetch();
		$prop_top = CIBlockElement::GetProperty(2, $_POST['custompie'], Array(), Array());
		while($arRes[] = $prop_top->Fetch()){
		}
		array_pop($arRes);
		//записываем допсвойства в основной массив в поле PROPERTIES
		for($c=0; $c <= count($arRes)-1; $c++) $arToppings['PROPERTIES'][$arRes[$c]['CODE']] = $arRes[$c]['VALUE'];
?>


<?
//Вывод картинки
  $file = CFile::ResizeImageGet($arF["PREVIEW_PICTURE"], array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL, true, array());
  echo '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
 ?>
 
 <?//изменяет свойство инфоблока
 CIBlockElement::SetPropertyValues(
			 $ob1['ID'],//идентификатор элемента инфоблока
			 4,	//идентификатор инфоблока
			 $ob1["PROPERTY_AUTHOR_NAME_VALUE"],"AUTHOR_NAME");//"AUTHOR_NAME"-название изменяемого свойства
																//$ob1["PROPERTY_AUTHOR_NAME_VALUE"]-значение изменяемого свойства
 ?>
 
 
 <?//Добавление новых элементов инфоблока (на примере magsnov.ru)
 foreach($allauthors as $authors1=>$a){
			
			$el = new CIBlockElement;

			$PROP = array();
			$PROP["AGE"] ="";  
			$PROP["LIVE_PLACE"] = "";
			$PROP["AUTHOR_ENABLED"] = "N";
			
			$arLoadProductArray = Array(
			  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			  "IBLOCK_ID"      => 8,
			  "PROPERTY_VALUES"=> $PROP,
			  "NAME"           => $authors1,
			  "ACTIVE"         => "Y",            // активен
			  "PREVIEW_TEXT"   => "",
			  "DETAIL_TEXT"    => ""
			  );

			if($PRODUCT_ID = $el->Add($arLoadProductArray))
			  echo "New ID: ".$PRODUCT_ID;
			else
			  echo "Error: ".$el->LAST_ERROR;
			
		}
?>
 
<?// элементы инфоблоков
if(CModule::IncludeModule("iblock"))
{ 

	$arSelect = Array("ID", "NAME", "DETAIL_TEXT");
    $arFilter = Array(
    "IBLOCK_ID"=>"5",
    "ACTIVE"=>"Y"
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNext())
    {
		echo $ob["DETAIL_TEXT"];
	};
} 
?>
<?
	$res = CIBlock::GetByID("5");
	if($ar_res = $res->GetNext())
	  echo $ar_res['NAME'];
?>
<?
	header( "HTTP/1.1 301 Moved Permanently" ); 
	header( "Location: /kamery_sklady_boksy_dlya_hraneniya_veshhej/");
?>
<? // проверка на ошибку 404
$url = explode('/',$_SERVER['REQUEST_URI']);
$level = count($url)-1;

$garrinar = count($url); //Считаем количество переходов
if (!(is_array($url) && isset($url[$garrinar-1]) && ($url[$garrinar-1] == '') ) ) //проверяем или стоит в конце адреса "/", если нет, перевод на 404
{
	header("HTTP/1.0 404 Not Found", true);
	header("Status: 404 Not Found", true);
	header('Refresh:0 url = /404.php', true);
}

switch ($level){ //проверяем: существует ли элемент, если нет: 404
	case 3:
		if(CModule::IncludeModule("iblock")){
			
			$arFilter1 = Array('CODE' => $url[2]);
			$res1 = CIBlockSection::GetList(Array(), $arFilter1, false);
			while($ob = $res1->Fetch())
			{
			  $level8_id = $ob;
			};
			if (!is_array($level8_id)){
				header("HTTP/1.0 404 Not Found", true);
				header("Status: 404 Not Found", true);
				header('Refresh:0 url = /404.php', true);
			}
		};
	break;
	case 4:
	case 5:
		if(CModule::IncludeModule("iblock")){
			//echo $url[3]."************************************";
			$arFilter1 = Array('CODE' => $url[3]);
			$res1 = CIBlockSection::GetList(Array(), $arFilter1, false);
			while($ob = $res1->Fetch())
			{
			  $level4_id = $ob;
			};
			if (!is_array($level4_id) && ($url[2]!='akcii')){
				header("HTTP/1.0 404 Not Found", true);
				header("Status: 404 Not Found", true);
				header('Refresh:0 url = /404.php', true);
			}
		};
	break;
};
?>

<?# Флеш ролики с положением сзади всех обьектов?>
			<object width="600" height="400">
				<param name="movie" value="http://www.youtube.com/v/<?=$ob['PROPERTY_YOUTUBE_VALUE']?>?version=3&amp;hl=ru_RU&amp;rel=0"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="allowscriptaccess" value="always"></param>
				<param name="wmode" value="opaque"/>
				<embed src="http://www.youtube.com/v/<?=$ob['PROPERTY_YOUTUBE_VALUE']?>?version=3&amp;hl=ru_RU&amp;rel=0" type="application/x-shockwave-flash"  width="600" height="400" wmode="opaque" allowscriptaccess="always" allowfullscreen="true"></embed>
			</object>
			
<?# Галерея. Делаем из цветных фото чернобелые превью с наведением мышкой превращаются в цветные?>
<?php
	$url_sourse = '/images/small_foto/';
	$url_destin = '/images/double_foto/';
	
	if(CModule::IncludeModule("iblock"))
	{
		$arSelect = Array('NAME','PREVIEW_PICTURE','DETAIL_PICTURE');
		$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, false, $arSelect);
		while($ob = $res->Fetch())
		{
			$small_photos[] = $ob;
		};
		
		foreach ($small_photos as $item){
			$source[] = CFile::GetPath($item['PREVIEW_PICTURE']);
			$big_fotos[] = CFile::GetPath($item['DETAIL_PICTURE']);
		};
	
		foreach ($source as $item):
			$name = explode('/', $item);
			$destin = $_SERVER["DOCUMENT_ROOT"].$url_sourse.$name[4];
			$source_1 = $_SERVER["DOCUMENT_ROOT"].$item;
			CopyDirFiles($source_1, $destin);
				$file = file_get_contents($url_destin.$name[4], FILE_USE_INCLUDE_PATH); // перевірка чи існує файл
			
				// Create image instances
				$dest = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"].$url_sourse.$name[4]);
				$src = imagecreatefromjpeg($_SERVER["DOCUMENT_ROOT"].$url_sourse.$name[4]);
				// height and width our image
				$w = imagesx($src);
				$h = imagesy($src);
		
			if (!file_exists($_SERVER["DOCUMENT_ROOT"].$url_destin.$name[4])){
				$url_doub = $_SERVER["DOCUMENT_ROOT"].$url_destin.$name[4];
				imagefilter($src, IMG_FILTER_GRAYSCALE);
				$im  = imagecreatetruecolor($w, $h*2);
				// Copy and merge
				imagecopymerge($im, $src, 0, 0, 0, 0, $w, $h, 100);
				imagecopymerge($im, $dest, 0, $h, 0, 0, $w, $h, 100);

				// Output and free from memory
				imagejpeg($im, $url_doub);
				imagedestroy($im);
				imagedestroy($dest);
				imagedestroy($src);
			};
		endforeach;
	};
?>
<!-- Работа с JQuery AJAX -->
<script type="text/javascript">
				$('#order_form').submit(function(e){
					e.preventDefault();
					//var query = $(this).get();
					 $.ajax({
					   url: "order_ajax.php",
					   data: "id="+$("#p_id").val(),
					   success: function(html){
							//$("#results").append(html);
							alert(html);
					   }				
					 });
				});
</script>

<script type="text/javascript">
$('#add_album_form').submit(function(e){ //Добавление альбома
				e.preventDefault();
				$(this).ajaxSubmit({
					url: "/<?=$arResult['c_path']?>a.php",
					type: "POST",
					dataType: "text",
					success: function(html){
						alert(html);
						window.location.href=window.location.href;
					}				
				});
			});
</script>