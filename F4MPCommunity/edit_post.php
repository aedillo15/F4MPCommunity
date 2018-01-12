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
    <title>Welcome Artist!</title>
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
                                $user_name = $row['user_username'];
                                $user_image = $row['user_image'];
                                $user_country = $row['user_country'];
                                $register_date = $row['register_date'];
                                $last_login = $row['last_login'];
                    
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
                                    <p><strong>Name:</strong> $user_name</p>
                                    <p><strong>Country:</strong> $user_country</p>
                                    <p><strong>Last Login</strong> $last_login</p>
                                    <p><strong>Member Since:</strong> $register_date</p>
                                    
                                    <p><a href='my_messages.php?u_id=$user_id'>Messages($count_msg)/a></p>
                                    <p><a href='my_posts.php?u_id=$user_id'>My Posts</a></p>
                                    <p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>
                                    <p><a href='logout.php'>Logout</a></p>
                                    </div>
                                ";
                    ?>
                </div>
            </div>
            <!-- USER TIMELINE ENDS -->
            <!-- CONTENT TIMELINE STARTS -->
            <div id="content_timeline">
            <?php
                if(isset($_GET['post_id'])){
                    
                    $get_id = $_GET['post_id'];
                    
                    $get_post = "select * from posts where post_id='$get_id'";
                    
                    $run_post = mysqli_query($con,$get_post);
                    $row = mysqli_fetch_array($run_post);
                    
                    $post_title = $row['post_title'];
                    $post_con = $row['post_content'];
                }    
            ?>
                <form action="home.php?id=<?php echo $user_id;?>" method="post" id="f" id="ff">
                    <h2>Edit your Post:</h2>
                    <input type="text" name="title" value="<?php echo $post_title?>" size="82" required="required"/>
                    <br/>
                    <textarea cols="83" rows="4" name="content" placeholder="Share your creation to the world here">
                        <?php echo $post_con;?>
                    </textarea>
                    <br/>
                    <select name="topic">
                        <option>Select Topic</option>
                        <?php getTopics();?>
                    </select>
                    <input type="submit" name="update" value="Update Post"/>
                    </form>
                <?php
                if(isset($_POST['update'])){
                    
                    $title = $_POST['title'];
                    $content = $_POST['content'];
                    $topic = $_POST['topic'];
                    
                    $update_post = "UPDATE posts SET post_title='$title', post_content='$content', topic_id='$topic' WHERE post_id='$get_id'";
                    
                    $run_update = mysqli_query($con,$update_post);
                    if($run_update){
                        echo "<script>alert('Post has been updated!')</script>";
                        echo "<script>window.open('home.php','_self)</script>";        
                    }
                    
                }
   //             update_post();
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