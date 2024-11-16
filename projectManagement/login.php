<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Projects</title>
        <!-- Meta tag for responsive design -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS for styling -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" />
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header id="main-header">
            <!-- Navigation bar -->
            <nav>
                <ul>
                    <!-- Navigation links -->
                    <li><a href="project.php">Projects</a></li>
                    <li><a class="reactive"  href="">Login/Register</a></li>
                </ul>
            </nav>
        </header>
        <main>
            <!-- Login and Register forms -->
            <section class="boxes">
                <!-- Left section for Login -->
                <section id="left">
                    <h3>Login</h3>
                    <!-- Login form -->
                    <form method="post" action="login.php">
                        <!-- Username input field -->
                        <section class="input-group">
                            <label for="l_name">Username:</label>
                            <input name="l_name" type="text" id="l_name" placeholder="Enter username"><br><br>
                        </section>
                        <!-- Password input field -->
                        <section class="input-group">
                            <label for="l_password">Password:</label>
                            <input name="l_password" type="password" id="l_password" placeholder="Enter password"><br><br>
                        </section>
                        <!-- Button to submit login -->
                        <div class="button-container">
                            <button type="submit" value="Login">Log in</button><br><br>
                        </div>
                        <!-- Hidden input to indicate form submission -->
                        <input type="hidden" name="submitted" value="True"><br><br>
                    </form>

                    <?php
                        //check if form has been submitted
                        if (isset($_POST['submitted'])){

                            //check if all fields are filled
                            if (!isset($_POST['l_name'], $_POST['l_password'])){
                                exit("fill in both username and password fields before trying to log in.");
                            }
                            
                            //connect to database
                            require_once("connectdb.php");

                            try{
                                //try find username in database
                                $stat = $db->prepare('SELECT password FROM users WHERE username = ?');
                                $stat->execute(array($_POST['l_name']));
                                
                                // check if a row with username is returned
                                if ($stat->rowCount()>0){  
                                    $row=$stat->fetch();

                                    //check for matching password
                                    if (password_verify($_POST['l_password'], $row['password'])){ 
                                        
                                        //start a session with username and go to loggedin page 
                                        session_start();
                                        $_SESSION["name"]=$_POST['l_name'];
                                        header("Location:add.php");
                                        exit();
                                    
                                    }
                                    //display error for wrong password
                                    else {
                                    echo "<p style='color:red'>Error logging in, password incorrect</p>";
                                    }
                                } else {
                                //display an error message for worng or no user
                                echo "<p style='color:red'>Error logging in, Username not found </p>";
                                }
                            }
                            catch(PDOException $ex) {
                                echo("Failed to connect to the database.<br>");
                                echo($ex->getMessage());
                                exit;
                            }

                            $name = isset($_POST['l_name'])?$_POST['l_name']:false;
                            $password = isset($_POST['l_password'])?password_hash($_POST['l_password'],PASSWORD_DEFAULT):false;
                        }
                    ?>
                </section>

                <!-- Right section for Register -->
                <section id="right">
                    <h3>Register</h3>
                    <!-- Register form -->
                    <form method="post" action="login.php">
                        <!-- Username input field -->
                        <section class="input-group">
                            <label for="name">Username:</label>
                            <input name="name" type="text" id="name" placeholder="Enter username"><br><br>
                        </section>
                        <!-- Email input field -->
                        <section class="input-group">
                            <label for="email">Email:</label>
                            <input name="email" type="text" id="email" placeholder="Enter email"><br><br>
                        </section>
                        <!-- Password input field -->
                        <section class="input-group">
                            <label for="password">Password:</label>
                            <input name="password" type="password" id="password" placeholder="Enter password"><br><br>
                        </section>
                        <!-- Confirm Password input field -->
                        <section class="input-group">
                            <label for="cpassword">Confirm Password:</label>
                            <input name="cpassword" type="password" id="cpassword" placeholder="Confirm password"><br><br>
                        </section>
                        <!-- Button to submit registration -->
                        <div class="button-container">
                            <button type="submit" value="Register">Register</button><br><br>
                        </div>
                        <!-- Hidden input to indicate form submission -->
                        <input type="hidden" name="submitted2" value="True"><br><br>
                    </form>

                    <!-- PHP code for processing registration form -->
                    <?php
                        if (isset($_POST['submitted2'])){

                            //connect to database
                            require_once("connectdb.php");
                    
                            //save input fields to variable 
                            $name = isset($_POST['name'])?$_POST['name']:false;
                            $password = isset($_POST['password'])?password_hash($_POST['password'],PASSWORD_DEFAULT):false;
                            $c_password = isset($_POST['cpassword'])?password_hash($_POST['cpassword'],PASSWORD_DEFAULT):false;
                            $email = isset($_POST['email'])?$_POST['email']:false;
                    
                            //check if all fields are filled
                            if(!($name && $password && $c_password && $email)){
                                echo "<p style='color:red'>please fill in all registary input fields before trying to create an account";
                            }
                    
                            //check if password is same as confirm password
                            elseif (!($_POST['cpassword']==$_POST['password'])){
                                echo "<p style='color:red'>passwords dont match";
                            }
                            
                            else{
                                try {
                                    //check if username is in database
                                    $stat = $db->prepare('SELECT * FROM users WHERE username = ?');
                                    $stat->execute(array($_POST['name']));
                                                
                                    // check if a row with username is returned and error message if it is
                                    if ($stat->rowCount() > 0) {  
                                        echo "<p style='color:red'>This username is already in use. Please select another or login to your account";
                                    }else {
                                        try {
                                            //search database for account maching email
                                            $stat = $db->prepare('SELECT * FROM users WHERE email = ?');
                                            $stat->execute(array($_POST['email']));
                                                
                                            // check if a row with email is returned
                                            if ($stat->rowCount() > 0) {  
                                                // display message if there is
                                                echo "<p style='color:red'>This email is already in use. Please select another or login to your account";
                                            } else {
                                                try {
                                                    // Register user by inserting user info
                                                    $stat = $db->prepare("INSERT INTO users VALUES (default,?,?,?)");
                                                    $stat->execute(array($name, $password, $email));
                                                    
                                                    $id = $db->lastInsertId();
                                                } catch (PDOException $ex) {
                                                    echo "Failed to connect to the database.<br>";
                                                    echo $ex->getMessage();
                                                    exit;
                                                }
                                            }
                                        } catch (PDOException $ex) {
                                            echo "Failed to connect to the database.<br>";
                                            echo $ex->getMessage();
                                            exit;
                                        }
                                    }
                                } catch (PDOException $ex) {
                                    echo "Failed to connect to the database.<br>";
                                    echo $ex->getMessage();
                                    exit;
                                }                               
                            }
                        }
                    ?>
                </section>
            </section>
        </main>
    </body>
</html>
