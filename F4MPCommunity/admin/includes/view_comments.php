<table align="center" width="800" border="1" bgcolor="skyblue">

    <tr bgcolor="orange" border="1">
        <th>Comment ID</th>
        <th>Post ID</th>
        <th>User</th>
        <th>Comment</th>
        <th>Date</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>
    <?php
    include("includes/connection.php");
    $select_comments = "SELECT * FROM comments ORDER by 1 DESC";
    $run_comments = mysqli_query($con,$select_comments);
    
    $i = 0;
    while($row_comments = mysqli_fetch_array($run_comments)){
        
        $comment_id = $row_comments['comment_id'];
        $post_id = $row_comments['post_id'];
        $user_id = $row_comments['user_id'];
        $comment = $row_comments['comment'];
        $date = $row_comments['date'];
        $i = $i + 1;
        
        
    ?>
        <tr align="center">
            <td>
                <?php echo $comment_id; ?>
            </td>
            <td>
                <?php echo $post_id; ?>
            </td>            
            <td>
                <?php echo $user_id; ?>
            </td>
            <td>
                <?php echo $comment; ?>
            </td>
            <td>
                <?php echo $date; ?>
            </td>
            <td><a href="index.php?view_posts&delete=<?php echo $comment_id;?>">Delete</a></td>
            <td><a href="index.php?view_posts&edit=<?php echo $comment_id;?>">Edit</a></td>
        </tr>
        <?php } ?>
</table>
<!-- IF EDIT BUTTON IS CLICKED AND THE WHAT EDIT IS EQUAL TO POST ID -->
<?php
    if(isset($_GET['edit'])){
        
    $edit_id = $_GET['edit'];
        
    $sel_comment = "SELECT * FROM comment WHERE comment_id='$edit_id'";
    $run_comment = mysqli_query($con,$sel_comment);
    $i=0;
        
    while($row_comment = mysqli_fetch_array($run_comment)){
    
    $comment_id = $row_comment['comment_id'];
    $post_id = $row_comment['post_id'];
    $user_id = $row_comment['user_id'];
    $comment = $row_comment['comment'];
    $post_content = $row_comment['date'];
    
?>
                <h2 style="padding:5px;";>Update the selected comment</h2>
                  <form action="" method="post" id="f" class="ff" enctype="multipart/form-data">
                      
                    <input type="text" name="Commentee" size="82" value="<?php echo $user_id;?>"/>
                    <br/>
                      <textarea cols="83" rows="4" name="content"><?php echo $comment;?></textarea>

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
        
        $update = "UPDATE comments set post_title='$title', post_content='$content', topic_id='$topic', post_date=NOW() where post_id='$post_new_id'";

        $run = mysqli_query($con,$update);

        if($run) {
            echo "<script>alert('Post has been updated!')</script>";
            echo "<script>window.open('index.php?view_comments','_self')</script>";
        }
    }
    if(isset($_GET['delete'])){
        
        $delete_id = $_GET['delete'];
        
        $delete = "DELETE from posts WHERE post_id='$delete_id'";
        $run_del = mysqli_query($con,$delete);
         if($run_del) {
            echo "<script>alert('Comment has been deleted!')</script>";
            echo "<script>window.open('index.php?view_comments','_self')</script>";
        }
        
    }
?>