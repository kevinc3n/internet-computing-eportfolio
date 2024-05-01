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
        $songID = mysqli_real_escape_string($conn, $_POST['editSelect']);
        $songID = htmlspecialchars($songID);

        //GET THE SONG NAME
        $songTitle = mysqli_real_escape_string($conn, $_POST['editTitle']);
        $songTitle = htmlspecialchars($songTitle);

        //GET THE ARTIST NAME
        $songArtist = mysqli_real_escape_string($conn, $_POST['editArtist']);
        $songArtist = htmlspecialchars($songArtist);

        //GET THE SONG LENGTH
        $songLength = mysqli_real_escape_string($conn, $_POST['editLength']);
        $songLength = htmlspecialchars($songLength);

        //GET ALL GENRES
        $checkedItems = array();
        if(isset($_POST['popEdit'])) {
            $checkedItems[] = "Pop";
        }
        if(isset($_POST['rockEdit'])) {
            $checkedItems[] = "Rock";
        }
        if(isset($_POST['rapEdit'])) {
            $checkedItems[] = "Rap";
        }
        if(isset($_POST['countryEdit'])) {
            $checkedItems[] = "Country";
        }
        if(isset($_POST['alternativeEdit'])) {
            $checkedItems[] = "Alternative";
        }
        if(isset($_POST['R&BEdit'])) {
            $checkedItems[] = "R&B";
        }
        if(isset($_POST['EDMEdit'])) {
            $checkedItems[] = "EDM";
        }
        if(isset($_POST['customEditCheck'])) {
            $checkedItems[] = mysqli_real_escape_string($conn, $_POST['customEdit']);
        }

        //PUT ALL THE SELECTED CHOICES INTO A STRING SEPARATED BY COMMAS
        $selectedGenres = "";
        $count = count($checkedItems);
        for ($i = 0; $i < $count - 1; $i++) {
            $selectedGenres .= "{$checkedItems[$i]}, ";
        }
        $selectedGenres .= "{$checkedItems[$count - 1]}";

        //GET THE SONG YEAR
        $songYear = mysqli_real_escape_string($conn, $_POST['editYear']);
        $songYear = htmlspecialchars($songYear);

        //GET IF SONG IS EXPLICIT
        $songExplicit = mysqli_real_escape_string($conn, $_POST['editExplicit']);
        $songExplicit = htmlspecialchars($songExplicit);

        //PREPARE THE SQL STATEMENT WITH PLACEHOLDERS
        $stmt = mysqli_prepare($conn, "UPDATE songs_table SET Title = ?, Artist = ?, Length = ?, Genre = ?, Year = ?, Explicit = ? WHERE id = ?");

        //BIND THE PARAMETERS TO THE PLACEHOLDERS
        mysqli_stmt_bind_param($stmt, "sssssss", $songTitle, $songArtist, $songLength, $selectedGenres, $songYear, $songExplicit, $songID);

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