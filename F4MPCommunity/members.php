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
                <div id="user_timeline">
                    <div id="user_details">
                        <?php 
                                        $user = $_SESSION['user_email'];
                                        $get_user = "SELECT * from users where user_email = '".$_SESSION['user_email']."'";
                                        $run_user = mysqli_query($con,$get_user);
                                        $row = mysqli_fetch_array($run_user);
                                        // Name concaetinations
                                        $user_fname = $row['user_fname'];
                                        $user_lname = $row['user_lname'];
                                        $name = $user_fname . ' ' .  $user_lname;
                                        $user_id = $row['user_id'];
                                        $user_name = $row['user_username'];
                                        $user_image = $row['user_image'];
                                        $user_country = $row['user_country'];
                                        $register_date = $row['register_date'];
                                        $last_login = $row['last_login'];
                                        // post counter
                                        $user_post = "SELECT * FROM posts WHERE user_id='$user_id'";
                                        $run_post = mysqli_query($con,$user_post);
                                        $post = mysqli_num_rows($run_post);

                                        //getting the number of unread messages
                                        $sel_msg = "SELECT * FROM messages where receiver='$user_id' AND status='unread' ORDER by 1 DESC";

                                        $run_msg = mysqli_query($con, $sel_msg);

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

                                            <p><a href='my_messages.php'>Messages ($count_msg)<a/></p>
                                            <p><a href='my_posts.php'>My Posts ($post)</a></p>
                                            <p><a href='edit_account.php'>Edit My Account</a></p>
                                            <p><a href='logout.php'>Logout</a></p>
                                            </div>
                                        ";
                                    ?>
                    </div>
                </div>
            </div>
            <!-- USER TIMELINE ENDS -->
            <!-- CONTENT TIMELINE STARTS -->
            <div id="content_timeline">
                <h2>All Registered Users on This Site:</h2>
                <br/>
                <?php 
                        $user = $_SESSION['user_email'];
                        $get_members = "SELECT * from users";
                        $run_members = mysqli_query($con,$get_members);
                
                        while($row=mysqli_fetch_array($run_members)){
                        $user_id = $row['user_id'];
                        $user_username = $row['user_username'];
                        $user_image = $row['user_image'];

                        echo "
                            <a href='user_profile.php?u_id=$user_id'>
                            <center><img src='user/user_images/$user_image' width='50'
                            height='50' title='$user_username'/></center>
                        ";
                        }
                    ?>
            </div>
        </div>
        <!-- CONTENT AREA ENDS -->
    </div>
    <!-- CONTAINER ENDS -->
    <h1>Welcome:
        <?php echo $_SESSION['user_email'];?>
    </h1>
</body>

</html>
<?php 


?>