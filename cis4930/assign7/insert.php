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

        //GET THE SONG NAME
        $songTitle = mysqli_real_escape_string($conn, $_POST['inputTitle']);
        $songTitle = htmlspecialchars($songTitle);

        //GET THE ARTIST NAME
        $songArtist = mysqli_real_escape_string($conn, $_POST['inputArtist']);
        $songArtist = htmlspecialchars($songArtist);

        //GET THE SONG LENGTH
        $songLength = mysqli_real_escape_string($conn, $_POST['inputLength']);
        $songLength = htmlspecialchars($songLength);

        //GET ALL GENRES
        $checkedItems = array();
        if(isset($_POST['pop'])) {
            $checkedItems[] = "Pop";
        }
        if(isset($_POST['rock'])) {
            $checkedItems[] = "Rock";
        }
        if(isset($_POST['rap'])) {
            $checkedItems[] = "Rap";
        }
        if(isset($_POST['country'])) {
            $checkedItems[] = "Country";
        }
        if(isset($_POST['alternative'])) {
            $checkedItems[] = "Alternative";
        }
        if(isset($_POST['r&b'])) {
            $checkedItems[] = "R&B";
        }
        if(isset($_POST['edm'])) {
            $checkedItems[] = "EDM";
        }
        if(isset($_POST['fillIn'])) {
            $checkedItems[] = mysqli_real_escape_string($conn, $_POST['fillInText']);
        }

        // PUT ALL THE SELECTED CHOICES INTO A STRING SEPARATED BY COMMAS
        $selectedGenres = "";
        $count = count($checkedItems);
        for ($i = 0; $i < $count - 1; $i++) {
            $selectedGenres .= "{$checkedItems[$i]}, ";
        }
        $selectedGenres .= "{$checkedItems[$count - 1]}";

        // GET THE SONG YEAR
        $songYear = mysqli_real_escape_string($conn, $_POST['inputYear']);
        $songYear = htmlspecialchars($songYear);

        // GET IF SONG IS EXPLICIT
        $songExplicit = mysqli_real_escape_string($conn, $_POST['inputExplicit']);
        $songExplicit = htmlspecialchars($songExplicit);

        //PREPARE THE SQL STATEMENT WITH PLACEHOLDERS
        $stmt = mysqli_prepare($conn, "INSERT INTO songs_table (Title, Artist, Length, Genre, Year, Explicit) VALUES (?, ?, ?, ?, ?, ?)");

        //BIND THE PARAMETERS TO THE PLACEHOLDERS
        mysqli_stmt_bind_param($stmt, "ssssss", $songTitle, $songArtist, $songLength, $selectedGenres, $songYear, $songExplicit);

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
        die("Unauthorized access! Please complete the insert form to see this page.");
        }
    ?>