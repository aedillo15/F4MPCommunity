<table align="center" width="800" border="1" bgcolor="skyblue">

    <tr bgcolor="orange" border="1">
        <th>Post ID</th>
        <th>Title</th>
        <th>Post</th>
        <th>Author</th>
        <th>Date</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>
    <?php
    include("includes/connection.php");
    $select_posts = "SELECT * FROM posts ORDER by 1 DESC";
    $run_posts = mysqli_query($con,$select_posts);
    
    $i = 0;
    while($row_posts = mysqli_fetch_array($run_posts)){
        
        $post_id = $row_posts['post_id'];
        $user_id = $row_posts['user_id'];
        $post_content = $row_posts['post_content'];
        $post_title = $row_posts['post_title'];
        $post_date = $row_posts['post_date'];
        $i++;
        
        $select_user = "SELECT * from users WHERE user_id='$user_id'";
        $run_user = mysqli_query($con,$select_user);
        
         while($row_users = mysqli_fetch_array($run_user)){
        
        $user_name = $row_users['user_username'];
        
        
    ?>
        <tr align="center">
            <td>
                <?php echo $i; ?>
            </td>
            <td>
                <?php echo $post_title; ?>
            </td>            
            <td>
                <?php echo $post_content; ?>
            </td>
            <td>
                <?php echo $user_name; ?>
            </td>
            <td>
                <?php echo $post_date; ?>
            </td>
            <td><a href="index.php?view_posts&delete=<?php echo $post_id;?>">Delete</a></td>
            <td><a href="index.php?view_posts&edit=<?php echo $post_id;?>">Edit</a></td>
        </tr>
        <?php } } ?>
</table>
<!-- IF EDIT BUTTON IS CLICKED AND THE WHAT EDIT IS EQUAL TO POST ID -->
<?php
    if(isset($_GET['edit'])){
        
    $edit_id = $_GET['edit'];
        
    $sel_posts = "SELECT * FROM posts WHERE post_id='$edit_id'";
    $run_posts = mysqli_query($con,$sel_posts);
    $i=0;
        
    while($row_posts = mysqli_fetch_array($run_posts)){
    
    $post_new_id = $row_posts['post_id'];
    $post_title = $row_posts['post_title'];
    $post_content = $row_posts['post_content'];
    
?>
                <h2 style="padding:5px;";>Update the selected Post</h2>
                  <form action="" method="post" id="f" class="ff" enctype="multipart/form-data">
                      
                    <input type="text" name="title" size="82" value="<?php echo $post_title;?>"/>
                    <br/>
                      <textarea cols="83" rows="4" name="content"><?php echo $post_content;?></textarea>

                    <br/>
                    <select name="topic">
                        <option>Select Topic</option>
                        <?php getTopics();?>
                    </select>
                    <input type="submit" name="update" value="Update Post"/>
                </form>
        <?php }} ?>
    <?php 
    if(isset($_POST['update'])){

        $title = $_POST['title'];
        $content = $_POST['content'];
        $topic = $_POST['topic'];
        
        $update = "UPDATE posts set post_title='$title', post_content='$content', topic_id='$topic', post_date=NOW() where post_id='$post_new_id'";

        $run = mysqli_query($con,$update);

        if($run) {
            echo "<script>alert('Post has been updated!')</script>";
            echo "<script>window.open('index.php?view_posts','_self')</script>";
        }
    }
    if(isset($_GET['delete'])){
        
        $delete_id = $_GET['delete'];
        
        $delete = "DELETE from posts WHERE post_id='$delete_id'";
        $run_del = mysqli_query($con,$delete);
         if($run_del) {
            echo "<script>alert('Post has been deleted!')</script>";
            echo "<script>window.open('index.php?view_posts','_self')</script>";
        }
        
    }
?>