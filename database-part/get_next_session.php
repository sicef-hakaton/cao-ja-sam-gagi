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
	
    $first_lectures = mysql_query(" SELECT id, begin_time FROM lectures WHERE teacher_id = '$id' AND begin_time + duration >= '$cur_unix' ORDER BY begin_time");
	$first_problems = mysql_query(" SELECT id, begin_time FROM problems WHERE ( solver_id = '$id' OR poster_id = '$id') AND begin_time + duration >= '$cur_unix' ORDER BY begin_time ");
	$first_lectures2 = mysql_query(" SELECT lecture_id, begin_time FROM participations INNER JOIN lectures ON participations.lecture_id = lectures.id WHERE student_id = '$id' AND begin_time + duration >= '$cur_unix' ORDER BY begin_time ");
    
	
	if( mysql_num_rows($first_lectures) > 0 )
	{
		while ($row = mysql_fetch_array($first_lectures)) 
		{
			$t1 = $row["begin_time"];
			$k1 = $row["id"];
		}
	} else $t1=-1;
	echo "$t1"." ";
	if( mysql_num_rows($first_problems) > 0 )
	{
		while ($row = mysql_fetch_array($first_problems)) 
		{
			$t2 = $row["begin_time"];
			$k2 = $row["id"];
		}
	} else $t2=-1;
	echo "$t2"." ";
	if( mysql_num_rows($first_lectures2) > 0 )
	{
		while ($row = mysql_fetch_array($first_lectures2)) 
		{
			$t3 = $row["begin_time"];
			$k3 = $row["lecture_id"];
		}
	} else $t3=-1;
	echo "$t3"." ";
	
	if( $t1 != -1 and ($t2 == -1 or $t1 >= $t2) and ($t3 == -1 or $t1 >= $t3) )
	{
		$result = mysql_query(" SELECT * FROM lectures WHERE id = '$k1' ");
		while ($row = mysql_fetch_array($result)) 
		{
			$row["type"]="lecture";
			$row["success"] = "Success";
			echo json_encode($row);
			die();
		}
	}
	if( $t2 != -1 and ($t1 == -1 or $t2 >= $t1) and ($t3 == -1 or $t2 >= $t3) )
	{
		$result = mysql_query(" SELECT * FROM problems WHERE id ='$k2' ");
		while ($row = mysql_fetch_array($result)) 
		{
			$row["type"]="problem";
			$row["success"] = "Success";
			echo json_encode($row);
			die();
		}
	}
	if( $t3 != -1 and ($t1 == -1 or $t3 >= $t1) and ($t2 == -1 or $t3 >= $t2) )
	{
		$result = mysql_query(" SELECT * FROM lectures WHERE id = '$k3' ");
		while ($row = mysql_fetch_array($result)) 
		{
			$row["type"]="lecture";
			$row["success"] = "Success";
			echo json_encode($row);
			die();
		}
	}
	
    // required field is missing
    $response["success"] = "No scheduled session";

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