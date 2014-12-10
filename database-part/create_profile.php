<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['email']) && isset($_GET['password']) && isset($_GET['password2']) && isset($_GET['first_name']) &&
		isset($_GET['last_name'])
   ) 
{
    
    $email= $_GET['email'];
    $password = $_GET['password'];
    $password2 = $_GET['password2'];
    $first_name = $_GET['first_name'];
    $last_name = $_GET['last_name'];

    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
	
	//check  password = password2
	if( strcmp($password, $password2) != 0 )
	{
            $response["success"] = 1;
            $response["message"] =  "Passwords differ.";
            echo json_encode($response);
			die();
    }
	
	//check password, email empty
	if ( strlen($password) == 0 or strlen($email) == 0 )
	{
            $response["success"] = 1;
            $response["message"] =  "Password and email should not be empty.";
            echo json_encode($response);
			die();
    }
	
	
	
	//check email validity
	$result_email= mysql_query(" SELECT* FROM users where email = '$email' ");
	if (!empty($result_email)) 
	{
		if (mysql_num_rows($result_email) > 0) 
		{
            $response["success"] = 1;
            $response["message"] =  "An account with that e-mail address already exists.";
            echo json_encode($response);
			die();
		}
    }
	
    // mysql inserting a new row
    $result = mysql_query("INSERT INTO users(email, password, first_name, last_name) 
	VALUES('$email', '$password', '$first_name', '$last_name')");

    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Success";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Oops! An error occurred.";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>