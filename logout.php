<?php
	session_start();
	include 'dbconnection.php';

	$getcartitems = mysql_query("SELECT * FROM cart WHERE customer_num = ". $_SESSION['user_id']);
	$numrows = mysql_num_rows($getcartitems);

	if($numrows != 0) {
		while($row = mysql_fetch_assoc($getcartitems)) {
			$qty 		= $row['item_qty'];
			$item_num 	= $row['item_num'];

			$updateitem = mysql_query("UPDATE `item` 
									   SET item_itemonhand = item_itemonhand + ". $qty ." 
									   WHERE item_num = ". $item_num);
		}
	}

	$query = mysql_query("DELETE FROM cart WHERE customer_num = ". $_SESSION['user_id']);
	session_destroy();
	echo "<script language='javascript'>window.location = ['index.php']</script>";
?>