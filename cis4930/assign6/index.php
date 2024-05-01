#!/usr/local/bin/php

<?php
require_once("dbCredentials.php");

//CONNECT TO DATABASE
$conn = mysqli_connect($host, $username, $password, $database);

//SEE IF IT WORKED
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//GRAB ALL THE ENTRIES IN THE TABLE
$sql = "SELECT * FROM songs_table ORDER BY Title ASC";
$result = mysqli_query($conn, $sql);

// GET THE RESULTS AND STORE IT IN A PHP VARIABLE
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      $tableDataTotal .= "<tr>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> <strong> {$row['Title']} </strong> </td>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Artist']} </td>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Length']} </td>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Genre']} </td>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Year']} </td>";
      $tableDataTotal .= "<td class='dataHighlight dataFormat'> {$row['Explicit']} </td>";
  
      $tableDataTotal .= "<td class='dataHighlight dataFormat edit-col'>
      <div class='text-center'>
      <button class='btn1' value='{$row['id']}' onclick='setEditSelectValue(\"{$row['id']}\")' style='font-size: 14px; padding: 5px 10px; color: #343a40; background-color: #f8f9fa; border-color: #f8f9fa;'> <i class='fas fa-edit'></i> </button>
      <button class='btn1' value='{$row['id']}' onclick='setDeleteSelectValue(\"{$row['id']}\")' style='font-size: 14px; padding: 5px 10px; color: #343a40; background-color: #f8f9fa; border-color: #f8f9fa;'> <i class='fas fa-trash-alt'></i> </button>
      </div>
      </td>";      

      $tableDataTotal .= "</tr>";            
    }
} 
else {
    $tableDataTotal = "";
}

$numEntries = mysqli_num_rows($result);

// CLOSE THE CONNECTION
mysqli_close($conn);
?>

<html>
    <head>
        <title>
            Song Database
        </title>

      <!-- BOOTSTRAP CDN LINK -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
      
      <!-- BOOTSTRAP META TAGS -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSS LINKS -->
      <link href="../style.css" rel="stylesheet" type="text/css">
      <link href="../assign4/assign4_style.css" rel="stylesheet" type="text/css">
      <link href="assign6_style.css" rel="stylesheet" type="text/css">
      <link rel="icon" type="image/x-icon" href="assign6_files/music.gif">

      <!-- JQUERY LINK -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

      <!-- CDN FOR HOME ICON-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script>
        $(document).ready(function() {
          $('#fillIn').change(function() {
            if ($(this).is(':checked')) {
              $('#fillInText').prop('disabled', false);
            } 
            else {
              $('#fillInText').prop('disabled', true);
              $('#fillInText').val("");
            }
          });

          $('#customEditCheck').change(function() {
            if ($(this).is(':checked')) {
              $('#customEdit').prop('disabled', false);
            } 
            else {
              $('#customEdit').prop('disabled', true);
              $('#customEdit').val("");
            }
          });

          $('select[name="deleteSelect"]').on('change', function() {
            $('#deleteFormPage').removeClass('hidden');
          });
          
          // SHOW FORM WHEN A SONG WAS SELECTED
          $('select[name="editSelect"]').on('change', function() {

            $('#formEdit').removeClass('was-validated');
            const selectedOption = $(this).val();
            $.ajax({
              type: "POST",
              url: "getSong.php",
              data: { selectedOption: selectedOption },
              success: function(response) {
                const songInfo = JSON.parse(response);
                $('input[name="editSongID"]').val(songInfo.id_song);

                $('#labelEdit').html('Song Information For "<span name="editTitle">' + songInfo.title + '</span>" by <span name="editArtist">' + songInfo.artist + '</span>').css({ 'font-weight': 'bold', 'font-size': '25px' });

                $('#labelEditSub').html('Edit the song information below.').css('font-style', 'italic');

                $('input[name="editTitle"]').val(songInfo.title);
                $('input[name="editArtist"]').val(songInfo.artist);

                $('input[name="editLength"]').val(songInfo.length);

                $('input[name="popEdit"]').prop('checked', songInfo.genrePop);
                $('input[name="rockEdit"]').prop('checked', songInfo.genreRock);
                $('input[name="rapEdit"]').prop('checked', songInfo.genreRap);
                $('input[name="countryEdit"]').prop('checked', songInfo.genreCountry);
                $('input[name="alternativeEdit"]').prop('checked', songInfo.genreAlternative);
                $('input[name="R&BEdit"]').prop('checked', songInfo.genreRB);
                $('input[name="EDMEdit"]').prop('checked', songInfo.genreEDM);
                $('input[name="customEditCheck"]').prop('checked', songInfo.genreCustomCheck);
                $('input[name="customEdit"]').val(songInfo.genreCustom);

                if(songInfo.genreCustomCheck) {
                  $('input[name="customEdit"]').prop('disabled', false);
                } else {
                  $('input[name="customEdit"]').prop('disabled', true);
                }

                $('select[name="editYear"]').val(songInfo.year);
                
                if (songInfo.explicit == "Yes"){
                  $('input[name="editExplicit"][value="Yes"]').prop("checked", true);
                }
                else{
                  $('input[name="editExplicit"][value="No"]').prop("checked", true);
                }
                
                $('#editFormPage').removeClass('hidden');
              }
            });
          });
        });
    </script>

    <script>
      function setEditSelectValue(value) {
        $('select[name=\'editSelect\']').val(value).trigger('change');
        setTimeout(function() {
          if (!$('#collapseTwo').hasClass('show')) {
            $('#collapseTwo').collapse('show');
          }
          $('html, body').animate({
              scrollTop: $('#editTitle').offset().top
            }, 'medium');
        }, 100);
      }


      function setDeleteSelectValue(value) {
        $('select[name=\'deleteSelect\']').val(value).trigger('change');
        setTimeout(function() {
        if (!$('#collapseThree').hasClass('show')) {
          $('#collapseThree').collapse('show');
        }
        $('html, body').animate({
            scrollTop: $('#deleteTitle').offset().top
          }, 'medium');
      }, 100);
      }
    </script>

    </head>

    <body style="margin-left: unset; margin-right: unset; margin-top: unset; margin-bottom: unset;">
        <div class="container">
          <!-- MADE A SEPARATE PHP FILE FOR THE NAVBAR ELEMENT BECAUSE IT WILL BE USED IN OTHER ASSIGNMENTS -->
          <?php include('../assign5/navbar.php'); ?>

          <br>
        
          <h1 class="stylizedHeading shadow-lg" style="text-align: center; background-color: #75a9d9"> Song Database </h1>

          <h2 class="stylizedHeading shadow-lg" style="background-color: #64a486; color: #0c1d24;">
              <center>
                  Kevin Cen
              </center>
          </h2>

          <br>

        <div class="card custom-card shadow-lg">
            <div class="card-body">

                <h3 style="text-align: center"> <strong> Current List of Songs in Database: </strong> </h3>

                <fieldset class="border p-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th class="headerHighlight dataFormat"> Title </th>
                            <th class="headerHighlight dataFormat"> Artist </th>
                            <th class="headerHighlight dataFormat"> Length </th>
                            <th class="headerHighlight dataFormat"> Genre(s) </th>
                            <th class="headerHighlight dataFormat"> Year </th>
                            <th class="headerHighlight dataFormat"> Explicit </th>
                            <th class="headerHighlight dataFormat"> Quick Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $tableDataTotal ?>
                        </tbody>
                        </table>
                    </div>

                    <p class="dataFormat"> <strong> Total Number of Songs in Database: </strong> <?php echo $numEntries ?> </p>
                    <a href="assign6_files/ERD.png" class="dataFormat"> View the Entity Relationship Diagram for this Database Table </a>

                </fieldset>

                <br>

                <h3 style="text-align: center"> <strong> Actions: </strong> </h3>
                <fieldset class="border p-3">
                    <div class="accordion shadow-lg" id="descAccordion">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                              <h5> <strong> Add a Song to the Database </strong> </h5>
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#descAccordion">
                            <div class="accordion-body">
                                <form id="form" class="needs-validation" action="insert.php" method="post" novalidate>

                                    <!-- ASK FOR SONG TITLE -->
                                    <fieldset class="border p-3">                  
                                      <div class="form-group">
                                        <label class="questionText" style="font-weight: bold" >What is the title of the song? </label>
                                        <p style="font-size: larger"> <em> Please enter the song title in the textbox below. </em> </p>
                                        
                                        <div class="input-group">
                                          <input type='text' name='inputTitle' class="form-control questionText" placeholder="Enter the song title here" required> <br>
                                          <div class="invalid-feedback questionText">
                                            <i class="fas fa-arrow-up"></i> <em> Please type in a song title. </em>
                                          </div>
                                        </div>
                                      </div>
                                      <br>
                                    </fieldset>
                                
                                    <br>

                                    <!-- ASK FOR ARTIST -->
                                    <fieldset class="border p-3">                  
                                        <div class="form-group">
                                          <label class="questionText" style="font-weight: bold" >Who made the song? </label>
                                          <p style="font-size: larger"> <em> Please enter the artist name in the textbox below. </em> </p>
                                          
                                          <div class="input-group">
                                            <input type='text' name='inputArtist' class="form-control questionText" placeholder="Enter the artist name here" required> <br>
                                            <div class="invalid-feedback questionText">
                                              <i class="fas fa-arrow-up"></i> <em> Please type in an artist name. </em>
                                            </div>
                                          </div>
                                        </div>
                                        <br>
                                    </fieldset>

                                    <br>
                      
                                    <!-- ASK FOR LENGTH -->
                                    <fieldset class="border p-3">                  
                                        <div class="form-group">
                                          <label class="questionText" style="font-weight: bold" >How long is the song? </label>
                                          <p style="font-size: larger"> <em> Please enter the song length in the textbox below. </em> </p>
                                          <p style="font-size: larger"> <em> The format must be in the form of an integer, followed by a colon, followed by a two-digit integer. </em> </p>

                                          <div class="input-group">
                                            <input type='text' name='inputLength' class="form-control questionText" placeholder="Enter the song length here" pattern="^\d+:[0-5][0-9]$" required> <br>
                                            <div class="invalid-feedback questionText">
                                              <i class="fas fa-arrow-up"></i> <em> Please type in a valid length that matches the format specified above. </em>
                                            </div>
                                          </div>
                                        </div>
                                        <br>
                                    </fieldset>

                                    <br>
                      
                                    <!-- ASK FOR GENRE(S) -->
                                    <fieldset class="border p-3">
                                      <div class="form-group row">
                                        <label class="questionText" style="font-weight: bold"> Which genre(s) does this song belong to? </label>
                                        <p style="font-size: larger"> <em> Please select all genres that apply to the song. </em> </p>

                                        <div class="col-md-2">

                                          <div class="form-check questionText">
                                            <input name="pop" class="form-check-input" type="checkbox" id="pop" required>
                                            <label class="form-check-label" for="pop">
                                              Pop
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="rock" class="form-check-input" type="checkbox" id="rock" required>
                                            <label class="form-check-label" for="rock">
                                              Rock
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="rap" class="form-check-input" type="checkbox" id="rap" required>
                                            <label class="form-check-label" for="rap">
                                              Rap
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="country" class="form-check-input" type="checkbox" id="country" required>
                                            <label class="form-check-label" for="country">
                                              Country
                                            </label>
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="form-check questionText">
                                            <input name="alternative" class="form-check-input" type="checkbox" id="alternative" required>
                                            <label class="form-check-label" for="alternative">
                                              Alternative
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="r&b" class="form-check-input" type="checkbox" id="r&b" required>
                                            <label class="form-check-label" for="r&b">
                                              R&B
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="edm" class="form-check-input" type="checkbox" id="edm" required>
                                            <label class="form-check-label" for="edm">
                                              EDM
                                            </label>
                                          </div>

                                          <div class="form-check questionText">
                                            <input name="fillIn" class="form-check-input" type="checkbox" id="fillIn" required>
                                            <input type="text" class="form-control questionText" id="fillInText" name="fillInText" placeholder="Enter your own genre here" disabled required>
                                          </div>
                                        </div>
                                        <br>
                                    </fieldset>
                      
                                    <br>

                                    <!-- ASK FOR YEAR -->
                                    <fieldset class="border p-3">
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                              <label class="questionText" style="font-weight: bold"> What year did this song come out? </label>
                                              <p style="font-size: larger"> <em> Please select a year from the dropdown below. </em> </p>
                                            
                                              <select name="inputYear" id="songYear" class="form-select questionText" required>
                                                <option value="" disabled selected> Select a year </option>
                                                <script>
                                                    for (var i = 2023; i >= 1000; i--) {
                                                        $('<option>', {
                                                        value: i,
                                                        text: i
                                                        }).appendTo('#songYear');
                                                    }
                                                </script>
                                              </select>
                                              <div class="invalid-feedback questionText">
                                                <i class="fas fa-arrow-up"></i> <em> A year was not selected. <br> Please select a year. </em> 
                                              </div>
                                            </div>
                                        </div>
                                        <br>
                                    </fieldset>

                                    <br>

                                    <!-- ASK FOR SONG EXPLICITY -->
                                    <fieldset class="border p-3">
                                        <div class="form-group row">
                                          <div class="col-md-8">
                                            <h3 class="questionText" style="font-weight: bold"> Is the song explicit? </h3>
                                            <p style="font-size: larger"> <em> Please select a either <strong> yes </strong> or <strong> no </strong>  below. </em> </p>
                        
                                            <div class="form-check questionText">
                                              <input class="form-check-input" type="radio" name='inputExplicit' value="Yes" id="yes" required>
                                              <label class="form-check-label questionText" for="yes">
                                                Yes
                                              </label>
                                            </div>
                                            
                                            <div class="form-check questionText">
                                              <input class="form-check-input" type="radio" name='inputExplicit' value="No" id="no" required>
                                              <label class="form-check-label questionText" for="no">
                                                No
                                              </label>
                                                <div class="invalid-feedback questionText"> 
                                                    <i class="fas fa-arrow-up"></i> <em> Please select either <strong> yes </strong> or <strong> no </strong>. </em> 
                                                </div>
                                            </div>
                                    </fieldset>

                                    <br>

                                    <div class="submitResetButton">
                                        <button type="submit" id="submitButton" class="btn btn-dark btn-lg"> Add Song </button>
                                        <button id="reset" type="reset" class="btn btn-dark btn-lg">Reset</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>

                        <div class="accordion shadow-lg" id="descAccordion">
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                              <button id="editTitle" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5> <strong> Edit a Song in the Database </strong> </h5>
                              </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#descAccordion">
                              <div class="accordion-body">
                                  <form id="formEdit" class="needs-validation" action="edit.php" method="post" novalidate>

                                    <!-- ASK FOR SONG TITLE -->
                                    <fieldset class="border p-3">              
                                      <div class="form-group">
                                        <label class="questionText" style="font-weight: bold" >What is the title of the song you would like to edit? </label>
                                        <p style="font-size: larger"> <em> Please select the song title from the dropdown menu below. </em> </p>
                                    
                                        <div class="input-group">
                                          <select name="editSelect" class="form-control questionText" required>
                                            <option value="" disabled selected> Select a song title </option>
                                            <?php
                                              require_once("dbCredentials.php");

                                              //CONNECT TO DATABASE
                                              $conn = mysqli_connect($host, $username, $password, $database);
                                    
                                              $result = mysqli_query($conn, "SELECT * FROM songs_table ORDER BY Title ASC");
                                    
                                              while ($row = mysqli_fetch_assoc($result)) {
                                                // STORE ID AS VALUE AND ALSO DISPLAY IT
                                                echo "<option value=\"" . $row['id'] . "\"> \"" . $row['Title'] . "\" by " . $row['Artist'] . "</option>";
                                              }
                                              mysqli_close($conn);
                                            ?>
                                          </select>
                                          <div class="invalid-feedback questionText">
                                            <i class="fas fa-arrow-up"></i> <em> Please select a song title. </em>
                                          </div>
                                        </div>
                                      </div>
                                      <br>
                                    </fieldset>
                                    
                                    <!-- SHOW INFORMATION FOR THAT SONG -->
                                      <div class="form-group hidden" id="editFormPage">
                                        <br>
                                        <div style="text-align: center">
                                          <label id="labelEdit" class="questionText" style="font-weight: bold; font-size: 25px;"> Song Information For "<span name="editTitle"></span>" by <span name="editArtist"></span> </label>
                                          <p id="labelEditSub" style="font-size: larger"> <em> Edit the song information below. </em> </p>
                                        </div>

                                        <!-- SONG TITLE -->
                                        <fieldset class="border p-3">                  
                                        <div class="form-group">
                                          <h3 class="questionText" style="font-weight: bold"> Title: </h3>
                                          <div class="input-group">
                                            <input name="editTitle" type='text'class="form-control questionText" required> <br>
                                            <div class="invalid-feedback questionText">
                                              <i class="fas fa-arrow-up"></i> <em> Please type in a song title. </em>
                                            </div>
                                          </div>
                                        </div>
                                        </fieldset>
       
                                        <br>

                                        <!-- SONG ARTIST -->
                                        <fieldset class="border p-3">                  
                                          <div class="form-group">
                                            <h3 class="questionText" style="font-weight: bold"> Artist: </h3>
                                              <div class="input-group">
                                                <input name="editArtist" type='text' class="form-control questionText" required> <br>
                                              <div class="invalid-feedback questionText">
                                                <i class="fas fa-arrow-up"></i> <em> Please type in an artist name. </em>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>
          
                                          <br>

                                        <!-- SONG LENGTH -->
                                        <fieldset class="border p-3">                  
                                          <div class="form-group">
                                            <h3 class="questionText" style="font-weight: bold"> Length: </h3>
                                              
                                            <div class="input-group">
                                              <input name="editLength" type='text' class="form-control questionText" pattern="^\d+:[0-5][0-9]$" required> <br>
                                              <div class="invalid-feedback questionText">
                                                <i class="fas fa-arrow-up"></i> <em> The format must be in the form of an integer, followed by a colon, followed by a two-digit integer. </em>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>
          
                                          <br>

                                        <!-- SONG GENRE -->
                                        <fieldset class="border p-3"> 
                                          <div class="form-group row">
                                          <h3 class="questionText" style="font-weight: bold"> Genre(s): </h3>
                                          <div class="col-md-2">

                                            <div class="form-check questionText">
                                              <input name="popEdit" class="form-check-input" type="checkbox" id="popEdit" required>
                                              <label class="form-check-label" for="popEdit">
                                                Pop
                                              </label>
                                            </div>

                                            <div class="form-check questionText">
                                              <input name="rockEdit" class="form-check-input" type="checkbox" id="rockEdit" required>
                                              <label class="form-check-label" for="rockEdit">
                                                Rock
                                              </label>
                                            </div>

                                            <div class="form-check questionText">
                                              <input name="rapEdit" class="form-check-input" type="checkbox" id="rapEdit" required>
                                              <label class="form-check-label" for="rapEdit">
                                                Rap
                                              </label>
                                            </div>

                                            <div class="form-check questionText">
                                              <input name="countryEdit" class="form-check-input" type="checkbox" id="countryEdit" required>
                                              <label class="form-check-label" for="countryEdit">
                                                Country
                                              </label>
                                            </div>
                                          </div>

                                            <div class="col-md-6">
                                              <div class="form-check questionText">
                                                <input name="alternativeEdit" class="form-check-input" type="checkbox" id="alternativeEdit" required>
                                                <label class="form-check-label" for="alternativeEdit">
                                                  Alternative
                                                </label>
                                              </div>

                                              <div class="form-check questionText">
                                                <input name="R&BEdit" class="form-check-input" type="checkbox" id="R&BEdit" required>
                                                <label class="form-check-label" for="R&BEdit">
                                                  R&B
                                                </label>
                                              </div>

                                              <div class="form-check questionText">
                                                <input name="EDMEdit" class="form-check-input" type="checkbox" id="EDMEdit" required>
                                                <label class="form-check-label" for="EDMEdit">
                                                  EDM
                                                </label>
                                              </div>

                                              <div class="form-check questionText">
                                                <input name="customEditCheck" class="form-check-input" type="checkbox" id="customEditCheck" required>
                                                <input name="customEdit" type="text" class="form-control questionText" id="customEdit" placeholder="Enter your own genre here" disabled required>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>

                                        <br>

                                        <!-- SONG YEAR -->
                                        <fieldset class="border p-3">
                                          <div class="form-group">
                                              <div>
                                              
                                                <h3 class="questionText" style="font-weight: bold"> Year: </h3>
    
                                                <select name="editYear" id="editYear" class="form-select questionText" required>
                                                  <option value="" disabled selected> Select a year </option>
                                                  <script>
                                                      for (var i = 2023; i >= 1000; i--) {
                                                          $('<option>', {
                                                          value: i,
                                                          text: i
                                                          }).appendTo('#editYear');
                                                      }
                                                  </script>
                                                </select>
                                                <div class="invalid-feedback questionText">
                                                  <i class="fas fa-arrow-up"></i> <em> A year was not selected. <br> Please select a year. </em> 
                                                </div>
                                              </div>
                                          </div>
                                          <br>
                                        </fieldset>

                                        <br>

                                        <!-- SONG EXPLICITY -->
                                        <fieldset class="border p-3">
                                          <div class="form-group row">
                                            <div class="col-md-8">
                                              <h3 class="questionText" style="font-weight: bold"> Explicit? </h3>
                          
                                              <div class="form-check questionText">
                                                <input class="form-check-input" type="radio" name='editExplicit' value="Yes" id="yesEdit" required>
                                                <label class="form-check-label questionText" for="yesEdit">
                                                  Yes
                                                </label>
                                              </div>
                                              
                                              <div class="form-check questionText">
                                                <input class="form-check-input" type="radio" name='editExplicit' value="No" id="noEdit" required>
                                                <label class="form-check-label questionText" for="noEdit">
                                                  No
                                                </label>
                                                  <div class="invalid-feedback questionText"> 
                                                    <i class="fas fa-arrow-up"></i> <em> Please select either <strong> yes </strong> or <strong> no </strong>. </em> 
                                                  </div>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>
                                        <br>
                                        <div class="submitResetButton">
                                          <button type="submit" id="submitEditButton" class="btn btn-dark btn-lg"> Save Changes </button>
                                          <button id="editReset" type="reset" class="btn btn-dark btn-lg">Reset</button>
                                        </div>
                                      </div>
                                     
                                  </form>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="accordion shadow-lg" id="descAccordion">
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                              <button id="deleteTitle" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h5> <strong> Delete a Song in the Database </strong> </h5>
                              </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#descAccordion">
                              <div class="accordion-body">
                                  <form id="formDelete" class="needs-validation" action="delete.php" method="post" novalidate>

                                    <!-- ASK FOR SONG TITLE -->
                                    <fieldset class="border p-3">              
                                      <div class="form-group">
                                        <label class="questionText" style="font-weight: bold" >What is the title of the song you would like to delete? </label>
                                        <p style="font-size: larger"> <em> Please select the song title from the dropdown menu below. </em> </p>
                                    
                                        <div class="input-group">
                                          <select name="deleteSelect" class="form-control questionText" required>
                                            <option value="" disabled selected> Select a song title </option>
                                            <?php
                                              require_once("dbCredentials.php");

                                              //CONNECT TO DATABASE
                                              $conn = mysqli_connect($host, $username, $password, $database);
                                    
                                              $result = mysqli_query($conn, "SELECT * FROM songs_table ORDER BY Title ASC");
                                    
                                              while ($row = mysqli_fetch_assoc($result)) {
                                                // STORE ID AS VALUE AND ALSO DISPLAY IT
                                                echo "<option value=\"" . $row['id'] . "\"> \"" . $row['Title'] . "\" by " . $row['Artist'] . "</option>";
                                              }
                                              mysqli_close($conn);
                                            ?>
                                          </select>
                                          <div class="invalid-feedback questionText">
                                            <i class="fas fa-arrow-up"></i> <em> Please select a song title. </em>
                                          </div>
                                        </div>
                                      </div>
                                      <br>
                                      <div class="form-group hidden" id="deleteFormPage">
                                        <h5 style="color: red"> <center> <em> Are you sure you want to delete this song? </em> </center> </h5>
                                        <div class="submitResetButton">
                                          <button type="submit" id="submitDeleteButton" class="btn btn-dark btn-lg"> Delete Song </button>
                                        </div>
                                      </div>
                                    </fieldset>
                                  </form>
                              </div>
                          </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <!-- ADDITIONAL BOOTSTRAP CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

        <script>
          (() => {
            'use strict';

            // GETS ALL FORMS WITH THE ATTRIBUTE "NEEDS-VALIDATION"
            $('.needs-validation').each(function() {
              const form = this;

              // LOOPS OVER ALL FORMS AND CHECKS IF THE CONTENT IS VALID
              $(form).submit(function(event) {
                // STOPS IF THE FORM IS INVALID
                if (!this.checkValidity()) {
                  event.preventDefault();
                  event.stopPropagation();

                  // GET THE FIRST INVALID ELEMENT IN THE FORM
                  const firstInvalidElem = $(':invalid', form).first();

                  // SCROLL TO THE FIRST INVALID ELEMENT
                  firstInvalidElem.get(0).scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                // SET THE FORM AS VALID
                this.classList.add('was-validated');
              });
            });

            // ADD A CUSTOM VALIDATION FUNCTION TO CHECKBOXES IN THE FORM WITH ID "form"
            $('#form').find('input[type="checkbox"]').on('change', function() {
              const checkboxes = $('#form').find('input[type="checkbox"]');
              const atLeastOneChecked = checkboxes.filter(':checked').length > 0;
              // DEPENDING ON IF AT LEAST ONE CHECKBOX WAS CHECKED, 
              // IT WILL PLACE THE "REQUIRED" ATTRIBUTE TO THE CHECKBOXES OR NOT
              checkboxes.prop('required', !atLeastOneChecked);
            });

            // ADD A CUSTOM VALIDATION FUNCTION TO CHECKBOXES IN THE FORM WITH ID "formEdit"
            $('#formEdit').find('input[type="checkbox"]').on('change', function() {
              const checkboxes = $('#formEdit').find('input[type="checkbox"]');
              const atLeastOneChecked = checkboxes.filter(':checked').length > 0;
              // DEPENDING ON IF AT LEAST ONE CHECKBOX WAS CHECKED, 
              // IT WILL PLACE THE "REQUIRED" ATTRIBUTE TO THE CHECKBOXES OR NOT
              checkboxes.prop('required', !atLeastOneChecked);
              const isRequired = checkboxes.prop('required');
            });

            $('#submitEditButton').on('click', function(event) {
              const checkboxes = $('#formEdit').find('input[type="checkbox"]');
              const atLeastOneChecked = checkboxes.filter(':checked').length > 0;
              // DEPENDING ON IF AT LEAST ONE CHECKBOX WAS CHECKED, 
              // IT WILL PLACE THE "REQUIRED" ATTRIBUTE TO THE CHECKBOXES OR NOT
              checkboxes.prop('required', !atLeastOneChecked);
              const isRequired = checkboxes.prop('required');
            });

            // FIND THE INSERT RESET BUTTON
            const resetBtn = $('#reset');

            // FIND THE EDIT RESET BUTTON
            const resetEditBtn = $('#editReset');

            // WHEN THE BUTTON IS CLICKED IN THE FORM WITH ID "form", REMOVE THE WAS-VALIDATED CLASS
            resetBtn.on('click', function() {
              // THIS GETS RID OF THE ERROR MESSAGES
              $('#form').removeClass('was-validated');
              $('#fillInText').prop('disabled', true);
            });

            // WHEN THE BUTTON IS CLICKED IN THE FORM WITH ID "formEdit", REMOVE THE WAS-VALIDATED CLASS
            resetEditBtn.on('click', function() {
              // THIS GETS RID OF THE ERROR MESSAGES
              $('#formEdit').removeClass('was-validated');
              $('#customEdit').prop('disabled', true);
              $('#labelEdit').text('Please select a song to view its song information.');
              $('#labelEditSub').text('');
            });
          })();
        </script>

        </div>
    </body>
    <footer style="padding-top: 50px;">Copyright &#169; 2023 Kevin Cen</footer>
</html>