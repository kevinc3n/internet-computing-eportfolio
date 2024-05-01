#!/usr/local/bin/php
<?php
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['selectedOption'])) {

          //USE SQL HERE TO GET ALL SONG INFO FOR THAT SONG ID
          require_once("dbCredentials.php");

          //CONNECT TO DATABASE
          $conn = mysqli_connect($host, $username, $password, $database);

          //SEE IF IT WORKED
          if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          }

          $songID = mysqli_real_escape_string($conn, $_POST['selectedOption']);
          $songID = htmlspecialchars($songID);

          $sql = "SELECT * FROM songs_table WHERE id = $songID";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {

              $genreList = $row['Genre'];
              $genres = explode(", ", $genreList);
              $predefinedGenres = array("Pop", "Rock", "Rap", "Country", "Alternative", "R&B", "EDM");
              $userGenres = array();
              $customGenre = "";

              $pop = $rock = $rap = $country = $alternative = $RB = $EDM = $custom = false;

              foreach ($genres as $genre) {
                  if (in_array($genre, $predefinedGenres)) {
                    if ($genre == "Pop") {
                      $pop = true;
                    } 
                    elseif ($genre == "Rock") {
                      $rock = true;
                    } 
                    elseif ($genre == "Rap") {
                      $rap = true;
                    } 
                    elseif ($genre == "Country") {
                      $country = true;
                    } 
                    elseif ($genre == "Alternative") {
                      $alternative = true;
                    } 
                    elseif ($genre == "R&B") {
                      $RB = true;
                    } 
                    elseif ($genre == "EDM") {
                      $EDM = true;
                    }            
                  } 
                  else {
                      $custom = true;
                      $customGenre = implode(", ", array_slice($genres, array_search($genre, $genres)));
                      break;
                  }
              }
            
              $songInfo = array(
                'id_song' => $songID,
                'title' => $row['Title'],
                'artist' => $row['Artist'],
                'length' => $row['Length'],
                'genrePop' => $pop,
                'genreRock' => $rock,
                'genreRap' => $rap,
                'genreCountry' => $country,
                'genreAlternative' => $alternative,
                'genreRB' => $RB,
                'genreEDM' => $EDM,
                'genreCustomCheck' => $custom,
                'genreCustom' => $customGenre,
                'year' => $row['Year'],
                'explicit' => $row['Explicit']
              );

              $jsonResponse = json_encode($songInfo);

              //SEND JSON BACK
              echo $jsonResponse;
            }
          } 
          mysqli_close($conn);
        }
      }
    }
    else {
      header("Location: index.php");
      die("Unauthorized access! Please complete the original form to see this page.");
    }
?>
