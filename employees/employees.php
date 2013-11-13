<?php

/*
	My understanding:
	
	The 'Boss Name' is the person who is their bossId + 1.
	The CEO(s) have the highest bossId.
	The lower workers have the lowest bossId.
	'bossId' in my mind is basically the employees ranking.
	'Distance from CEO' is how many people are above them. Not 
	including people who are equal to their bossId.
	'Subordinate count' is people who are below their 'bossId',
	not including people who are equal to their 'bossId'.
	
	Also, wrote this without classes due to the simpleness
	of the PHP needed.
	
	Notes:
	
	There seemed to be no 'single CEO' as the two highest
	people had the same bossId.
	
*/


/*
	The MySQL functions are deprecated but 
	additional packages would need to
	be installed to use a substitute.
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE);

mysql_connect("localhost", "root", ""); //Replace with your DB information
mysql_select_db("employees"); //Replace with your DB information

if($_GET['p']) 
	$limit = $_GET['p'] . ", 100";
else
	$limit = "0, 100";
	
if($_GET['name'])
	$name = "WHERE name LIKE '%".$_GET['name']."%'";

$sql = mysql_query("SELECT id, name, bossId FROM employees $name LIMIT $limit") or die(mysql_error());
while($view = mysql_fetch_array($sql)) {

	$a = mysql_query("SELECT COUNT(id) FROM employees WHERE bossId < '".$view['bossId']."'") or die(mysql_error());
	$b = mysql_fetch_array($a);
	$working_below = $b['COUNT(id)'];
	
	$a = mysql_query("SELECT COUNT(id) FROM employees WHERE bossId > '".$view['bossId']."'") or die(mysql_error());
	$b = mysql_fetch_array($a);
	$to_ceo = $b['COUNT(id)'];
	
	$a = mysql_query("SELECT name FROM employees WHERE bossId = '".($view['bossId'] + 1)."' LIMIT 1") or die(mysql_error());
	$b = mysql_fetch_array($a);
	$boss_name = $b['name'];

	$output .= "<tr><td>".$view['id'] . "</td>
			<td>".$view['name']."</td>
			<td>".$boss_name."</td><td>".$to_ceo."</td>
			<td>".$working_below."</td></tr>";

	}

/*
	Generating Pagination
*/
	
$i = 0;
$count = 1;	

$num = mysql_num_rows(mysql_query("SELECT id FROM employees"));
while($i < $num) {

	$pagination_links .= "<a href='index.php?p=$i'>$count</a> | ";
	$count++;
	$i += 100;
	
	}

?>

<html>
<head>

</head>

<body>

	<form action="" method="get">

		<input type="text" name="name"> - <input type="submit" value="Search">

	</form>

	<div id="contentArea" style="width:700px;height:600px;border:solid 1px black;overflow-y:scroll;">
		<table style="width:100%;" cellpadding="5" border="1">
			<tr>
				<th>
					ID
				</th>
				<th>
					Name
				</th>
				<th>
					Boss's Name
				</th>
				<th>
					Distance From CEO
				</th>
				<th>
					Subordinate Count
				</th>
			</tr>
		<?php print $output; ?>
		</table>
	</div>

	<?php
		print $pagination_links;
	?>

</body>
</html>