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
	
    $past_teacher_lectures_r = mysql_query(" SELECT * from lectures WHERE teacher_id = '$id' AND begin_time + duration < '$cur_unix' ");
    $past_teacher_problems_r = mysql_query(" SELECT * from problems WHERE solver_id = '$id' AND begin_time + duration < '$cur_unix' ");
	
    $curr_teacher_lectures_r = mysql_query(" SELECT * from lectures WHERE teacher_id = '$id' AND begin_time < '$cur_unix' AND begin_time + duration >= '$cur_unix' ");
    $curr_teacher_problems_r = mysql_query(" SELECT * from problems WHERE solver_id = '$id'  AND begin_time < '$cur_unix' AND begin_time + duration >= '$cur_unix' ");
	
    $future_teacher_lectures_r = mysql_query(" SELECT * from lectures WHERE teacher_id = '$id' AND begin_time >= '$cur_unix' ");
    $future_teacher_problems_r = mysql_query(" SELECT * from problems WHERE solver_id = '$id' AND begin_time >= '$cur_unix' ");
	
	
	$response["past_teacher"] = array();
	if (mysql_num_rows($past_teacher_lectures_r) > 0) 
	{
		while ($row = mysql_fetch_array($past_teacher_lectures_r)) 
		{
			// temp user array
			$sid=$row["id"];
			$n_part_r = mysql_query(" SELECT * from participations WHERE lecture_id = '$sid' ");
			$row["n_part"] = mysql_num_rows($n_part_r);
			array_push($response["past_teacher"], $row);
		}
	} 
	if (mysql_num_rows($past_teacher_problems_r) > 0) 
	{
		while ($row = mysql_fetch_array($past_teacher_problems_r)) 
		{
			array_push($response["past_teacher"], $row);
		}
	} 
	
	$response["curr_teacher"] = array();
	if (mysql_num_rows($curr_teacher_lectures_r) > 0) 
	{
		while ($row = mysql_fetch_array($curr_teacher_lectures_r)) 
		{
			// temp user array
			$sid=$row["id"];
			$n_part_r = mysql_query(" SELECT * from participations WHERE lecture_id = '$sid' ");
			$row["n_part"] = mysql_num_rows($n_part_r);
			array_push($response["curr_teacher"], $row);
		}
	} 
	if (mysql_num_rows($curr_teacher_problems_r) > 0) 
	{
		while ($row = mysql_fetch_array($curr_teacher_problems_r)) 
		{
			array_push($response["curr_teacher"], $row);
		}
	} 
	
	$response["future_teacher"] = array();
	if (mysql_num_rows($future_teacher_lectures_r) > 0) 
	{
		while ($row = mysql_fetch_array($future_teacher_lectures_r)) 
		{
			// temp user array
			$sid=$row["id"];
			$n_part_r = mysql_query(" SELECT * from participations WHERE lecture_id = '$sid' ");
			$row["n_part"] = mysql_num_rows($n_part_r);
			array_push($response["future_teacher"], $row);
		}
	} 
	if (mysql_num_rows($future_teacher_problems_r) > 0) 
	{
		while ($row = mysql_fetch_array($future_teacher_problems_r)) 
		{
			array_push($response["future_teacher"], $row);
		}
	} 
	
    // required field is missing
    $response["success"] = 1;
    $response["message"] = "Success";

    // echoing JSON response
    echo json_encode($response);
	
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