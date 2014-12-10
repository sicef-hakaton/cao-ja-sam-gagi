<?php

// array for JSON response
$response = array();

// check for required fields

// include db connect class
require_once dirname(__FILE__) . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();


$cur_unix = strtotime(date('Y-m-d H:i:s'));

if (
		isset($_GET['id'])
   ) 
{
		$id = $_GET['id'];
	
		$result1 = mysql_query(" SELECT * FROM users WHERE id = '$id' ");
	
		while ($row = mysql_fetch_array($result1)) 
		{
			$response["credit"] = $row["credit"];
			$response["first_name"] = $row["first_name"];
			$response["last_name"] = $row["last_name"];
		}
		
	
	$result = mysql_query(" SELECT lectures.*, users.email, users.first_name, users.last_name from lectures 
	INNER JOIN users ON users.id = lectures.teacher_id WHERE begin_time + duration >= '$cur_unix' ORDER BY begin_time ASC");

	// check for empty result
	if (mysql_num_rows($result) > 0) {

		$response["lectures"] = array();

		while ($row = mysql_fetch_array($result)) {
			// temp user array
			$response_row = array();
			$response_row["lecture_id"] = $row["id"];
			$response_row["begin_time"] = $row["begin_time"];
			$response_row["duration"] = $row["duration"];
			
			$response_row["teacher_id"] = $row["teacher_id"];
			
			$response_row["teacher_email"] = $row["email"];
			$response_row["teacher_first_name"] = $row["first_name"];
			$response_row["teacher_last_name"] = $row["last_name"];
			
			$response_row["cost"] = $row["cost"];
			$response_row["max_users"] = $row["max_users"];
			$response_row["description"] = $row["description"];
			
			$t1 = $row["begin_time"];
			$t2 = $row["duration"];
			if( $t1 > $cur_unix )
			 $response_row["active"] = 0;
			else 
			 $response_row["active"] = 1;
			
			$sid=$row["id"];
			$n_participants_res = mysql_query(" SELECT * from participations WHERE lecture_id = '$sid' ");
			$response_row["n_part"] = strval(mysql_num_rows($n_participants_res));
			$my_part = mysql_query(" SELECT * from participations WHERE lecture_id = '$sid' AND student_id = '$id' ");
			if(mysql_num_rows($my_part) > 0 )
				$response_row["me"]="1";
			else $response_row["me"]="0";
			
			array_push($response["lectures"], $response_row);
		}
		// success
		$response["success"] = 1;
		$response["message"] = "Success";

		// echoing JSON response
		echo json_encode($response);
	} else {
		$response["success"] = 1;
		$response["message"] = "No items";

		echo json_encode($response);
	}
}
else
{
		$response["success"] = 0;
		$response["message"] = "Not all fields set";

		echo json_encode($response);
	}
?>