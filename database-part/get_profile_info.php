<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['id'])
   ) 
{
    
	$id = $_GET['id'];
	
    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

	$cur_unix = strtotime(date('Y-m-d H:i:s'));

    // mysql inserting a new row
    $info_r = mysql_query(" SELECT * from users WHERE id = '$id' ");
	
	if (mysql_num_rows($info_r) > 0) 
	{
		while ($response = mysql_fetch_array($info_r)) 
		{
			$response["success"] = 1;
			$response["message"] = "Success";
			echo json_encode($response);
		}
	}
	
} 
else 
{
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>