#!/usr/local/bin/php
<?php
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
        require_once("dbCredentials.php");

        //CONNECT TO DATABASE
        $conn = mysqli_connect($host, $username, $password, $database);

        //SEE IF IT WORKED
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        //GET THE SONG ID
        $songID = mysqli_real_escape_string($conn, $_POST['deleteSelect']);    
        $songID = htmlspecialchars($songID);

        //PREPARE THE SQL STATEMENT
        $stmt = mysqli_prepare($conn, "DELETE FROM songs_table WHERE id = ?");

        //BIND THE PARAMETERS TO THE PLACEHOLDER
        mysqli_stmt_bind_param($stmt, "i", $songID);

        //EXECUTE THE QUERY
        mysqli_stmt_execute($stmt);

        //CLOSE THE PREPARED STATEMENT
        mysqli_stmt_close($stmt);

        //CLOSE THE CONNECTION
        mysqli_close($conn);

        //REDIRECT TO THE INDEX PAGE
        header("Location: index.php");    

    }
    else {
        header("Location: index.php");
        die("Unauthorized access! Please complete the edit form to see this page.");
        }
    ?>