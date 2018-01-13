<table align="center" width="700" border="1" bgcolor="skyblue">

    <tr bgcolor="orange" border="1">
        <th>Topic ID</th>
        <th>Topic</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>
    <?php
    include("includes/connection.php");
    $select_topics = "SELECT * FROM topics";
    $run_topics = mysqli_query($con,$select_topics);
    
    $i = 0;
    while($row_topics = mysqli_fetch_array($run_topics)){
        
        $topic_id = $row_topics['topic_id'];
        $title = $row_topics['topic_title'];
        $i = $i + 1;
        
    ?>
        <tr align="center">
            <td>
                <?php echo $topic_id; ?>
            </td>
            <td>
                <?php echo $title; ?>
            </td>            
            <!--<td><img src="../user/user_images/<?php echo $user_image;?>" width='50' height='50' /></td> -->
            <td><a href="index.php?view_topics&delete=<?php echo $topic_id;?>">Delete</a></td>
            <td><a href="index.php?view_topics&edit=<?php echo $topic_id;?>">Edit</a></td>
        </tr>
        <?php } ?>
</table>
<?php
    if(isset($_GET['edit'])){
        
    $edit_id = $_GET['edit'];
        
    $select_topic = "SELECT * FROM topics WHERE topic_id='$topic_id'";
    $run_topic = mysqli_query($con,$select_topic);
    $row_topic = mysqli_fetch_array($run_topic);
    if($row_topic){
        $topic_id = $row_topic['topic_id'];
        $title = $row_topic['topic_title'];
    }
        
        
?>
    <form action="" method="post" id='f' class="ff" enctype="mulitpart/form-data" align="center">
        <table width="600">
            <tr align="center">
                <td colspan="6">
                    <h2>Edit the Topic:</h2>
                </td>
            </tr>
            <tr>
                <td align="right">Topic Title:</td>
                <td><input type="text" name="topic_title" required="required" value="<?php echo $title;?>" />
                </td>
            </tr>
            <tr align="center">
                <td colspan="6">
                    <input type="submit" name="update" value="Update" />
                </td>
            </tr>
        </table>
    </form>
    <?php } ?>
<?php 
    if(isset($_POST['update'])){

        $title = $_POST['topic_title'];

        $update = "UPDATE topics set topic_title='$title' where topic_id='$topic_id'";

        $run = mysqli_query($con,$update);

        if($run) {
            echo "<script>alert('Topic has been updated!')</script>";
            echo "<script>window.open('index.php?view_comments','_self')</script>";
        }
    }
    if(isset($_GET['delete'])){
        
        $get_id = $_GET['delete'];
        
        $delete = "delete from topics where topic_id='$get_id'";
        $run_delete = mysqli_query($con,$delete);
        
        echo "<script>alert('Topic was deleted!')</script>";
        
        echo "<script>window.open('index.php?view_topics','_self')</script>";
    }
?>