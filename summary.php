<?php
if(isset($_POST['calc'])){
	$count = $_POST['count'];
	$amount_day_person = array_fill(0, $count, 0);
	$day_person = 0;
	for($i = 0; $i<$count; $i++){
		$date_from = new DateTime($_POST['datefrom'.$i]);
		$date_to = new DateTime($_POST['dateto'.$i]);
		$diff = date_diff($date_from, $date_to);
		$amount_day_person[$i]= (int)$diff->format('%a');
		$day_person += $amount_day_person[$i];
	}
	$amount_cost = $_POST['total_cost'];
	$cost_person_day = bcdiv($amount_cost, $day_person, 2);
	
	echo "cost per person per day: $cost_person_day <br />";
	
	for($i = 0; $i<$count; $i++){
		echo $_POST['name'.$i];
		echo " should pay ".($cost_person_day * $amount_day_person[$i]);
		echo " bulks for $amount_day_person[$i] days' dwelling <br />";
	}
	
	$now = date("Ymd");
}

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		&& ($_FILES["file"]["size"] < 20000)
		&& in_array($extension, $allowedExts)) {
	if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	} else {
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
		if (file_exists("./trans_scripts/" . $now)) {
			echo $_FILES["file"]["name"] . " already exists. ";
		} else {
			$tmp_file = $_FILES["file"]["tmp_name"];
			$tmp_file = str_replace("\\","/",$tmp_file);
			$tar_file = $_SERVER['DOCUMENT_ROOT']."trans_scripts/".$now.".".$extension;
			$tar_file = str_replace("/","\\", $tar_file);
			move_uploaded_file( $tmp_file, $tar_file);
			echo "Stored in: " . $tar_file;
		}
	}
} else {
	echo "Invalid file";
}


include "db_conn.php";

include "db_disconn.php";

?>