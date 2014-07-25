<?php
include 'session.php';
include 'db_conn.php';
$sql = "SELECT * FROM `audit_transaction` as t inner join `audit_session` as s on t.sessionID = s.id order by s.trans_date desc";
$result_all = $mysqli->query($sql);
include 'db_disconn.php';

?>

<html>
<head>
<title>auditing</title>
</head>

<body>
<form method="post" action = "./calc.php">
Amount of members? <input type="text" name="guys" />
<input type="submit" value="confirm" name="num" /> 
</form>
		<div>
		<?php 
				$last_date = -1;
		while($row = $result_all->fetch_array(MYSQLI_BOTH)){  
			if($last_date != $row['trans_date']){
				if($last_date != -1){
					echo "</table>";
				} 
				$last_date = $row['trans_date']; ?>
				<h4> Date: <?php echo $row['trans_date']?> </h4>
				<h4> Amount of cost: <?php echo $row['fare_amount']?> </h4>
				<h4> cost per person per day: A$<?php echo $row['unit_cost']?>/person/day</h4>
				<h4> Download bill script: <?php echo $row['bill_script']?> </h4>
				<table border="1">
				<tr><th>Name</th><th>date From</th><th>date To</th><th>excluded weeks</th><th>cost</th></tr>
			<?php }?>
				<tr><td><input type="hidden" name="id" value=<?php echo $row[0]?> /><?php echo $row['name'];?></td>
				<td><?php echo $row['datefrom'];?></td>
				<td><?php echo $row['dateto'];?></td>
				<td><?php echo $row['ex_weeks'];?></td>
				<td><?php echo $row['unit_cost'];?></td>
				</tr>
		<?php }?>
		</table>
		</div>
</body>
</html>