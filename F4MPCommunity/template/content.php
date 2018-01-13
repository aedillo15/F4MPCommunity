        <! -- CONTENT STARTS HERE -->
        <div id="content">
            <div>
                <div id="sidecontent">
                    <img src="images/bg2.jpg" width="400px" height="200px" style="float:left; margin-right:40px;" />
                </div>
            </div>
                <div id="form2">
                    <form action="home.php" method="post" id="form1">
                        <h2>Sign Up Here!</h2>
                        <table>
                            <tr>
                                <td align="right">First Name:</td>
                                <td>
                                    <input type="text" name="user_firstname" placeholder="Enter your first name" required="required"/>
                                </td>
                            </tr>                            
                            <tr>
                                <td align="right">Last Name:</td>
                                <td>
                                    <input type="text" name="user_lastname" placeholder="Enter your last name" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Username:</td>
                                <td>
                                    <input type="text" name="user_username" placeholder="Enter your username" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Password:</td>
                                <td><input type="password" name="user_pass" placeholder="Enter your password" required="required"/>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Email:</td>
                                <td><input type="email" name="user_email" placeholder="Enter your eMail" required="required"/>
                                </td>
                            </tr>                           
                            <tr>
                                <td align="right">Country:</td>
                                <td>
                                    <select name="user_country" required="required">
                                    <?php 
                                        include("includes/country_populate.php")
                                    ?>
                                </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Birthday:</td>
                                <td>
                                    <input type="date" name="user_birthday" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <button name="sign_up">Sign Up</button>
                                </td>
                            </tr>
                    <?php 
                        include("user_insert.php");
                    ?>
                        </table>
                    </form>
                </div>
            </div>
        <! -- CONTENT ENDS -->