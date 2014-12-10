<?php

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
			
		
	$result = mysql_query(" SELECT problems.*, users.email, users.first_name, users.last_name from problems 
	INNER JOIN users ON users.id = problems.poster_id WHERE begin_time + duration >= '$cur_unix' ORDER BY begin_time ASC");

	// check for empty result
	if (mysql_num_rows($result) > 0) {

		$response["problems"] = array();

		while ($row = mysql_fetch_array($result)) {
			// temp user array
			$response_row = array();
			$problem_id = $row["id"];
			$response_row["problem_id"] = $row["id"];
			$response_row["begin_time"] = $row["begin_time"];
			$response_row["duration"] = $row["duration"];
			
			$response_row["poster_id"] = $row["poster_id"];
			
			$response_row["poster_email"] = $row["email"];
			$response_row["poster_first_name"] = $row["first_name"];
			$response_row["poster_last_name"] = $row["last_name"];
			
			$t1 = $row["begin_time"];
			$t2 = $row["duration"];
			if( $t1 > $cur_unix )
			 $response_row["active"] = 0;
			else 
			 $response_row["active"] = 1;
			
			$response_row["cost"] = $row["cost"];
			$response_row["solver_id"] = $row["solver_id"];
			$response_row["description"] = $row["description"];
			$solver_id = $response_row["solver_id"];
			
			
			$my_part = mysql_query(" SELECT * FROM solvers WHERE problem_id = '$problem_id' AND solver_id = '$id' ");
			if(mysql_num_rows($my_part) > 0 )
				$response_row["me"]="1";
			else $response_row["me"]="0";
			
			if($solver_id != -1)
			{
			  $result2 = mysql_query(" SELECT * FROM users WHERE id = '$solver_id' ");
			  
			  if (mysql_num_rows($result2) > 0) 
			  {
				  //should be once
				  while ($row1 = mysql_fetch_array($result2)) 
				  {
						// temp user array
						$response_row["solver_email"] = $row["email"];
						$response_row["solver_first_name"] = $row["first_name"];
						$response_row["solver_last_name"] = $row["last_name"];
				  }
			  }
			}

			
			array_push($response["problems"], $response_row);
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