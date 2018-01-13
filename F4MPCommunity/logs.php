<?php
/*logs.php is just like insert.php but without the inserting part*/
include("includes/connection.php");

$result = mysqli_query($con,"SELECT * FROM chatlogs ORDER by id ASC");

while ($row = mysqli_fetch_array($result)){
	echo "<span class='uname'>" . $row['username'] . "</span>: <span class='msg'>" . $row['msg'] . "</span><br>";
}

?>