<?php
	//пример запроса к БД в joomla
	$db = JFactory::getDbo();
 
	// Create a new query object.
	$query = $db->getQuery(true);
	$query
	    ->select('*')
	    ->from($db->quoteName('u5ghb_user_profiles', 'u5ghb_user_keys'));
		/*->where($db->quoteName('b.username') . ' LIKE \'root\'')
	    ->order($db->quoteName('a.created') . ' DESC')*/
	    
	$db->setQuery($query);
	
	$results = $db->loadObjectList();
	print_r($results); exit;
?>