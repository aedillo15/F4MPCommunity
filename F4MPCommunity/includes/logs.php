<?php
/*logs.php is just like insert.php but without the inserting part*/
mysqli_select_db($con, "chatbox") or die ("Database not found!");

$result = mysqli_query($con,"SELECT * FROM chatbox ORDER by id DESC");

while ($row = mysqli_fetch_array($result)){
	echo "<span class='uname'>" . $row['msg_sender'] . "</span>: <span class='msg'>" . $row['msg_content'] . "</span><br>";
}

?>