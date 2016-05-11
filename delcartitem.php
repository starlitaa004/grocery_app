<?php
include 'dbconnection.php';
	if(isset($_POST['itemnum']) && isset($_POST['cusnum']))
	{
		$itemnum= $_POST['itemnum'];
		$cusnum = $_POST['cusnum'];

        $check_cart = mysql_query("SELECT * FROM cart WHERE item_num = '$itemnum' AND customer_num = '$cusnum'");
        $item_qty = mysql_fetch_assoc($check_cart);
        $rows = mysql_num_rows($check_cart);
        if($rows > 0)
        {
        	$qty_cart = $item_qty['item_qty'];
      		////////////////////// UPDATE ITEM TABLE ///////////////
      		mysql_query("UPDATE item SET item_itemonhand = item_itemonhand + $qty_cart WHERE item_num = '$itemnum'");
      		mysql_query("DELETE FROM cart WHERE customer_num = '$cusnum' AND item_num = '$itemnum'");

      		echo "success";
        }
        else
        {
        	echo "error";
        }

	}
	else
	{
		echo "errors";
	}
?>