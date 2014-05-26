<?php
	$conn = mysql_connect("localhost","yinger650","56729122");
	mysql_select_db("yago", $conn);
	mysql_query('set names utf8');
	$query = "";
	if (!empty($_POST["problem"])) {
		switch ($_POST["problem"]) {
			case 1:
				$query = "select distinct entity1 from yfact where entity1 like \"%".$_POST["key"]."%\" union select distinct entity2 from yfact where entity2 like \"%".$_POST["key"]."%\";";

				break;
			case 2:
				$query = "select entity1, relation, entity2 from yfact where feature = \"".$_POST["key"]."\";";
				
				break;
			case 3:
				$query = "select ytype1, relation, ytype2 from yschema where ytype2 = \"".$_POST["key"]."\";";
				
				break;
			case 4:
				$query = "select entity1, relation, entity2 from yfact where entity1 = \"".$_POST["key"]."\" or entity2 =\"".$_POST["key"]."\";";

				break;
			case 5:
				$query = "select type from ytype where entity = \"".$_POST["key"]."\";";

				break;
			case 6:
				$query = "select relation, meta from ymeta where entity_feature = \"".$_POST["key"]."\";";
				
				break;	
			case 7:
				$query = "select entity1,relation,entity2 from yfact where feature in (select entity_feature from ymeta where date = \"".$_POST["key"]."\");";
			
				break;	
				
			default:
		}
		$rs = mysql_query($query);
		$result = array();
		while($row = mysql_fetch_object($rs)) {
			array_push($result, $row);
		}
		echo json_encode($result);
	}