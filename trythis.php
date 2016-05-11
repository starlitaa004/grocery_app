<!DOCTYPE html>
<html >
  <head>
   <script src="http://code.jquery.com/jquery-1.4.2.min.js"></script> 
<script> 
	(function ($) {
	  jQuery.expr[':'].Contains = function(a,i,m){
		  return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
	  };
	 
	  function listFilter(header, list) {
		var form = $("<form>").attr({"class":"filterform","action":"#"}),
			input = $("<input>").attr({"class":"filterinput","type":"text"});
		$(form).append(input).appendTo(header);
	 
		$(input)
		  .change( function () {
			var filter = $(this).val();
			if(filter) {
			  $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
			  $(list).find("a:Contains(" + filter + ")").parent().slideDown();
			} else {
			  $(list).find("li").slideDown();
			}
			return false;
		  })
		.keyup( function () {
			$(this).change();
		});
	  }
	
	  $(function () {
		listFilter($("#header"), $("#list"));
	  });
	}(jQuery));
</script> 
 
</head> 
<body> 
<div id="wrap"> 
    <h1 id="header"></h1> 
    
    <ul id="list"> 
        <?php
        	include_once "dbconnection.php";

        	$item = mysql_query("SELECT * FROM item");

        	while($fetch = mysql_fetch_assoc($item))
        	{
        		echo "<li><a href=''>".$fetch['item_desc']."</a></li>";
        	}
        ?>
    </ul> 
</div> 
</body>
<script src="trythis.js"></script>
</html>