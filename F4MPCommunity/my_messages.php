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
                    <input type="text" name="user_query" placeholder="Search a topic">
                    <input type="submit" name="search" value="Search" />
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
                                $user_username = $row['user_username'];
                                $user_image = $row['user_image'];
                                $userfname = $row['user_fname'];
                                $userlname = $row['user_lname'];
                                $name = $userfname . ' ' . $userlname; 
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
                                    <p><strong>Username:</strong> $user_username</p>
                                    <p><strong>Name:</strong> $name</p>
                                    <p><strong>Country:</strong> $user_country</p>
                                    <p><strong>Last Login</strong> $last_login</p>
                                    <p><strong>Member Since:</strong> $register_date</p>
                                    
                                    <p><a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
                                    <p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
                                    <p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>
                                    <p><a href='logout.php'>Logout</a></p>
                                    </div>
                                ";
                    ?>
                </div>
            </div>
            <!-- USER TIMELINE ENDS -->
            <!-- CONTENT TIMELINE STARTS -->
            <div id="msg">
                <p align="center">
                    <a href="my_messages.php?inbox&u_id=$user_id'>(<?php echo count_msg?>)">My Inbox</a> ||
                    <a href="my_messages.php?sent">Sent Items</a>
                </p>
                <?php
                if(isset($_GET['sent'])){
                    include("sent.php");
                }
                ?>
                    <?php if(isset($_GET['inbox'])){
                    ?>
                    <table width="700">
                        <tr>
                            <th>Sender:</th>
                            <th>Subject:</th>
                            <th>Content:</th>
                            <th>Date:</th>
                            <th>Reply:</th>
                        </tr>
                    <?php 
                        $sel_msg = "SELECT * from messages WHERE receiver='$user_id' ORDER BY 1 DESC";
                        $run_msg = mysqli_query($con,$sel_msg);

                        $count_msg = mysqli_num_rows($run_msg);
                    
                        while($row_msg=mysqli_fetch_array($run_msg))
                        {
                            $msg_id = $row_msg['msg_id'];
                            $msg_receiver = $row_msg['receiver'];
                            $msg_sender = $row_msg['sender'];
                            $msg_sub = $row_msg['msg_subject'];
                            $msg_content = $row_msg['msg_content'];
                            $msg_date = $row_msg['msg_date'];

                            $get_sender = "SELECT * from USERS WHERE user_id='$msg_sender'";
                            $run_sender = mysqli_query($con,$get_sender);
                            $row = mysqli_fetch_array($run_sender);
                            $sender_name = $row['user_username'];

                        }
                ?>
                        <!-- START OF TABLE -->\
                        <table width="700" align="center">
                            <tr align="center">
                                <td>
                                    <a href="user_profile.php?u_id=<?php echo $msg_sender;?>" target="blank">
                                        <?php echo $sender_name;?>
                                    </a>
                                </td>
                                <td>
                                    <a href="user_profile.php?u_id=<?php echo $msg_sender;?>" target="blank">
                                        <?php echo $msg_content;?>
                                    </a>
                                </td>
                                <td>
                                    <a href="my_messages.php?msg_id=<?php echo $msg_id;?>">
                                        <?php echo $msg_sub;?>
                                    </a>
                                </td>
                                <td>
                                    <?php echo $msg_date;?>
                                </td>
                                <td><a href="my_messages.php?msg_id=<?php echo $msg_id;?>">Reply</a></td>
                            </tr>
                            <?php } ?>
                        </table>
                <?php 
                    if(isset($_GET['msg_id'])){
                        
                        $get_id = $_GET['msg_id'];
                        
                        $sel_message = "SELECT * FROM messages where msg_id='$get_id'";
                        $run_message = mysqli_query($con,$sel_message);
                        
                        $row_message = mysqli_fetch_array($run_message);
                        
                        $msg_subject = $row_message['msg_subject'];
                        $msg_content = $row_message['msg_content'];
                        $reply_status = $row_message['reply'];
                        
                        //updating the unread message to read
                        $update_unread="UPDATE messages SET status='read' WHERE msg_id='$get_id'";
                        $run_unread = mysqli_query($con,$update_unread);
                        
                        echo"<center><br/><hr>
                            <h2>$msg_subject</h2><br/>
                            <p><b>Message:</b>$msg_content</p>
                            <p><b>My Reply:</b>$reply_content</p>
                            
                            <form action='' method='post'>
                                <textarea cols='30' rows='5' name='reply'></textarea><br/>
                                <input type='submit' name='msg_reply' value='Reply to this'/>
                            </form>
                            </center>
                        ";
                    }
                    if(isset($_POST['msg_reply'])){
                        
                            $user_reply = $_POST['reply'];
                            
                            if($reply_content!='no_reply'){
                                 echo "<h2 align='center'>Message was already replied!</h2>";
                                exit();
                            }else {
                                
                            // error here not updating
                            $update_msg = "update messages set reply='$user_reply' WHERE msg_id='get_id'";
                        
                            $run_update = mysqli_query($con,$update_msg);
                            
                            echo "<h2 align='center'>Message was replied too!</h2>";
                            }
                    }
                ?>
                </table>     
                <!-- CONTENT AREA ENDS -->
            </div>
        </div>
        </div>
        <!-- CONTAINER ENDS -->
        <h1>Welcome:
            <?php echo $_SESSION['user_email'];?>
        </h1>
</body>

</html>