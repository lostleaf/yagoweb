<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Yago</title>
</head>
<body>

<form action="yago.php" method="post">
	<label>Choose the problem</label>
	<select name="problem">
		<option value=1>Find entity</option>
		<option value=2>Find fact through fact ID</option>
		<option value=3>Find all the relations whose range or domain matches the given type</option>
		<option value=4>Finf all the facts where the given entity occured</option>
		<option value=5>Find all the types which the given entity belongs to</option>
		<option value=6>Return the geospatial or time infomation of the fact</option>
		<option value=7>What happened on the given date (format:MM-DD)</option>
	</select>
	<label>Key word</label>
	<input type="text" name="key" />
	<input type="submit" />
</form>

<?php
	$conn = mysql_connect("localhost","yinger650","56729122");
	mysql_select_db("yago", $conn);
	mysql_query('set names utf8');
	if (!empty($_POST["problem"])) {
		echo $_POST["key"].$_POST["problem"];
		switch ($_POST["problem"]) {
			case 1:
				$query = "select distinct entity1 from yfact where entity1 = \"".$_POST["key"]."\" union select distinct entity2 from yfact where entity2 = \"".$_POST["key"]."\";";
				$result =  mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['entity1'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				break;
			case 2:
				$query = "select entity1, relation, entity2 from yfact where feature = \"".$_POST["key"]."\";";
				$result = mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['entity1']." ".$row['relation']." ".$row['entity2'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				
				break;
			case 3:
				$query = "select ytype1, relation, ytype2 from yschema where ytype2 = \"".$_POST["key"]."\";";
				$result = mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['ytype2']." is the ".$row['relation']." of ".$row['ytype1'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				
				break;
			case 4:
				$query = "select entity1, relation, entity2 from yfact where entity1 = \"".$_POST["key"]."\" or entity2 =\"".$_POST["key"]."\";";
				$result = mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['entity1']." ".$row['relation']." ".$row['entity2'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				break;
			case 5:
				$query = "select type from ytype where entity = \"".$_POST["key"]."\";";
				$result = mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['type'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				break;
			case 6:
				$query = "select relation, meta from ymeta where entity_feature = \"".$_POST["key"]."\";";
				$result = mysql_query($query);
				echo "<ul>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<li>";
					echo $row['relation']." ".$row['meta'];
			  		echo "</li>";
	  			}
				echo "</ul>";
				break;	
			case 7:
				$query = "select entity1,relation,entity2 from yfact where feature in (select entity_feature from ymeta where date = \"".$_POST["key"]."\");";
				echo $query;
				$result = mysql_query($query);
				echo "<table>";
				while($row = mysql_fetch_array($result)) {
			  		echo "<tr>";
					echo "<td>".$row['entity1']."</td><td>".$row['relation']."</td><td>".$row['entity2']."</td>";
			  		echo "</tr>";
	  			}
				echo "</table>";
				break;	
				
			default:
		}
	}
?>
</body>
</html>

