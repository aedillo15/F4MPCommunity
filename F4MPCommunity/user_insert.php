<?php
include("includes/connection.php");

if(isset($_POST['sign_up'])){
            global $con;
            // Initializing variables 
            $fname = "";
            $lname = "";
            $uname = "";
            $pass = "";
            $pass2 = "";
            $country = "";
            $gender = "";
            $b_day = "";
            $date = "";
            $posts = "";
            $status = "";
            $error_array = array();
    
            // Registration form values
    
            // First Name
            $fname = strip_tags($_POST['user_firstname']); // Remove html tags
            $fname = str_replace(' ','',$_POST['user_firstname']); // remove spaces
            $fname = ucfirst(strtolower($fname)); // upper case first letter
            $fname = mysqli_real_escape_string($con, $_POST['user_firstname']); // Secure string
            $_SESSION['user_firstname'] = $fname; // Store first name into session variable

            // Last Name
            $lname = strip_tags($_POST['user_lastname']); // Remove html tags
            $lname = str_replace(' ','',$_POST['user_lastname']); // remove spaces
            $lname = ucfirst(strtolower($lname)); // upper case first letter
            $lname = mysqli_real_escape_string($con, $_POST['user_lastname']); // Secure string
            $_SESSION['user_lastname'] = $fname; // Store first name into session variable-
        
            // Username
            $uname = strip_tags($_POST['user_username']); // Remove html tags
            $uname = str_replace(' ','',$_POST['user_username']); // remove spaces
            $uname = ucfirst(strtolower($uname)); // upper case first letter
            $uname = mysqli_real_escape_string($con, $_POST['user_username']); // Secure string
    
            // Password
            $pass = strip_tags($_POST['user_pass']); // Remove html tags
            
            // Email
            $email = strip_tags($_POST['user_email']); // Remove html tags
            $email = str_replace(' ','',$_POST['user_email']); // remove spaces
            $email = ucfirst(strtolower($email)); // upper case first letter
            $email = mysqli_real_escape_string($con, $_POST['user_email']);            
            $_SESSION['user_email'] = $email;            
            
            // Country
            $country = strip_tags($_POST['user_country']); // Remove html tags
            $country = mysqli_real_escape_string($con, $_POST['user_country']);
    
    
            // Birthday
            $b_day = mysqli_real_escape_string($con, $_POST['user_birthday']);
            $date = date("m-d-Y");
            $status = "unverified";
            $posts = "No";
    
                // Check if the email is in the valid format
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
                    
                    // Does the email exist? Query
                    $e_check = mysqli_query($con,"SELECT user_email FROM users WHERE user_email='$email'");
                    
                    // Counts the number of rows returned
                    $num_rows = mysqli_num_rows($e_check);
                }
                    if($num_rows > 0){
                        array_push($error_array, "Email already in use<br>");
                    }
                    else{
                    array_push($error_array, "Invalid email format<br>");
                    }
            if(strlen($pass<8)){ // Validating the boxes and required
                echo "<script>alert('Password should be minimum of 8 characters')</script>";
                exit();                
            }else if (strlen($lname) > 25 || strlen($lname) < 2){
                array_push($error_array, "Your last name must be between 2 and 25 characters");
                
            }else if (strlen($fname) > 25 || strlen($fname) < 2){
                array_push($error_array, "Your first name must be between 2 and 25 characters");
            }else if (preg_match('/[^A-Za-z0-9]/', $pass)){
                array_push($error_array, "Your password can only contain english characters or numbers");
            }
            else if (strlen($pass) > 30 || strlen($pass) < 5) {
                array_push($error_array, "Your password must be between 5 and 30 characters");
            }
            // Once validated insert users information
            else{
                $insert = "INSERT INTO users (user_fname,user_lname,user_username, user_pass,user_email,user_country,user_b_day,user_image,register_date,last_login,status,posts) values ('$fname','$lname','$uname','$pass','$email','$country','$b_day','favicon.png',NOW(),NOW(),'$status','$posts')";
                $run_insert = mysqli_query($con,$insert);
                $_SESSION['user_email'] = $email;
                    if($run_insert){
                        echo "<script>alert('Registration Successful!')</script>";  
                        echo "<script>window.open('home.php','_self')</script>
                        ";
                    }
                
            }    
            
            $get_email = "select user_email from users where user_email='$email'";
            $run_email = mysqli_query($con, $get_email);
            $check = mysqli_num_rows($run_email);
            if($check == 1){
                echo "<script>alert('Email is already registered, please try another')</script>";
                exit();
            }
    

        }
?>