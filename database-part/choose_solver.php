<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['problem_id']) && isset($_GET['solver_id']) 
   ) 
{
    
    $problem_id= $_GET['problem_id'];
    $solver_id = $_GET['solver_id'];

    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();
	
	//just transfer money
	
	$result1 = mysql_query("SELECT cost from problems WHERE id ='$problem_id'");
	
	// check for empty result
	if (mysql_num_rows($result1) > 0) 
	{
		while ($row = mysql_fetch_array($result1)) 
		{
			$cost = $row["cost"];
		}
	}
	else 
	{
		$response["success"] = 0;
		$response["message"] = "Something went wrong.";
		echo json_encode($response);
		die();
	}
	
	$result2 = mysql_query(" UPDATE users SET credit = credit + '$cost' WHERE id = '$solver_id' ");
	
    // mysql inserting a new row
    $result = mysql_query(" UPDATE problems SET solver_id = '$solver_id' WHERE id = '$problem_id' ");

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