<?php 
session_start();
include("includes/connection.php");
include("functions/functions.php");

if(!isset($_SESSION['user_email'])){
    header("location: index:php");
}
else {
    
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome User!</title>
    <link rel="stylesheet" href="styles/home_style.css" media="all" />
    <!--This part is for SearchBar Javascript-->
    <script type="text/javascript">
            function active(){
                var searchBar = document.getElementById("user_query");
                
                if(searchBar.value=='Search...'){
                    searchBar.value=''
                    searchBar.placeholder='Search...'
                }
            }
            function inactive(){
                var searchBar = document.getElementById("user_query");
                
                if(searchBar.value==''){
                    searchBar.value='Search...'
                    searchBar.placeholder=''
                }
            } 
        </script>
    <!--SearchBar JS ends-->
    <!-- SENDING AJAX CHAT REQUEST START-->
    <script
            src="http://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous">
        </script>
    <!--
        <script>
            function submitChat() {
                if (form1.msg.value == ''){
                    alert('Please enter a message!');
                    return;
                }
                var msg = form1.msg.value;
                var xmlhttp = new XMLHttpRequest();

                //prepares the xml object
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                        document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.open('GET', 'chat_insert.php?msg='+msg, true);
                //sends username and the message to insert.php as an xml object
                xmlhttp.send();
            }

            $(document).ready(function(e){
                $.ajaxSetup({
                    cache: false
                });
                setInterval( function(){ $('#chatlogs').load('logs.php'); }, 100 );
            });
            //refreshs the <div> which is the chatlogs every 2 seconds
        </script>
-->
</head>

<body>
    <!-- CONTAINER STARTS -->
    <div class="container">
        <!-- HEADER WRAPPER STARTS -->
        <div id="head_wrap">
            <!-- HEADER STARTS -->
            <div id="header">
                <ul id="menu">
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="members.php">Members</a>
                    </li>
                    <strong>Topics:</strong>

                    <?php 
                            $get_topics = "select * from topics";
                            $run_topics = mysqli_query($con,$get_topics);
                            
                            while($row=mysqli_fetch_array($run_topics)){
                                $topic_id = $row['topic_id'];
                                $topic_title = $row['topic_title'];
                                
                                echo "<li><a href='topic.php?topic=$topic_id'>$topic_title</a><li>";
                            }
                    ?>

                </ul>
                <form method="get" action="results.php" id="form1">
                    <input type="text" name="user_query" id="searchBar" placeholder="" value="Search..." maxlength="50" autocomplete="on" onMouseDown="active();" onBlur="inactive();"/>
                    <input type="submit" name="search" id="searchBtn" value="Search"/>
                </form>
            </div>
            <!-- HEADER ENDS -->
        </div>
        <!-- HEADER WRAPPER ENDS -->
        <!-- CONTENT AREA STARTS -->
        <div class="content">
            <div id="user_timeline">
                <div id="user_details">
                    <?php 
                                $user = $_SESSION['user_email'];
                                $get_user = "SELECT * from users where user_email = '".$_SESSION['user_email']."'";
                                $run_user = mysqli_query($con,$get_user);
                                $row = mysqli_fetch_array($run_user);
                    
                                $user_id = $row['user_id'];
                                $user_name = $row['user_username'];
                    // Name concaetinations
                                $user_fname = $row['user_fname'];
                                $user_lname = $row['user_lname'];
                                $name = $user_fname . ' ' .  $user_lname;
                                $user_image = $row['user_image']; // error on this line
                                $user_country = $row['user_country'];
                                $register_date = $row['register_date'];
                                $last_login = $row['last_login'];
                    
                                // length number queries
                                $user_posts = "SELECT * FROM posts where user_id='$user_id'";
                                $run_posts = mysqli_query($con,$user_posts);
                                $posts = mysqli_num_rows($run_posts);
                    
                                //getting the number 
                                $sel_msg = "SELECT * from messages WHERE receiver='$user_id' AND status='unread' ORDER BY 1 DESC";
                                $run_msg = mysqli_query($con,$sel_msg);

                                $count_msg = mysqli_num_rows($run_msg); 
                                echo "
                                    <center><img src='user/user_images/$user_image' width='200'
                                    height='200'/></center>
                                    <div id='mention'>
                                    <p><strong>Username:</strong> $user_name</p>
                                    <p><strong>Name:</strong> $name</p>
                                    <p><strong>Country:</strong> $user_country</p>
                                    <p><strong>Last Login</strong> $last_login</p>
                                    <p><strong>Member Since:</strong> $register_date</p>
                                    
                                    <p><a href='my_messages.php?inbox&u_id=$user_id'>Messages($count_msg)</a></p>
                                    <p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
                                    <p><a href='edit_profile.php?user_id=$user_id'>Edit My Account</a></p>
                                    <p><a href='logout.php'>Logout</a></p>
                                    </div>
                                ";
                    ?>
                </div>
            </div>
            <!-- USER TIMELINE ENDS -->
            <!-- CONTENT TIMELINE STARTS -->
            <div id="content_timeline">
                <form action="home.php?id=<?php echo $user_id;?>" method="post" id="f">
                    <h2>Show the world what you created today, here!</h2>
                    <input type="text" name="title" placeholder="Write a title" size="82" required="required"/>
                    <br/>
                    <textarea cols="83" rows="4" name="content" placeholder="Share your creation to the world here">
                    </textarea>
                    <br/>
                    <select name="topic">
                        <option>Select Topic</option>
                        <?php getTopics();?>
                    </select>
                    <input type="submit" name="sub" value="Post to Timeline"/>
                </form>
                <?php insertPost();?>
                <div id="posts">
                    <h3>Most Recent Posts!</h3>
                    <?php get_posts();?>
                </div>
            </div>
            
        </div>
        <!-- CONTENT AREA ENDS -->
        <!-- START OF CHAT BOX -->
    <body>
        
        <div id="chatlogs">
                   
        </div>
        
		<form name="form1" id="form" method="post">
			Name: <input type="text" name="username" value="<?php echo $user_name?>" readonly/><br />
			Message:
			<textarea name="msg_content" style="width:200px; height:70px;"></textarea>
			<a href="#" onclick="submitChat()" name="send">Send</a><br />
			<input name="send" type="button" value="Full Send">
        </form>
    <?php
    if(isset($_POST['send']))
    {
        $msg_name = $_POST['username'];
        $msg = $_POST['msg_content'];

        $insert = "INSERT INTO chatlogs (`username`,`msg`) VALUES ('$msg_name','$msg')";
        $run = mysqli_query($con,$insert);
        if($run)
        {
            echo '<script>alert("A full send has occured")</script>';
            header('Location: home.php'); 
        }
    }
    ?>
        <!-- END OF CHAT BOX -->
	</body>
        
    </div>
    <!-- CONTAINER ENDS -->
</body>

</html>