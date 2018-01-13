<?php
if(isset($_POST['send'])){
    global $con
    
    $msg_name ="";
    $msg_content ="";
    
    $msg_name = $_POST['uname'];
    $msg_content = $_POST['msg'];
    
    $insert = "INSERT INTO chatlogs(username,msg) VALUES ('$msg_name','$msg_content')";
    
    $run = mysqli_query($con,$insert);
    $_SESSION['user_username'] = $username;
        if($run){
            echo "<script>alert('Message fully sent!')</script>";
            echo "<script>window.open('home.php','_self')</script>";
        }
    
}
/*
$con = mysqli_connect("localhost","root","") or die ("Could not connect to MySQL!");
mysqli_select_db($con, "chatbox") or die ("Database not found!");

//sql query to insert username and message into the Database
mysqli_query($con,"INSERT INTO chatbox (`username`, `msg`) VALUES ('$username','$msgcontent')");
//sql query to select username and message ordered by the id
$result = mysqli_query($con,"SELECT * FROM chatbox ORDER by id DESC");

/*puts the query from above into an array and will display each username and message one by one
until end of array is reached*/
/*
while ($row = mysqli_fetch_array($result)){
	echo "<span class='uname'>" . $row['msg_sender'] . "</span>: <span class='msg'>" . $row['msg_content'] . "</span><br>";
}
*/
?>

