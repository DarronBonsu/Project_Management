<?php
    // Start the session to access session variables
    session_start();
    
    // Check if the 'name' session variable is set, if not, redirect to project.php
    if (!isset($_SESSION['name'])){
        header("Location: project.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Projects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" />
        <!-- Custom CSS -->
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <!-- Bootstrap Bundle JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JavaScript -->
        <script defer src="js/basic.js"></script>
    </head>
    <body>
        <!-- Main header -->
        <header id="main-header">
            <nav>
                <ul>
                    <!-- Add project link -->
                    <li><a class="reactive" href="">Add</a></li>
                    <!-- Update project link -->
                    <li><a href="update.php">Update</a></li>
                    <!-- Logout link -->
                    <li><a href="#" onclick="logout()">Log out</a></li>
                </ul>
            </nav>
        </header>

        <!-- Main content -->
        <main>
            <section class="boxes">
                <section id="center">
                    <!-- Add Project Form -->
                    <h3>Add Project</h3>
                    <form method="post" action="add.php" >
                        <section class="input-row">
                            <!-- Project title input -->
                            <section class="input-group">
                                <label>Title:</label>
                                <input name="title" type="text" placeholder="Enter project title" >
                            </section><br>

                            <!-- Project start date input -->
                            <section class="input-group">
                                <label for="sDate">Project start date:</label>
                                <input type="date" name="sDate" >
                            </section><br>

                            <!-- Project end date input -->
                            <section class="input-group">
                                <label for="sDate">Project end date:</label>
                                <input type="date" name="eDate" >
                            </section><br>

                            <!-- Project phase selection -->
                            <section class="input-group">
                                <label>Project phase:</label> 
                                <div>
                                    <input type="radio" name="phase" value="design" checked>
                                    <label for="design">Design</label>                                    
                                </div>
                                <div>
                                    <input type="radio" name="phase" value="development" >
                                    <label for="development">Development</label>
                                </div>
                                <div>
                                    <input type="radio" name="phase" value="testing" >
                                    <label for="testing">Testing</label>
                                </div>
                                <div>
                                    <input type="radio" name="phase" value="deployment" >
                                    <label for="deployment">Deployment</label>
                                </div>
                                <div>
                                    <input type="radio" name="phase" value="complete" >
                                    <label for="complete">Complete</label>
                                </div>
                            </section>
                        </section>
                        <br/>
                        <!-- Project description input -->
                        <section class="input-group">
                            <label>Description:</label>
                            <textarea id="textbox" name="textbox" placeholder="Enter description here"></textarea>
                        </section>
                        <!-- Add project button -->
                        <div class="button-container">
                            <button type="submit" value="add">Add project</button><br><br>
                        </div>
                        <!-- Hidden input to indicate form submission -->
                        <input type="hidden" name="submitted" value="True">
                    </form>

                    <?php
                        // Check if the form was submitted
                        if (isset($_POST['submitted'])){
                            // Retrieve form data
                            $title = isset($_POST['title']) ? $_POST['title'] : '';
                            $sdate = isset($_POST['sDate']) ? $_POST['sDate'] : '';
                            $edate = isset($_POST['eDate']) ? $_POST['eDate'] : '';
                            $des = isset($_POST['textbox']) ? $_POST['textbox'] : '';
                            $phase = isset($_POST['phase']) ? $_POST['phase'] : '';

                            // Validate form data and insert into database
                            if (!$title || !$sdate || !$edate || !$des) {
                                echo "<p style='color:red'>Please fill in all required fields.</p>";   
                            } elseif ($sdate > $edate) {
                                echo "<p style='color:red'>Please enter an end date that occurs after the start date.</p>";
                            } else {
                                try {
                                    // Include database connection script
                                    require_once("connectdb.php");
                                    
                                    // Get user ID from session
                                    $stat = $db->prepare('SELECT uid FROM users WHERE username = ?');
                                    $stat->execute(array($_SESSION['name']));
                                    $userId = $stat->fetchColumn();
                                    
                                    // Check if project title is already in use
                                    $stat = $db->prepare('SELECT * FROM projects WHERE title = ?');
                                    $stat->execute(array($title));
                                    
                                    if ($stat->rowCount() > 0) {
                                        echo "<p style='color:red'>This project title is already in use. Please choose another one.</p>";
                                    } else {
                                        // Insert project details into database
                                        $stat = $db->prepare("INSERT INTO projects VALUES (default,?,?,?,?,?,?)");
                                        $stat->execute(array($title, $sdate, $edate, $phase, $des, $userId));

                                        echo "<p style='color:green'>Project created.</p>";  
                                    }
                                } catch(PDOException $ex) {
                                    // Handle database errors
                                    echo "<p style='color:red'>Failed to connect to the database.</p>";
                                    echo($ex->getMessage());
                                }
                            }
                        }
                    ?>
                </section>    
            </section> 
        </main>
    </body>
</html>
