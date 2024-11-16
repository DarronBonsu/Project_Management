<?php
    // Start or resume the session
    session_start();

    // If the 'name' session variable is not set, redirect to project.php
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
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom JS -->
        <script defer src="js/basic.js"></script>
    </head>
    <body>
        <!-- Header Section -->
        <header id="main-header">
            <nav>
                <ul>
                    <!-- Navigation Links -->
                    <li><a href="add.php">Add</a></li>
                    <li><a class="reactive" href="">Update</a></li>
                    <li><a href="#" onclick="logout()">Log out</a></li>
                </ul>
            </nav>
        </header>
        <!-- Main Content Section -->
        <main>
            <section class="boxes">
                <!-- Left Section -->
                <section id="left">
                    <h3>Search</h3>
                    <!-- Search Form -->
                    <form method="post" action="update.php">
                        <section class="input-group">
                            <label>Title:</label>
                            <input name="title" type="text" placeholder="Enter project title">
                        </section><br>
                        <section class="input-group">
                            <br><label for="sDate">Project start date:</label>
                            <input type="date" name="sDate">
                        </section><br>
                        <button type="submit" value="Search project">Search project</button><br><br>
                        <input type="hidden" name="submitted2" value="True"/>
                    </form>
                    <h3>Search results</h3>
                    <!-- Search Results Display -->
                    <?php
                        // Handling form submission for search
                        if (isset($_POST['submitted2'])){
                            require_once ('connectdb.php'); 

                            // Retrieve search parameters
                            $title = isset($_POST['title']) ? $_POST['title'] : '';
                            $sdate = isset($_POST['sDate']) ? $_POST['sDate'] : '';

                            // If no search parameters provided, unset the submission flag
                            if(!($title) && !($sdate)){
                                unset($_POST['submitted2']);
                            }
                            
                            // Search projects by title and start date
                            if ($title && $sdate) {
                                try {
                                    $query = "SELECT * FROM projects WHERE title LIKE CONCAT('%', ?, '%') AND start_date = ?";
                                    $statement = $db->prepare($query);
                                    $statement->execute(array($title, $sdate));
                            
                                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                            
                                    if ($rows) {
                                        ?>
                                        <table cellspacing="0" cellpadding="5" id="myTable">
                                            <tr>
                                                <th align='left'><b>Project name</b></th>
                                                <th align='left'><b>Start Date</b></th>
                                                <th align='left'><b>Description</b></th>
                                            </tr>
                                            <?php
                                            // Fetch and print all the records.
                                            foreach ($rows as $row) {
                                                echo "<tr onclick=\"window.location='update.php?id=" . $row['pid'] . "'\">";
                                                echo "<td align='left'>" . $row['title'] . "</td>";
                                                echo "<td align='left'>" . $row['start_date'] . "</td>";
                                                echo "<td align='left'>" . $row['description'] . "</td>";
                                                echo "</tr>\n";
                                            }
                                        echo '</table>';
                                    } else {
                                        echo "<p>No projects in the list.</p>\n"; //no match found
                                    }
                                } catch (PDOException $ex) {
                                    echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
                                }
                            }

                            if ($title && !($sdate)) {
                                try {
                                    $query = "SELECT * FROM projects WHERE title LIKE CONCAT('%', ?, '%')";
                                    $statement = $db->prepare($query);
                                    $statement->execute(array($title));
                            
                                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                            
                                    if ($rows) {
                                        ?>
                                        <table cellspacing="0" cellpadding="5" id="myTable">
                                            <tr>
                                                <th align='left'><b>Project name</b></th>
                                                <th align='left'><b>Start Date</b></th>
                                                <th align='left'><b>Description</b></th>
                                            </tr>
                                            <?php
                                            // Fetch and print all the records.
                                            foreach ($rows as $row) {
                                                echo "<tr onclick=\"window.location='update.php?id=" . $row['pid'] . "'\">";
                                                echo "<td align='left'>" . $row['title'] . "</td>";
                                                echo "<td align='left'>" . $row['start_date'] . "</td>";
                                                echo "<td align='left'>" . $row['description'] . "</td>";
                                                echo "</tr>\n";
                                            }
                                        echo '</table>';
                                    } else {
                                            echo "<p>No projects in the list.</p>\n"; //no match found
                                    }
                                                
                                } catch (PDOException $ex) {
                                    echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
                                }

                                
                            }

                            if (!($title) && $sdate) {
                                try {
                                    $query = "SELECT * FROM projects WHERE start_date = ?";
                                    $statement = $db->prepare($query);
                                    $statement->execute(array($sdate));
                            
                                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
                            
                                    if ($rows) {
                                        ?>
                                        <table cellspacing="0" cellpadding="5" id="myTable">
                                            <tr>
                                                <th align='left'><b>Project name</b></th>
                                                <th align='left'><b>Start Date</b></th>
                                                <th align='left'><b>Description</b></th>
                                            </tr>
                                            <?php
                                            // Fetch and print all the records.
                                            foreach ($rows as $row) {
                                                echo "<tr onclick=\"window.location='update.php?id=" . $row['pid'] . "'\">";
                                                echo "<td align='left'>" . $row['title'] . "</td>";
                                                echo "<td align='left'>" . $row['start_date'] . "</td>";
                                                echo "<td align='left'>" . $row['description'] . "</td>";
                                                echo "</tr>\n";
                                            }
                                        echo '</table>';
                                    } else {
                                            echo "<p>No projects in the list.</p>\n"; //no match found
                                    }
                                                    
                                } catch (PDOException $ex) {
                                    echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
                                }
                            }
                        }


                        if (!(isset($_POST['submitted2']))){
                            require_once ('connectdb.php');
                            $title = isset($_POST['title']) ? $_POST['title'] : '';
                            $sdate = isset($_POST['sDate']) ? $_POST['sDate'] : '';
                            try {
                                $query="SELECT  * FROM  projects ";
                                $rows =  $db->query($query);
                                    
                                if ( $rows && $rows->rowCount()> 0) {
                                
                                    ?>
                                    	
                                    <table cellspacing="0"  cellpadding="5" id="myTable" >
                                    <tr><th align='left'><b>Project title</b></th>   <th align='left'><b>Start Date</b></th> <th align='left'><b>Description</b></th ></tr>
                                        <?php
                                        // Fetch and  print all  the records.
                                        while ($row = $rows->fetch()) {
                                            echo "<tr onclick=\"window.location='update.php?id=" . $row['pid'] . "'\">";
                                            echo "<td align='left'>" . $row['title'] . "</td>";
                                            echo "<td align='left'>" . $row['start_date'] . "</td>";
                                            echo "<td align='left'>" . $row['description'] . "</td>";
                                            echo "</tr>\n";
                                        }
                                        
                                    echo  '</table>';
                                }else {
                                    echo  "<p>No  projects in the list.</p>\n"; //no match found
                                }
                                    
                                            
                                            
                            }catch (PDOException $ex) {
                                echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
                            }	
                        }

                    ?>
                </section>


                <section id="right">
                    <h3>Edit project</h3>
                    <?php
                        // Handling form submission for editing project
                        if (isset($_POST['e_submitted'])){
                            $project_id = $_POST['pass_id'];

                            require_once ('connectdb.php'); 

                            $title2 = $_POST['title'];
                            $sDate2 = $_POST['sDate'];
                            $eDate2 = $_POST['eDate'];
                            $phase2 = $_POST['phase'];
                            $description2 = $_POST['textbox'];

                            // Validate form data
                            if (!$title2 || !$sDate2 || !$eDate2 || !$description2) {
                                echo "<p style='color:red'>Please fill in all required fields.</p>"; 
                                echo  "<p>Plese select a project on the left to be able to edit it.</p>\n";  
                                exit;
                            }
                        
                            // Check if end date is after start date
                            elseif ($sDate2 > $eDate2) {
                                echo "<p style='color:red'>Please enter an end date that occurs after the start date.</p>";
                                echo  "<p>Plese select a project on the left to be able to edit it.</p>\n";
                                exit;
                            }

                            else{
                                try {
                                    // Check if another project with the same title already exists
                                    $stat = $db->prepare('SELECT * FROM projects WHERE title = ?');
                                    $stat->execute(array($title2));
                                    
                                    // Fetch the current project's title using the project ID
                                    $currentProject = $db->prepare('SELECT title FROM projects WHERE pid = ?');
                                    $currentProject->execute(array($project_id));
                                    $currentTitle = $currentProject->fetchColumn(); // Fetch the title of the current project
                                    
                                    // Check if the new title is different from the current one
                                    if ($title2 != $currentTitle && $stat->rowCount() > 0) {
                                        echo "<p style='color:red'>This project title is already in use. Please choose another one.</p>";
                                        echo "<p>Please select a project on the left to be able to edit it.</p>\n";
                                        exit;
                                    } else {
                                        // Proceed with the update since the title is either the same or unique
                                        $query = "UPDATE projects SET title = ?, start_date = ?, end_date = ?, phase = ?, description = ? WHERE pid = ?";
                                        $statement = $db->prepare($query);
                                        $result = $statement->execute([$title2, $sDate2, $eDate2, $phase2, $description2, $project_id]);
                                
                                        if($result) {
                                            echo "<p style='color:green'>Project updated successfully refreshing page.</p>";
                                            header("Refresh:5");
                                        } else {
                                            echo "<p style='color:red'>Error updating project.</p>";
                                        }
                                    }
                                } catch(PDOException $ex) {
                                    echo "<p style='color:red'>Failed to connect to the database.</p>";
                                    echo($ex->getMessage());
                                }
                            }
                        }
                    ?>
                    <!-- Display form for editing project -->
                    <?php
                        if(isset($_GET['id'])) {

                            $project_id = $_GET['id'];

                            require_once ('connectdb.php'); 

                            $query = "SELECT * FROM projects WHERE projects.pid = ?";
                            $statement = $db->prepare($query);
                            $statement->execute(array($project_id));
                            $project_details = $statement->fetch(PDO::FETCH_ASSOC);

                            $query2 = "SELECT users.username, users.email FROM projects INNER JOIN users ON projects.uid = users.uid WHERE projects.pid = ?";
                            $statement2 = $db->prepare($query2);
                            $statement2->execute(array($project_id));
                            $user_details = $statement2->fetch(PDO::FETCH_ASSOC);

                            $phase= $project_details['phase'];

                            echo "<form method='post' action='update.php'>
                                <section class='input-row'>
                                    <section class='input-group'>
                                        <label>Title:</label>
                                        <input name='title' type='text' placeholder='Enter project title' value='" . htmlspecialchars($project_details['title']) . "'>
                                    </section><br>

                                    <section class='input-group'>
                                        <label for='sDate'>Project start date:</label>
                                        <input type='date' name='sDate' value='" . htmlspecialchars($project_details['start_date']) . "'>
                                    </section><br>

                                    <section class='input-group'>
                                        <label for='sDate'>Project end date:</label>
                                        <input type='date' name='eDate' value='" . htmlspecialchars($project_details['end_date']) . "'>
                                    </section><br>

                                    <section class='input-group'>
                                        <label>Project phase:</label> 
                                        <div>
                                            <input type='radio' name='phase' value='design'" . ($phase === 'design' ? ' checked' : '') . ">
                                            <label for='design'>Design</label>                                    
                                        </div>
                                        <div>
                                            <input type='radio' name='phase' value='development'" . ($phase === 'development' ? ' checked' : '') . ">
                                            <label for='development'>Development</label>
                                        </div>
                                        <div>
                                            <input type='radio' name='phase' value='testing'" . ($phase === 'testing' ? ' checked' : '') . ">
                                            <label for='testing'>Testing</label>
                                        </div>
                                        <div>
                                            <input type='radio' name='phase' value='deployment'" . ($phase === 'deployment' ? ' checked' : '') . ">
                                            <label for='deployment'>Deployment</label>
                                        </div>
                                        <div>
                                            <input type='radio' name='phase' value='complete'" . ($phase === 'complete' ? ' checked' : '') . ">
                                            <label for='complete'>Complete</label>
                                        </div>
                                    </section>
                                </section>
                                <br/>
                                <section class='input-group'>
                                    <label>Description:</label>
                                    <textarea id='textbox' name='textbox' placeholder='Enter description here'>" . htmlspecialchars($project_details['description']) . "</textarea>
                                </section>
                                <div class='button-container'>
                                    <button type='submit' value='edit'>Edit project</button><br><br>
                                </div>
                                <input type='hidden' name='e_submitted' value='True'>
                                <input type='hidden' name='pass_id' value=' $project_id '>

                            </form>";

                        }
                        else {
                            echo  "<p>Plese select a project on the left to be able to edit it.</p>\n";
                        }
                    ?>
                </section>
            </section>
        </main>
    </body>
</html>


<?php
    // Check if the form for editing a project has been submitted
    if (isset($_POST['e_submitted'])){
        // Retrieve project ID from the form data
        $project_id = $_POST['pass_id'];

        // Include the database connection script
        require_once ('connectdb.php'); 

        // Retrieve form data for the project attributes
        $title = $_POST['title'];
        $sDate = $_POST['sDate'];
        $eDate = $_POST['eDate'];
        $phase = $_POST['phase'];
        $description = $_POST['textbox'];

        // Update the project details in the database
        $query = "UPDATE projects SET title = ?, start_date = ?, end_date = ?, phase = ?, description = ? WHERE pid = ?";
        $statement = $db->prepare($query);
        $result = $statement->execute([$title, $sDate, $eDate, $phase, $description, $project_id]);

        // Check if the update was successful
        if($result) {
            echo "Project updated successfully.";
        } else {
            echo "Error updating project.";
        }
    }
?>
