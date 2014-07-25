<?php 
if(isset($_POST['num'])){
	$count = $_POST['guys'];
}
include 'db_conn.php';
$sql = "SELECT DISTINCT name FROM `audit_transaction`";
$result_members = $mysqli->query($sql);
include 'db_disconn.php';

?>
<html>
<head>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
 <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
 
 <script>
	$(function () {
		$("input[type='datetime']").datepicker();
		});

 </script>
</head>
<body>
<?php if(isset($_POST['cal'])){
	for($i = 0; $i<$_POST['hidden']; $i++){
		echo $_POST['name'.$i].';'.($_POST['dateto'.$i]-$_POST['datefrom'.$i]).+';'."<br />";
	}
}?>
<form method="post" action ="./summary.php" enctype="multipart/form-data">
<input type="hidden" name="count" value = '<?php echo $count ?>'>

<datalist id="names">
<?php while($row=$result_members->fetch_array(MYSQLI_NUM)){?>
	<option value='<?php echo $row[0];?>'>
	<?php }?>
</datalist>
<?php 
for ($i = 0; $i < $count; $i++){
	?>
	<div>
	Number : <?php echo $i?>
	Name: <input type="text" id="name" name="name<?php echo $i;?>"  list="names" />
	Date from: <input type="datetime" name="datefrom<?php echo $i;?>" />
	to: <input type="datetime" name = "dateto<?php echo $i;?>" />
	Excluding weeks: <input type="number"  name = "ex_weeks" value = 0 />
	</div>
	<?php 
}?>
amount of cost: <input type="text" name="total_cost" />
script upload: <input type="file" name="file" id="file" />
<input type="submit" name="calc" value="submit" />
</form>
</body>
</html>