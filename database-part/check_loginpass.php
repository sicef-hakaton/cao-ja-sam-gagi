<?php

// array for JSON response
$response = array();


// include db connect class
require_once dirname(__FILE__) . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// check for post data
if (isset($_GET["email"]) && isset($_GET["password"])) 
{
    $email = $_GET['email'];
	$password = $_GET['password'];

	$result = mysql_query("SELECT *FROM users WHERE email = '$email' AND password = '$password'");
	if (!empty($result)) 
	{
        // check for empty result
        if (mysql_num_rows($result) > 0) 
		{ 
			$row = mysql_fetch_array($result);
			$response["id"] = $row["id"];
            $response["success"] = 1;
			$response["message"] = "Success";
            echo json_encode($response);
        } 
		else 
		{
            $response["success"] = 1;
			$response["message"] = "Invalid combination.";
            echo json_encode($response);
        }
    } 
	else 
	{
            $response["success"] = 1;
			$response["message"] = "Invalid combination.";
            echo json_encode($response);
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