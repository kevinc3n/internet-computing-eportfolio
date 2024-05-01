#!/usr/local/bin/php
<?php
$myfile = fopen("data.csv", "r") or die("Unable to open file!");
// READ AND DISCARD THE FIRST ROW
fgets($myfile);

$last_modified = date("F d, Y H:i:s", filemtime("data.csv"));

$individual = "";

$lowestScore = 6;
$highestScore = -1;
$averageScore = 0;
$scoreTotal = 0;

$Q1CorrectCount = 0;
$Q1Accuracy = 0;
$Q1Difficulty = "";

$Q2CorrectCount = 0;
$Q2Accuracy = 0;
$Q2Difficulty = "";

$Q3CorrectCount = 0;
$Q3Accuracy = 0;
$Q3Difficulty = "";

$Q4CorrectCount = 0;
$Q4Accuracy = 0;
$Q4Difficulty = "";

$Q5CorrectCount = 0;
$Q5Accuracy = 0;
$Q5Difficulty = "";

// THERE IS ALWAYS AN EMPTY ROW, SO NEED TO DISCARD IT
$totalResponses = -1;

while (!feof($myfile)) {
    $line = fgets($myfile);
    $values = str_getcsv($line);

    $name = $values[0];
    $Q1 = $values[1];
    $Q2 = $values[2];
    $Q3 = $values[3];
    $Q4 = $values[4];
    $Q5 = $values[5];
    $score = $values[6];

    $Q1Color = "";
    $Q2Color = "";
    $Q3Color = "";
    $Q4Color = "";
    $Q5Color = "";

    // CHECK WHICH RESPONSES ARE CORRECT
    if ($Q1 == "November 18, 2011"){
      $Q1CorrectCount++;
      $Q1Color = "#97d595";
    }
    else{
      $Q1Color = "#ff8c87";
    }

    if ($Q2 == "Y = -59"){
      $Q2CorrectCount++;
      $Q2Color = "#97d595";
    }
    else{
      $Q2Color = "#ff8c87";
    }

    if ($Q3 == "True"){
      $Q3CorrectCount++;
      $Q3Color = "#97d595";
    }
    else{
      $Q3Color = "#ff8c87";
    }

    $blockLower = str_replace(array("\r", "\n", ' '), '', strtolower($Q4));   

    if ($blockLower == "commandblock" || $blockLower == "command"){
      $Q4CorrectCount++;
      $Q4Color = "#97d595";
    }
    else{
      $Q4Color = "#ff8c87";
    }

    if ($Q5 == "Eggs, Wheat, Sugar, Milk"){
      $Q5CorrectCount++;
      $Q5Color = "#97d595";
    }
    else{
      $Q5Color = "#ff8c87";
    }

    $individual .= '<tr>';
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: #F6D387\"> <strong> $name </strong> </td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: $Q1Color\">$Q1</td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: $Q2Color\">$Q2</td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: $Q3Color\">$Q3</td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: $Q4Color\">$Q4</td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: $Q5Color\">$Q5</td>";
    $individual .= "<td class=\"dataHighlight minecraftText\" style=\"background-color: #F6D387\"> <strong> $score </strong> </td>";
    $individual .= '</tr>';

    //REMOVE THE "/5"
    $scoreNumber = explode("/", $score)[0];

    //SEE IF IT'S THE LOWEST SCORE
    //NEED TO ACCOUNT FOR THE EMPTY ROW HAVING A NULL VALUE
    if ($scoreNumber != "" && $scoreNumber < $lowestScore){
      $lowestScore = $scoreNumber;
    }

    //SEE IF IT'S THE HIGHEST SCORE
    if ($scoreNumber > $highestScore){
      $highestScore = $scoreNumber;
    }

    $scoreTotal += $scoreNumber;

    $totalResponses++;
}

$average = round(($scoreTotal / $totalResponses), 2);
$averageScore = $average . "/5 (" . (round(($average / 5), 2) * 100) . "%)";

$lowest = $lowestScore . "/5 (" . (round(($lowestScore / 5), 2) * 100) . "%)";
$highest = $highestScore . "/5 (" . (round(($highestScore / 5), 2) * 100) . "%)";

for ($i = 1; $i <= 5; $i++) {
  $correctCount = ${"Q{$i}CorrectCount"};
  $accuracyNum = (round(($correctCount / $totalResponses), 2) * 100) . "%";
  ${"Q{$i}Accuracy"} = "<td class=\"dataHighlight minecraftText\" style=\"background-color: #F6D387\"> $accuracyNum </td>";
  
  if ((round(($correctCount / $totalResponses), 2)) >= 0.7){
    ${"Q{$i}Difficulty"} = "<td class=\"dataHighlight minecraftText\" style=\"background-color: #97d595\"> Easy </td>";
  }
  else if ((round(($correctCount / $totalResponses), 2)) >= 0.5){
    ${"Q{$i}Difficulty"} = "<td class=\"dataHighlight minecraftText\" style=\"background-color: #fdbc56\"> Medium </td>";
  }
  else{
    ${"Q{$i}Difficulty"} = "<td class=\"dataHighlight minecraftText\" style=\"background-color: #ff8c87\"> Hard </td>";
    
  }

  $totalMessage = "<p class=\"minecraftText\"> <strong> Total number of quiz submissions: </strong> $totalResponses. </p>";
  $timeMessage = "<p class=\"minecraftText\"> <strong> Last updated: </strong> $last_modified. </p>";
}

?>

<html>
    <head>
      <title>
          Admin Page
      </title>

       <!-- MINECRAFT FONT CDN LINK -->
       <link href="https://fonts.cdnfonts.com/css/minecraftia" rel="stylesheet">

      <!-- BOOTSTRAP CDN LINK -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
      
      <!-- BOOTSTRAP META TAGS -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CDN FOR HOME ICON-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

      <!-- CSS LINKS -->
      <link href="../style.css" rel="stylesheet" type="text/css">
      <link href="../assign4/assign4_style.css" rel="stylesheet" type="text/css">
      <link href="assign5_style.css" rel="stylesheet" type="text/css">
      <link rel="icon" type="image/x-icon" href="assign5_files/minecraft_favicon.png">

      <!-- JQUERY LINK -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    </head>

    <body style="margin-left: unset; margin-right: unset; margin-top: unset; margin-bottom: unset; background-image: linear-gradient(to bottom, #253856, #06131B); background-size: contain">

      <div class="container">
        <!-- MADE A SEPARATE PHP FILE FOR THE NAVBAR ELEMENT BECAUSE IT WILL BE USED IN OTHER ASSIGNMENTS -->
        <?php include('navbar.php'); ?>
        
        <br>

        <h1 class="stylizedHeading shadow-lg" style="text-align: center; background-color: #dcdcdc"> Minecraft Quiz Admin Page </h1>
        <br>

        <br>

        <div class="card custom-card shadow-lg">
          <div class="card-body">
            <h3 class="minecraftText" style="text-align: center"> Individual User Responses: </h3>

            <fieldset class="border p-3">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="headerHighlight minecraftText">Name</th>
                          <th class="headerHighlight minecraftText">Q1 Response</th>
                          <th class="headerHighlight minecraftText">Q2 Response</th>
                          <th class="headerHighlight minecraftText">Q3 Response</th>
                          <th class="headerHighlight minecraftText">Q4 Response</th>
                          <th class="headerHighlight minecraftText">Q5 Response</th>
                          <th class="headerHighlight minecraftText">Quiz Score</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php echo $individual ?>
                      </tbody>
                    </table>
                </div> 
              <?php echo $totalMessage ?>
              <?php echo $timeMessage ?>
            </fieldset>

            <br>

            <h3 class="minecraftText" style="text-align: center"> Individual Question Difficulty: </h3>

            <fieldset class="border p-3">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                
                        <tr>
                          <th class="headerHighlight minecraftText">Question Statistics</th>
                          <th class="headerHighlight minecraftText">Question 1</th>
                          <th class="headerHighlight minecraftText">Question 2</th>
                          <th class="headerHighlight minecraftText">Question 3</th>
                          <th class="headerHighlight minecraftText">Question 4</th>
                          <th class="headerHighlight minecraftText">Question 5</th>
                        </tr>
                      </thead>

                      <tbody>
                        <tr>
                        <th class="headerHighlight minecraftText" scope="row"> % Correct </th>
                            <?php
                            echo $Q1Accuracy;
                            ?>

                            <?php
                            echo $Q2Accuracy;
                            ?>

                            <?php
                            echo $Q3Accuracy;
                            ?>

                            <?php
                            echo $Q4Accuracy;
                            ?>
  
                            <?php
                            echo $Q5Accuracy;
                            ?>
                        </tr>

                        <tr>
                        <th class="headerHighlight minecraftText" scope="row"> Difficulty Rating </th>
                            <?php
                            echo $Q1Difficulty;
                            ?>
                          
                            <?php
                            echo $Q2Difficulty;
                            ?>
                         
                            <?php
                            echo $Q3Difficulty;
                            ?>

                           <?php
                            echo $Q4Difficulty;
                            ?>
                         
                            <?php
                            echo $Q5Difficulty
                            ?>
                          </td>
                        </tr>
                      </tbody>  
                    </table>
                </div> 
            </fieldset>

            <br>

           <h3 class="minecraftText" style="text-align: center"> Overall Quiz Statistics: </h3>

            <fieldset class="border p-3">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="headerHighlight minecraftText">Lowest Score</th>
                          <th class="headerHighlight minecraftText">Average Score</th>
                          <th class="headerHighlight minecraftText">Highest Score</th>
                        </tr>
                      </thead>

                      <tbody>
                        <td class="dataHighlight minecraftText" style="background-color: #ff8c87">
                          <?php
                            echo $lowest;
                          ?>
                        </td>

                        <td class="dataHighlight minecraftText" style="background-color: #fdbc56">
                          <?php
                            echo $averageScore;
                          ?>
                        </td>

                        <td class="dataHighlight minecraftText" style="background-color: #97d595">
                          <?php
                            echo $highest;
                          ?>
                        </td>

                      </tbody>
                     
                    </table>
                </div> 
            </fieldset>

            <br>

            <div class="submitResetButton" value ="process">
                <button  class="btn btn-dark btn-lg minecraftText"> 
                <a href="index.php" style="color: white">
                  Return to Quiz
                </a>
                </button>
            </div>  
          </div>
        </div>
        <!-- ADDITIONAL BOOTSTRAP CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
      </div>
    </body>
</html>