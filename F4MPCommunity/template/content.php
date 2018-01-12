        <! -- CONTENT STARTS HERE -->
        <div id="content">
            <div>
                <div id="sidecontent">
                    <img src="images/bg2.jpg" width="400px" height="200px" style="float:left; margin-right:40px;" />
                </div>
            </div>
                <div id="form2">
                    <form action="" method="post">
                        <h2>Sign Up Here!</h2>
                        <table>
                            <tr>
                                <td align="right">First Name:</td>
                                <td>
                                    <input type="text" name="u_fname" placeholder="Enter your first name" required="required"/>
                                </td>
                            </tr>                            
                            <tr>
                                <td align="right">Last Name:</td>
                                <td>
                                    <input type="text" name="u_lname" placeholder="Enter your last name" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Username:</td>
                                <td>
                                    <input type="text" name="u_username" placeholder="Enter your username" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Password:</td>
                                <td><input type="password" name="u_pass" placeholder="Enter your password" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Confirm Password:</td>
                                <td><input type="password" name="u_pass2" placeholder="Enter your password again to confirm" required="required" value="" /></td>
                            </tr>
                            <tr>
                                <td align="right">Email:</td>
                                <td><input type="email" name="u_email" placeholder="Enter your eMail" required="required"/>
                                </td>
                            </tr>                           
                            <tr>
                                <td align="right">Confirm Email:</td>
                                <td><input type="email" name="u_email2" placeholder="Confirm your eMail" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Country:</td>
                                <td>
                                    <select name="u_country" required="required">
                                    <?php 
                                        include("includes/country_populate.php")
                                    ?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Birthday:</td>
                                <td>
                                    <input type="date" name="u_birthday" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <button name="sign_up">Sign Up</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <?php 
                            include("user_insert.php");
                    ?>
                </div>
            </div>
        <! -- CONTENT ENDS -->