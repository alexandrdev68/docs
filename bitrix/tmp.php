<?# ******** PAGINATION *********
$page=$_GET['PAGEN_1']-1;
if(!isset($_GET['PAGEN_1'])) $page = 0;
$per_page = $arParams['PAGE_ELEMENT_COUNT']-1; //количество элементов на странице
$page_num = $page*$per_page;
$count_pages=0;
$arFilter123 = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ID'=>$arParams['SECTION_ID'], 'GLOBAL_ACTIVE'=>'Y');
$db_list123 = CIBlockSection::GetList(Array(), $arFilter123, true, array('UF_*'));
if ($ar_result123 = $db_list123->GetNext());

$arSelect = Array("*");
$arFilter = Array(
	"IBLOCK_ID"		=> $arParams['IBLOCK_ID'],
	"SECTION_ID" 	=> $arParams['SECTION_ID'],
	"ACTIVE"		=> "Y"
	);

$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	$arResult['ITEMS'][] = $ob;
	$ar_res[$count_pages] = $ob;
	$count_pages++;
}
	if($count_pages > $per_page):?>
		<div class="change_page">
			<ul>
			<?
			for ($i=1; $i<=ceil($count_pages / $per_page); $i++)
			{
			?>
				<?if($page+1!=$i):?>
					<li><a href="?PAGEN_1=<?=$i?>"><?=$i?></a></li>
				<?elseif($_GET['PAGEN_1']!=ceil($count_pages / $per_page)):?>
					<li><b><?=$i?></b></li>
				<?else:?>
					<li class="last"><b><?=$i?></b></li>
				<?endif?>
				
				<?if($i==ceil($count_pages / $per_page) and $_GET['PAGEN_1']!=$i):?>
					<li class="last"><a href="?PAGEN_1=<?=$_GET['PAGEN_1']+1?>">Следующая</a></li>
				<?endif?>
			<?
			}
			?>
			</ul>
		</div>
	<?endif?>
<?# ******** /PAGINATION *********?>