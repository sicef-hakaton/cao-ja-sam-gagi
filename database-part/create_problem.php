<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['begin_time']) && isset($_GET['duration']) && isset($_GET['poster_id']) &&
		isset($_GET['cost']) && isset($_GET['description'])
   ) 
{
    
    $cur_unix = strtotime(date('Y-m-d H:i:s'));
	$begin_time = $_GET['begin_time'];
	$duration = $_GET['duration'];
	$poster_id = $_GET['poster_id'];
	$cost = $_GET['cost'];
	$description = $_GET['description'];
	
    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
	
	
	if($cur_unix > $begin_time)
	{
		// invalid values
		$response["success"] = 0;
		$response["message"] = "It can't start before now.";

		// echoing JSON response
		echo json_encode($response);
		
		die();
	}
	
	$result1 = mysql_query("SELECT credit from users WHERE id ='$poster_id'");
	
	
	// check for empty result
	if (mysql_num_rows($result1) > 0) 
	{
		while ($row = mysql_fetch_array($result1)) 
		{
			$user_credit = $row["credit"];
		}
	}
	else 
	{
		$response["success"] = 0;
		$response["message"] = "Something went wrong.";
		echo json_encode($response);
		die();
	} 

	if( $user_credit < $cost)
	{
		$response["success"] = 1;
		$response["message"] = "Not enough credit.";
		echo json_encode($response);
		die();
	}
	else
	{
		//make the payment
		$new_user_credit = $user_credit - $cost;
		$result2 = mysql_query(" UPDATE users SET credit = '$new_user_credit' WHERE id = '$poster_id' ");
		
		// mysql inserting a new row
		$result = mysql_query("INSERT INTO problems(begin_time, duration, poster_id, cost, description) 
		VALUES('$begin_time', '$duration', '$poster_id', '$cost', '$description')");

		if ($result) 
		{
			// successfully inserted into database
			$response["success"] = 1;
			$response["message"] = "Success";

			// echoing JSON response
			echo json_encode($response);
		} 
		else 
		{
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred.";
			
			// echoing JSON response
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