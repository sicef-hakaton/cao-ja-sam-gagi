<?php

// array for JSON response
$response = array();

// check for required fields
if (
		isset($_GET['student_id']) && isset($_GET['lecture_id'])
   ) 
{
    
	$student_id = $_GET['student_id'];
	$lecture_id = $_GET['lecture_id'];
	
    // include db connect class
    require_once dirname(__FILE__) . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

	
	//ako ima para ?!
	$result1 = mysql_query("SELECT cost, teacher_id FROM lectures WHERE id = '$lecture_id' ");
	
	// check for empty result
	if (mysql_num_rows($result1) > 0) 
	{
		while ($row = mysql_fetch_array($result1)) 
		{
			$lecture_cost = $row["cost"];
			$teacher_id = $row["teacher_id"];
		}
	}
	else 
	{
		$response["success"] = 0;
		$response["message"] = "Something went wrong.";
		echo json_encode($response);
		die();
	} 
	
	$result2 = mysql_query("SELECT credit FROM users WHERE id = '$student_id' ");
	
	// check for empty result
	if (mysql_num_rows($result2) > 0) 
	{
		while ($row = mysql_fetch_array($result2)) 
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

	if($user_credit < $lecture_cost)
	{
		$response["success"] = 1;
		$response["message"] = "Not enough credit.";
		echo json_encode($response);
		die();
	}
	else
	{
		$result3 = mysql_query(" UPDATE users SET credit = credit - '$lecture_cost' WHERE id = '$student_id' ");
		$result4 = mysql_query(" UPDATE users SET credit = credit + '$lecture_cost' WHERE id = '$teacher_id' ");
		
		
		// mysql inserting a new row
		$result = mysql_query("INSERT INTO participations(student_id, lecture_id) 
		VALUES('$student_id', '$lecture_id')");

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