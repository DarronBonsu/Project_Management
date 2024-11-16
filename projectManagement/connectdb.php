
<?php
    try{
        // Create a new PDO instance for database connection
        $db=new PDO("mysql:dbname=projects;host=localhost", "root","");
    }catch (PDOException $e) {
        // Catch any exceptions (errors) that occur during database connection
        // Display an error message if connection fails
        echo("Database connection failed: " . $e->getMessage());
    }
?>
