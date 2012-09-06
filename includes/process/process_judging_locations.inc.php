<?php 
/*
 * Module:      process_judging_location.inc.php
 * Description: This module does all the heavy lifting for adding/editing info in the "judging_locations" table
 */
$judgingDate = strtotime($_POST['judgingDate']." ".$_POST['judgingTime']);


if ($action == "add") {
	$insertSQL = sprintf("INSERT INTO $judging_locations_db_table (judgingDate, judgingLocation, judgingLocName, judgingRounds) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($judgingDate, "text"),
                       GetSQLValueString($_POST['judgingLocation'], "scrubbed"),
                       GetSQLValueString($_POST['judgingLocName'], "scrubbed"),
					   GetSQLValueString($_POST['judgingRounds'], "text")
					   );

	//echo $insertSQL;
	mysql_select_db($database, $brewing);
  	$Result1 = mysql_query($insertSQL, $brewing) or die(mysql_error());
	if ($section == "step5") $insertGoTo = "../setup.php?section=step5&msg=9"; else $insertGoTo = $insertGoTo;
	$pattern = array('\'', '"');
  	$insertGoTo = str_replace($pattern, "", $insertGoTo); 
  	header(sprintf("Location: %s", stripslashes($insertGoTo)));				   
	
}

if ($action == "edit") {
	$updateSQL = sprintf("UPDATE $judging_locations_db_table SET judgingDate=%s, judgingLocation=%s, judgingLocName=%s, judgingRounds=%s WHERE id=%s",
                       GetSQLValueString($judgingDate, "text"),
                       GetSQLValueString($_POST['judgingLocation'], "scrubbed"),
                       GetSQLValueString($_POST['judgingLocName'], "scrubbed"),
					   GetSQLValueString($_POST['judgingRounds'], "text"),
					   GetSQLValueString($id, "int"));   
					   
	mysql_select_db($database, $brewing);
	//echo $judgingDate; echo "<br>".$tz; echo "<br>".$timezone_offset; echo "<br>".$row_prefs['prefsTimeZone'];
  	$Result1 = mysql_query($updateSQL, $brewing) or die(mysql_error());
	$pattern = array('\'', '"');
  	$updateGoTo = str_replace($pattern, "", $updateGoTo); 
  	header(sprintf("Location: %s", stripslashes($updateGoTo)));
}

?>