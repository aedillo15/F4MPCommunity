<?php 
session_start();
include("includes/connection.php");
include("functions/functions.php");

if(!isset($_SESSION['user_email'])){
    header("location: index:php");
}
else {

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
                                $get_user = "SELECT * from user where user_email = '".$_SESSION['user_email']."'";
                                $run_user = mysqli_query($con,$get_user);
                                $row = mysqli_fetch_array($run_user);
                                
                                $user_id = $row['user_id'];
                                $user_name = $row['user_name'];
                                $user_image = $row['user_image'];
                                $user_country = $row['user_country'];
                                $register_date = $row['register_date'];
                                $last_login = $row['last_login'];
                                echo "
                                    <center><img src='user/user_images/$user_image' width='200'
                                    height='200'/></center>
                                    <div id='mention'>
                                    <p><strong>Name:</strong> $user_name</p>
                                    <p><strong>Country:</strong> $user_country</p>
                                    <p><strong>Last Login</strong> $last_login</p>
                                    <p><strong>Member Since:</strong> $register_date</p>
                                    
                                    <p><a href='my_messages.php'>Messages</a></p>
                                    <p><a href='my_posts.php'>My Posts</a></p>
                                    <p><a href='edit_account.php'>Edit My Account</a></p>
                                    <p><a href='logout.php'>Logout</a></p>
                                    </div>
                                ";
                    ?>
                </div>
            </div>
            <!-- USER TIMELINE ENDS -->
            <!-- CONTENT TIMELINE STARTS -->
            <div id="content_timeline">
                <?php single_post();?>
            </div>
            <!-- CONTENT TIMELINE ENDS -->
        </div>
        <!-- CONTENT AREA ENDS -->
    </div>
    <!-- CONTAINER ENDS -->
    <h1>Welcome:
        <?php echo $_SESSION['user_email'];?>
    </h1>
</body>

</html>
<?php }?>