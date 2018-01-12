<?php 
include("../functions/functions.php");
include("includes/connection.php");
session_start();   
if(!isset($_SESSION['admin_email'])){
    header("location: admin_login.php");
}
else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Admin Panel</title>
    <link rel="stylesheet" href="admin_style.css" media="all"/>
</head>
<body>
    <div class="container">
        <div id="head">
            <img src="/images/bg2.jpg"/>
        </div>
        
        <div id="menu">
        </div>
        
        <div id="content">
        </div>
        
        <div id="sidebar">
            <h2>Manage Content:</h2>
            
            <ul id="menu">
                <li><a href="index.php?view_users">View Users</a></li>
                <li><a href="index.php?view_posts">View Posts</a></li>
                <li><a href="index.php?view_comments">View Comments</a></li>
                <li><a href="index.php?view_topics">View Topics</a></li>
                <li><a href="index.php?add_topic">Add New Topic</a></li>
                <li><a href="admin_logout.php">Admin Logout</a></li>
            </ul>
        </div>
        
        <div id="content">
            <h2 style="color:green; text-align:center; padding:5px">
            Welcome Admin: <?php echo $_SESSION['user_email'];?> Manage your community!
            </h2>
            <?php
            if(isset($_GET['view_users'])){
            include("includes/view_users.php");
            }           
            if(isset($_GET['view_posts'])){
            include("includes/view_posts.php");
            }
            ?>
        </div>
        
        <div id="foot">
            <h2 style="color:white; padding:15px; text-align:center;">Copyrights 2018 by F4MPCommunity</h2>
        </div>
    </div>
</body>
</html>

<?php } ?>