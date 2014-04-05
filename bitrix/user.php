
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

$user = new CUser;
$fields = Array(
  "GROUP_ID"          => array(1),
  );
$user->Update(1, $fields);

$rsUser = CUser::GetByID(1);
$arUser = $rsUser->Fetch();
echo "<pre>"; print_r($arUser); echo $c."</pre>";


?>