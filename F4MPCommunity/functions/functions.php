<?php
    $con = mysqli_connect("localhost","root","","f4community") or die("Connection was not established");
        //TODO Create a method for creating a new topic to the topic table
        // function for getting topics
        function insertUser()
        {
            if(isset($_POST['sign_up'])){
                global $con;
                $firstname = $_POST['user_firstname'];   
                $lastname = $_POST['user_lastname'];   
                $username = $_POST['user_username'];   
                $password = $_POST['user_pass'];   
                $email = $_POST['user_email'];   
                $country = $_POST['user_country'];   
                $birthday = $_POST['user_birthday'];
                $status = "unverified";
                $posts = "No";
            
                $get_email = "SELECT * FROM USERS WHERE USER_EMAIL='$email'";
                $run_email = mysqli_query($con,$get_email);
                $check = mysqli_num_rows($run_email);
            
                if($check==1)
                {
                    echo "<h2>This email already exists.</h2>"; 
                    exit();
                }
                else
                {
                    $insert = "INSERT INTO users(user_fname,user_lname,user_username,user_pass,user_email,user_country,user_b_day,user_image,register_date,last_login,status,posts) VALUES ('$firstname','$lastname','$username','$password','$email','$country','$birthday',favicon.png,NOW(),NOW(),'$status','$posts')";
                    $run = mysqli_query($con,$insert);    
                }
            }
        }
        function getTopics()
        {
            // Declaring the connection, global -> accessible to the method. //
            global $con;
            // Query to fetch the topics. //
            $get_topics = "select * from topics";
            // Run the query through said connection and $get_topics query. //
            
            $run_topics = mysqli_query($con,$get_topics);
            // While the topics are being fetched.
            while($row=mysqli_fetch_array($run_topics))
            {
                // Assigning variables to the data base columns. // 
                $topic_id = $row['topic_id'];
                $topic_title = $row['topic_title'];
                if($_GET['topic'])
                {
                    $topic_id = $_GET['topic'];
                }
            // Populating the option box with the value and the title of the topic. //
            echo "<option value='$topic_id'>$topic_title</option>";
            }
        }

        // Function for inserting posts into the database
        function insertPost()
        {
            // Set posts to yes
            // If the div 'sub' is clicked run ->
            if(isset($_POST['sub'])){
                global $con;
                // User ID has to be fetched for the method
                global $user_id;
                $title = addslashes($_POST['title']);
                $content = addslashes($_POST['content']);
                $topic = $_POST['topic'];
                // Inserting textareas posts to database  
                $insert = "INSERT INTO posts(user_id,topic_id,post_title,post_content,post_date) VALUES ('$user_id','$topic','$title','$content',NOW())";
                $run = mysqli_query($con,$insert);
                
                if($content==''){
                    echo "<h2>Please enter topic description</h2>";
                    exit();
                }
                else if ($topic=='Select Topic'){
                    echo "<h2>Please select a topic or create a topic";
                }
                else{     
                    echo "<h3>Posted to timeline, thank you for creating.</h3>";
                    $update = "update users set posts='yes' where user_id='$user_id'";
                    $run_update = mysqli_query($con,$update);
                }
            }
        }
            // fetching the posts and fetchign the user information to be posted 
            function get_posts()
            {
                global $con;
                
                $per_page=5;
                
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                    else
                    {
                        $page=1;
                    }
                    $start_from = ($page-1) * $per_page;

                    $get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";

                    $run_posts = mysqli_query($con, $get_posts);

                    while($row_posters=mysqli_fetch_array($run_posts)){

                        $post_id = $row_posters['post_id'];
                        $user_id = $row_posters['user_id'];
                        $post_title = $row_posters['post_title'];
                        $content = $row_posters['post_content'];
                        $post_date = $row_posters['post_date'];

                        //getting the user who has posted the thread
                        $user = "SELECT * FROM users WHERE user_id='$user_id' AND posts='yes'";
                        // user is not being fetched
                        $run_user = mysqli_query($con,$user);
                        $row_user = mysqli_fetch_array($run_user);
                        $user_name = $row_user['user_username'];
                        $user_image = $row_user['user_image'];

                        //now displaying all at once
                        echo"<div id='posts'>
                        
                        <p><img src='user/user_images/$user_image' width='50' height='50'></p>
                        <h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h3>$post_title</h3>
                        <p>$post_date</p>
                        <p>$content</p>
                        <a href='single.php?post_id=$post_id' style='float:right;'><button>See Replies or Reply to This</button></a>

                        </div><br/>
                        ";

                    }
                    include("pagination.php");
                    }
        // function for getting the categories or topics
        function get_Cats(){
             global $con;
                
                $per_page=5;
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                    else
                    {
                        $page=1;
                    }
                    $start_from = ($page-1) * $per_page;
                    if (isset($_GET['topic'])){
                        $topic_id = $_GET['topic'];
                    }
                    
                    $get_posts = "select * from posts where topic_id='$topic_id' ORDER by 1 DESC LIMIT $start_from, $per_page";

                    $run_posts = mysqli_query($con, $get_posts);

                    while($row_posts=mysqli_fetch_array($run_posts)){

                        $post_id = $row_posts['post_id'];
                        $user_id = $row_posts['user_id'];
                        $post_title = $row_posts['post_title'];
                        $content = $row_posts['post_content'];
                        $post_date = $row_posts['post_date'];

                        //getting the user who has posted the thread
                        $user = "select * from users where user_id='$user_id' AND posts='yes'";

                        $run_user = mysqli_query($con,$user);

                        $row_user = mysqli_fetch_array($run_user);

                        $user_name = $row_user['user_username'];

                        $user_image = $row_user['user_image'];

                        //now displaying all at once
                        echo"<div id='posts'>

                        <p><img src='user/user_images/$user_image' width='50' height='50'></p>
                        <h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
                        <h3>$post_title</h3>
                        <p>$post_date</p>
                        <p>$content</p>
                        <a href='single.php?post_id=$post_id' style='float:right;'><button>See Replies or Reply to This</button></a>

                        </div><br/>
                        ";

                    }
                    include("pagination.php");
                    }
            // function for the single post where people can reply and comment
            function single_post(){

            if(isset($_GET['post_id'])){
                global $con;    
                $get_id = $_GET['post_id'];

                $get_posts = "select * from posts where post_id='$get_id'";

                $run_posts = mysqli_query($con, $get_posts);

                $row_posts=mysqli_fetch_array($run_posts);

                    $post_id = $row_posts['post_id'];
                    $user_id = $row_posts['user_id'];
                    $post_title = $row_posts['post_title'];
                    $content = $row_posts['post_content'];
                    $post_date = $row_posts['post_date'];

                    //getting the user who has posted the thread
                    $user = "select * from users where user_id='$user_id' AND posts='yes'";

                    $run_user = mysqli_query($con,$user);
                    //getting user session
                    $row_user = mysqli_fetch_array($run_user);
                    $user_name = $row_user['user_username'];
                    $user_image = $row_user['user_image'];

                    // getting the user session
                    $_SESSION['user_email'];
                    $get_com = "SELECT * from users where user_email = '".$_SESSION['user_email']."'";
                    $run_com = mysqli_query($con,$get_com);
                    $row = mysqli_fetch_array($run_com);
                    $user_com_id = $row_user['user_id'];
                    $user_com_name = $row_user['user_username'];
                    $user_image = $row_user['user_image'];
                    //now displaying all at once
                    echo"
                    <div id='posts'>
                        <p><img src='user/user_images/$user_image' width='50' height='50'></p>
                        <h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
                        <h3>$post_title</h3>
                        <p>$post_date</p>
                        <p>$content</p>
                    </div>
                    ";
                include("comments.php"); // outside functions directory
                echo "
                    <form action='' method='post' id='reply'>
                    <textarea cols='50' rows='5' name='comment' placeholder='Write your reply'></textarea><br/>
                    <input type='submit' name='reply' value='Reply to This'/>
                    </form>
                    ";
                
                if(isset($_POST['reply'])){
                    $comment = $_POST['comment'];
                    
                    $insert = "INSERT INTO comments(post_id,user_id,comment,date) VALUES ('$post_id','$user_id', '$comment', NOW())";
                    $run = mysqli_query($con,$insert);
                    echo "<h2>Your Reply was added! </h2>";   
 
                }
            }
        }
    
        // function for getting search results
       function GetResults(){
             global $con;
            if(isset($_GET['user_query'])){
                $search_term = $_GET['user_query'];
            }
                    $get_posts = "select * from posts where post_title LIKE '%$search_term%' ORDER by 1 DESC LIMIT 5";

                    $run_posts = mysqli_query($con, $get_posts);
                    
                    $count_result = mysqli_num_rows($run_posts);
                    
                    $select_user = "select * from users where user_username LIKE '%$search_term%' ORDER by 1 DESC LIMIT 5";
           
                    $run_user = mysqli_query($con,$select_user);
           
                    $count_user = mysqli_num_rows($run_user);
        

           
                    if($count_result == 0){    
                        echo "<h3 style='background:black; color:white; padding 10px;'> Sorry, we do not have results for this keyword, please search again!</h3>
                        ";
                    }
                    while($row_user=mysqli_fetch_array($run_user)){
                    $id = $row_user['user_id'];
                    $image = $row_user['user_image'];
                    $username = $row_user['user_username'];
                        
                     echo "
                            <a href='user_profile.php?u_id=$id'>
                            <center><img src='user/user_images/$image' width='50'
                            height='50' title='$username'/></center>
                        ";
                    }
                    
                    // fetching the users post based from previously fetched
                    while($row_posts=mysqli_fetch_array($run_posts)){

                        $post_id = $row_posts['post_id'];
                        $user_id = $row_posts['user_id'];
                        $post_title = $row_posts['post_title'];
                        $content = $row_posts['post_content'];
                        $post_date = $row_posts['post_date'];

                        //getting the user who has posted the thread
                        $user = "select * from users where user_id='$user_id' AND posts='yes'";

                        $run_user = mysqli_query($con,$user);

                        $row_user = mysqli_fetch_array($run_user);

                        $user_name = $row_user['user_username'];

                        $user_image = $row_user['user_image'];

                        //now displaying all at once
                        echo"<div id='posts'>

                        <p><img src='user/user_images/$user_image' width='50' height='50'></p>
                        <h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
                        <h3>$post_title</h3>
                        <p>$post_date</p>
                        <p>$content</p>
                        <a href='single.php?post_id=$post_id' style='float:right;'><button>See Replies or Reply to This</button></a>

                        </div><br/>
                        ";

                    }
                    }
function user_posts(){ 
    global $con;

    global $user_id;

    if (isset($_GET['user_id'])){
        $user_id = $_GET['user_id'];
    }
    $get_posts = "select * from posts where user_id='$user_id' ORDER by 1 DESC LIMIT 5";

    $run_posts = mysqli_query($con, $get_posts);

    while($row_posts=mysqli_fetch_array($run_posts)){

        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $post_title = $row_posts['post_title'];
        $content = $row_posts['post_content'];
        $post_date = $row_posts['post_date'];

        //getting the user who has posted the thread
        $user = "select * from users where user_id='$user_id' AND posts='yes'";

        $run_user = mysqli_query($con,$user);

        $row_user = mysqli_fetch_array($run_user);

        $user_name = $row_user['user_username'];

        $user_image = $row_user['user_image'];

        //now displaying all at once
        echo"<div id='posts'>

        <p><img src='user/user_images/$user_image' width='50' height='50'></p>
        <h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
        <h3>$post_title</h3>
        <p>$post_date</p>
        <p>$content</p>
        <a href='single.php?post_id=$post_id' style='float:right;'><button>View</button></a>
        <a href='edit_post.php?post_id=$post_id' style='float:right;'><button>Edit</button></a>
        <a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button>Delete</button></a>

        </div><br/>
        ";

        include("delete_post.php");

    }
                    }
// User profile display called on user_profile.php
function user_profile(){
    
    if(isset($_GET['u_id'])){
        
        global $con;
        $user_id = $_GET['u_id'];
        
        $select = "SELECT * from USERS WHERE user_id='$user_id'";
        $run = mysqli_query($con,$select);
        $row = mysqli_fetch_array($run);
        
        $id = $row['user_id'];
        $image = $row['user_image'];
        $username = $row['user_username'];
        $userfname = $row['user_fname'];
        $userlname = $row['user_lname'];
        $country = $row['user_country'];
        $gender = $row['user_gender'];
        $last_login = $row['last_login'];
        $register_date = $row['register_date'];
        $msg = "Send Message";
        
        echo "<div id='user_profile'>
                <img src='user/user_images/$image' width='150' height'150'/>
                <br/>
            
                <p><strong>Username:</strong> $username </p><br/>
                <p><strong>Gender:</strong> $gender </p><br/>
                <p><strong>Country:</strong> $country </p><br/>
                <p><strong>Last Login:</strong> $last_login </p><br/>
                <p><strong>Member Since:</strong> $register_date </p><br/>
                <a href='messages.php?u_id=$id'><button>$msg</button</a><hr>
                ";

    }
    new_members();
    
    echo "</div>";
}

function new_members(){
    global $con;
    
    $user = "SELECT * from USERS LIMIT 0,20";
    
    $run_user = mysqli_query($con,$user);
    
    echo "<br/><h2>New members on this site:</h2><hr>";
    while ($row_user=mysqli_fetch_array($run_user)){
        
        $user_id = $row_user['user_id'];
        $user_name = $row_user['user_username'];
        $user_image = $row_user['user_image'];
        
        echo "
        <span>
        <a href='user_profile.php?u_id=$user_id'>
        <img src='user/user_images/$user_image' width='50' height='50' title='$user_name' style='float:left'/>
        </a>
        </span>
        ";

    }
}
?>