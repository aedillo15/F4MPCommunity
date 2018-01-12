<table align="center" width="700" border="1" bgcolor="skyblue">

    <tr bgcolor="orange" border="1">
        <th>S.N</th>
        <th>Name</th>
        <th>Email</th>
        <th>Country</th>
        <th>Gender</th>
        <th>Image</th>
        <th>Delete</th>
        <th>Edit</th>
    </tr>
    <?php
    include("includes/connection.php");
    $sel_users = "SELECT * FROM users";
    $run_users = mysqli_query($con,$sel_users);
    
    $i = 0;
    while($row_users = mysqli_fetch_array($run_users)){
        
        $user_id = $row_users['user_id'];
        $user_name = $row_users['user_username'];
        $user_email = $row_users['user_email'];
        $user_country = $row_users['user_country'];
        $user_gender = $row_users['user_gender'];
        $user_image = $row_users['user_image'];
        $user_reg_date = $row_users['register_date'];
        $i = $i + 1;
        
    ?>
        <tr align="center">
            <td>
                <?php echo $i; ?>
            </td>
            <td>
                <?php echo $user_name; ?>
            </td>            
            <td>
                <?php echo $user_email; ?>
            </td>
            <td>
                <?php echo $user_country; ?>
            </td>
            <td>
                <?php echo $user_gender; ?>
            </td>
            <td><img src="../user/user_images/<?php echo $user_image;?>" width='50' height='50' /></td>
            <td><a href="delete_user.php?delete=<?php echo $user_id;?>">Delete</a></td>
            <td><a href="index.php?view_users&edit=<?php echo $user_id;?>">Edit</a></td>
        </tr>
        <?php } ?>
</table>
<?php
    if(isset($_GET['edit'])){
        
    $edit_id = $_GET['edit'];
        
    $sel_users = "SELECT * FROM users WHERE user_id='$edit_id'";
    $run_users = mysqli_query($con,$sel_users);
    $row_users = mysqli_fetch_array($run_users);
    if($row_users){
        $user_id = $row_users['user_id'];
        $user_pass = $row_users['user_pass'];
        $user_name = $row_users['user_username'];
        $user_country = $row_users['user_country'];
        $user_image = $row_users['user_image'];
        $user_reg_date = $row_users['register_date'];
        $user_email = $row_users['user_email'];
    }
        
        
?>
    <form action="" method="post" id='f' class="ff" enctype="mulitpart/form-data" align="center">
        <table width="600">
            <tr align="center">
                <td colspan="6">
                    <h2>Edit Your User:</h2>
                </td>
            </tr>
            <tr>
                <td align="right">Name:</td>
                <td><input type="text" name="u_name" required="required" value="<?php echo $user_name;?>" />
                </td>
            </tr>
            <tr>
                <td align="right">Password:</td>
                <td><input type="text" name="u_pass" required="required" value="<?php echo $user_pass;?>" /></td>
            </tr>
            <tr>
                <td align="right">Email:</td>
                <td><input type="email" name="u_email" required="required" value="<?php echo $user_email;?>" /></td>
            </tr>
            <tr>
                <td align="right">Country:</td>
                <td>
                    <select name="u_country">
                    <option><?php echo $user_country;?></option>
                    <option>Canada</option>
                    <option>United States of America</option>
                    <option>India</option>
                    <option>Pakistan</option>
                </select>
                </td>
            </tr>
            <tr>
                <td align="right">Photo:</td>
                <td>
                    <input type="file" name="u_image" required="required" />
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

        $u_name = $_POST['u_name'];
        $u_pass = $_POST['u_pass'];
        $u_email = $_POST['u_email'];
        $u_country = $_POST['u_country'];
        $u_image = $_POST['u_image']; 
        //$image_tmp = $_FILES['u_image']['tmp_name'];

        //move_uploaded_file($image_tmp, "../user/user_image/$u_image");

        $update = "UPDATE users set user_username='$u_name', user_pass='$u_pass',user_email='$u_email',user_country='$u_country', user_image='$u_image' where user_id='$edit_id'";

        $run = mysqli_query($con,$update);

        if($run) {
            echo "<script>alert('User has been updated!')</script>";
            echo "<script>window.open('index.php?view_users','_self')</script>";
        }
    }
?>