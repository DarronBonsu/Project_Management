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
		<!-- Header section -->
		<header id="main-header">
			<!-- Navigation bar -->
			<nav>
				<ul>
					<!-- Navigation links -->
					<li><a class="reactive" href="">Projects</a></li>
					<li><a href="login.php">Login/Register</a></li>
				</ul>
			</nav>
		</header>
		<!-- Main content section -->
		<main>
			<!-- Search form -->
			<section class=boxes>
				<!-- Left section for Search -->
				<section id="left">
					<h3>Search</h3>
					<!-- Search form -->
					<form method="post" action="project.php">
						<!-- Title input field -->
						<section class="input-group">
							<label>Title:</label>
							<input name="title" type="text" placeholder="Enter project title" >
						</section><br>
						<!-- Start Date input field -->
						<section class="input-group">
							<br><label for="sDate">Project start date:</label>
							<input type="date" name="sDate" >
						</section><br>
						<!-- Button to submit search -->
						<button type="submit" value="Search project">Search project</button><br><br>
						<!-- Hidden input to indicate form submission -->
						<input type="hidden" name="submitted" value="True"/>
					</form>
				</section>
				<!-- Right section for displaying search results -->
				<section id="right">
					<h3>Search results</h3>
					<!-- PHP code for processing search and displaying results -->
					<?php
						//check if form has been submitted
						if (isset($_POST['submitted'])){
							//connect to database 
							require_once ('connectdb.php'); 

							$title = isset($_POST['title']) ? $_POST['title'] : '';
							$sdate = isset($_POST['sDate']) ? $_POST['sDate'] : '';

							//if no data given cancel submission 
							if(!($title) && !($sdate)){
								unset($_POST['submitted']);
								header("Location:project.php");
							}
							
							//if title and start date given
							if ($title && $sdate) {
								
								try {
									// Prepare and execute the query to select projects with title and start date
									$query = "SELECT * FROM projects WHERE title LIKE CONCAT('%', ?, '%') AND start_date = ?";
									$statement = $db->prepare($query);
									$statement->execute(array($title, $sdate));
							
									// Fetch all the matching records
									$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
							

									if ($rows) {
										
                    				// Display the search results in a table
                    				// Iterate over the results and display each project
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
												echo "<tr onclick=\"window.location='project.php?id=" . $row['pid'] . "'\">";
												echo "<td align='left'>" . $row['title'] . "</td>";
												echo "<td align='left'>" . $row['start_date'] . "</td>";
												echo "<td align='left'>" . $row['description'] . "</td>";
												echo "</tr>\n";
											}
										echo "<p style='color:#005f73;'>Click on a project to show full project details.</p>";
										echo '</table>';
									} 									
									
                    				// Display a message if no projects match the search criteria
									else {
										echo"<p style='color:#005f73;'>Click Search project button to go back to table.</p>";
										echo "<p>No projects in the list.</p>\n"; //no match found
									}
								} catch (PDOException $ex) {
									echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
								}
							}

							// If only title is provided
							if ($title && !($sdate)) {
								try {
									// Prepare and execute the query to select projects that contains title
									$query = "SELECT * FROM projects WHERE title LIKE CONCAT('%', ?, '%') ";
									$statement = $db->prepare($query);
									$statement->execute(array($title));
							
									$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
							
									if ($rows) {
										// Display the search results in a table
                    					// Iterate over the results and display each project
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
												echo "<tr onclick=\"window.location='project.php?id=" . $row['pid'] . "'\">";
												echo "<td align='left'>" . $row['title'] . "</td>";
												echo "<td align='left'>" . $row['start_date'] . "</td>";
												echo "<td align='left'>" . $row['description'] . "</td>";
												echo "</tr>\n";
											}
										echo "<p style='color:#005f73;'>Click on a project to show full project details.</p>";
										echo '</table>';
									}
									
									// Display a message if no projects match the search criteria
									else {
										echo"<p style='color:#005f73;'>Click Search project button to go back to table.</p>";
										echo "<p>No projects in the list.</p>\n"; //no match found
									}
												
								} catch (PDOException $ex) {
									echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
								}

								
							}

							// If only start date is provided
							if (!($title) && $sdate) {
								try {
									// Prepare and execute the query to select projects that maches start date
									$query = "SELECT * FROM projects WHERE start_date = ?";
									$statement = $db->prepare($query);
									$statement->execute(array($sdate));
							
									$rows = $statement->fetchAll(PDO::FETCH_ASSOC);
							
									if ($rows) {
										// Display the search results in a table
                    					// Iterate over the results and display each project
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
												echo "<tr onclick=\"window.location='project.php?id=" . $row['pid'] . "'\">";
												echo "<td align='left'>" . $row['title'] . "</td>";
												echo "<td align='left'>" . $row['start_date'] . "</td>";
												echo "<td align='left'>" . $row['description'] . "</td>";
												echo "</tr>\n";
											}
										echo "<p style='color:#005f73;'>Click on a project to show full project details.</p>";
										echo '</table>';
									}
									
									// Display a message if no projects match the search criteria
									else {
										echo"<p style='color:#005f73;'>Click Search project button to go back to table.</p>";
										echo "<p>No projects in the list.</p>\n"; //no match found
									}
													
								} catch (PDOException $ex) {
									echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
								}
							}
						}

						//check if project id is available
						elseif(isset($_GET['id'])) {
							//store project id as veriable
							$project_id = $_GET['id'];
							// cancel submission of search project
							unset($_POST['submitted']);
							//connect to database
							require_once('connectdb.php');

							//get the project with the project id
							$query="SELECT *  FROM projects WHERE projects.pid = ?";
							$statement=$db->prepare($query);
							$statement->execute(array($project_id));
							$project_details=$statement->fetch(PDO::FETCH_ASSOC);

							//get username and email conected to project
							$query2 = "SELECT users.username, users.email FROM projects INNER JOIN users ON projects.uid = users.uid WHERE projects.pid = ?";
							$statement2 = $db->prepare($query2);
							$statement2->execute(array($project_id));
							$user_details = $statement2->fetch(PDO::FETCH_ASSOC);


							//display all info
							echo"<p style='color:#005f73;'>Click Search project button to go back to table.</p>";
							echo "<p><b>Title:</b> " . $project_details['title'] . "</p>";
							echo "<p><b>Start Date:</b> " . $project_details['start_date'] . "</p>";
							echo "<p><b>End Date:</b> " . $project_details['end_date'] . "</p>";
							echo "<p><b>Description:</b> " . $project_details['description'] . "</p>";
							echo "<p><b>Phase:</b> " . $project_details['phase'] . "</p>";
							echo "<p><b>Username:</b> " . $user_details['username'] . "</p>";
							echo "<p><b>User Email:</b> " . $user_details['email'] . "</p>";
							


						}

						//if no form subbmitted and no project chosen show all projects
						elseif (!(isset($_POST['submitted'])) && !(isset($_GET['id']))){
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
											echo "<tr onclick=\"window.location='project.php?id=" . $row['pid'] . "'\">";
											echo "<td align='left'>" . $row['title'] . "</td>";
											echo "<td align='left'>" . $row['start_date'] . "</td>";
											echo "<td align='left'>" . $row['description'] . "</td>";
											echo "</tr>\n";
										}
									echo "<p style='color:#005f73;'>Click on a project to show full project details.</p>";
									echo  '</table>';
								}else {
									echo"<p style='color:#005f73;'>Click Search project button to go back to table.</p>";
									echo  "<p>No  projects in the list.</p>\n"; //no match found
								}
									
											
											
							}catch (PDOException $ex) {
								echo "<p style='color:red'>Failed to execute the query: " . $ex->getMessage() . "</p>\n";
							}	
						}

					?>


				</section>
			</section>
		</main>
	</body>

</html>



