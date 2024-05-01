#!/usr/local/bin/php
<?php
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false) {
      // QUIZ SCORE
      $score = 0;

      // GET THEIR NAME
      $inputName = htmlspecialchars($_POST['inputName']);

      // CHECK WHAT USER SELECTED FOR FIRST QUESTION
      $year = htmlspecialchars($_POST['year']);

      // IF STATEMENTS TO SET FEEDBACK MESSAGE BASED ON WHAT WAS CHOSEN
      if ($year == "November 18, 2011") {
        $Q1Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: green\"> Correct! </h5> <p class=\"minecraftText minecraftTitle\"> The official version of <em> Minecraft </em> was released at Minecon 2011 when a giant lever was flipped, launching <em> Minecraft </em> version 1.0. </p>";
        $score = $score + 1;
      }
      else if ($year == "February 2, 2012") {
        $Q1Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> While 2012 was a strong year for <em> Minecraft's </em> development, the full version release was not in this year. </p>";
      }
      else if ($year == "May 17, 2009") {
        $Q1Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> While 2009 was the year where <em> Minecraft </em> was technically released for the first time, it was for an early version of the game. This was not the release date for the full version. </p>";
      }
      else if ($year == "November 6, 2014") {
        $Q1Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> This day was monumental for <em> Minecraft </em> as it was the day the company was acquired by Microsoft. However, this is not the day that the game was fully released to the public. </p>";
      }
      else{
        $Q1Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> You did not provide an answer. </p>";
      }

      // CHECK WHAT USER SELECTED FOR SECOND QUESTION
      $yAxis = htmlspecialchars($_POST['Y']);

      // IF STATEMENTS TO SET FEEDBACK MESSAGE BASED ON WHAT WAS CHOSEN
      if ($yAxis == "Y = 13") {
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> This was the ideal Y-Axis coordinate to find diamonds prior to the Cave Update. The Y-Axis has been greatly extended. </p>";
      }
      else if ($yAxis == "Y = -59") {
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: green\"> Correct! </h5> <p class=\"minecraftText minecraftTitle\"> Following the Cave Update in which the Y-Axis was extended to be in the negative values, the new location for finding the most diamonds is roughly Y = -59. </p>";
        $score = $score + 1;
      }
      else if ($yAxis == "Y = 0") {
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> This Y-Axis coordinate was originally the lowest Y-bound prior to the Cave Update. Following the update, the Y-Axis (and the location to find diamonds) has been changed. </p>";
      }
      else if ($yAxis == "Y = -20") {
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> This Y-Axis coordinate acknowledges the notion that the Y-Axis can now be a negative value. However, this is not the general location for where diamonds are more common to spawn. </p>";
      }
      else if ($yAxis == "There is no coordinate where diamonds spawn more.") {
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> It is actually true that a certain region in <em> Minecraft </em> contains more diamonds than other depths. </p>";
      }
      else{
        $Q2Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> You did not provide an answer. </p>";
      }

      // CHECK WHAT USER SELECTED FOR THIRD QUESTION
      $creeper = $_POST['creeper'];

      if ($creeper == "True") {
        $Q3Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: green\"> Correct! </h5> <p class=\"minecraftText minecraftTitle\"> Lighting a creeper on fire by using a flint and steel will force it to ignite and explode. </p>";
        $score = $score + 1;
      }
      else if ($creeper == "False"){
        $Q3Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> A creeper will actually ignite and explode if a player right clicks on it with a flint and steel. </p>";
      }
      else{
        $Q3Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> You did not provide an answer. </p>";
      }

      // CHECK WHAT USER SELECTED FOR FOURTH QUESTION
      $block = htmlspecialchars($_POST['block']);
      
      $blockLower = strtolower(htmlspecialchars($_POST['block']));
      // REMOVE ANY SPACES
      $blockLower = str_replace(array("\r", "\n", ' '), '', $blockLower);    

      if ($blockLower == "commandblock" || $blockLower == "command") {
        $Q4Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: green\"> Correct! </h5> <p class=\"minecraftText minecraftTitle\"> A command block can be used to automate events in <em> Minecraft </em> and perform operations similar to how a computer terminal works. </p>";
        $score = $score + 1;
      }
      else if ($blockLower == "redstoneblock") {
        $Q4Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> $block is similar to the correct answer, but that is more focused on <em> Minecraft's </em> built in circuit mechanisms rather than game commands. Think about what block in <em> Minecraft </em> primarily works with executing <em> commands. </em> </p>";
      }
      else if ($blockLower != "") {
        $Q4Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> $block is not the exact answer. Think about what block in <em> Minecraft </em> primarily works with executing <em> commands. </em> </p>";
      }
      else{
        $Q4Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> You did not provide an answer. </p>";
      }

      // USE A COUNTER TO SEE HOW MANY USER GOT RIGHT/WRONG
      $correctCount = 0;
      $incorrectCount = 0;

      // GET ALL CHECKED ANSWERS FROM FIFTH QUESTION
      $checkedItems = array();
      if(isset($_POST['eggs'])) {
        $checkedItems[] = "Eggs";
        $score = $score + 0.25;
        $correctCount++;
      }
      if(isset($_POST['wheat'])) {
        $checkedItems[] = "Wheat";
        $score = $score + 0.25;
        $correctCount++;
      }
      if(isset($_POST['honey'])) {
        $checkedItems[] = "Honey";
        $score = $score - 0.25;
        $incorrectCount++;
      }
      if(isset($_POST['bread'])) {
        $checkedItems[] = "Bread";
        $score = $score - 0.25;
        $incorrectCount++;
      }
      if(isset($_POST['sugar'])) {
        $checkedItems[] = "Sugar";
        $score = $score + 0.25;
        $correctCount++;
      }
      if(isset($_POST['apples'])) {
        $checkedItems[] = "Apples";
        $score = $score - 0.25;
        $incorrectCount++;
      }
      if(isset($_POST['milk'])) {
        $checkedItems[] = "Milk";
        $score = $score + 0.25;
        $correctCount++;
      }
      if(isset($_POST['water'])) {
        $checkedItems[] = "Water";
        $score = $score - 0.25;
        $incorrectCount++;
      }

      // IF THE SCORE BECOMES NEGATIVE, SET IT TO 0
      if ($score < 0){
        $score = 0;
      }

      // PUT ALL THE SELECTED CHOICES INTO A STRING SEPARATED BY COMMAS
      $selectedItems = "";
      $count = count($checkedItems);
      for ($i = 0; $i < $count - 1; $i++) {
        $selectedItems .= "{$checkedItems[$i]}, ";
      }
      $selectedItems .= "{$checkedItems[$count - 1]}";

      // GIVE FEEDBACK ON INDIVIDUAL CHOICES
      if ($correctCount == 4 && $incorrectCount == 0){
        $Q5Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: green\"> Correct! </h5> <p class=\"minecraftText minecraftTitle\"> You are correct that eggs, wheat, sugar, and milk are used to make a cake in <em> Minecraft. </em> </p>";
      }
      else if ($count > 0){
        // LOOP THROUGH ARRAY OF CHECKED ANSWERS
        // USE IF STATEMENTS TO SELECT APPROPRIATE MESSAGE AND APPEND IT TO THE END OF $Q5FEEDBACK
        $Q5Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5>";
        foreach($checkedItems as $item) {
          if ($item == "Eggs"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> You are correct that <strong> eggs </strong> are used to make a cake in <em> Minecraft. </em> </p>";
          }
          if ($item == "Wheat"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> You are correct that <strong> wheat </strong> is used to make a cake in <em> Minecraft. </em> </p>";
          }
          if ($item == "Honey"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> While a sweet component in cakes, <strong> honey </strong> is not included in <em> Minecraft's </em> cake recipe. </p>";
          }
          if ($item == "Bread"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> <strong> Bread </strong> might be thought of as a possible component in a cake, but this is not in <em> Minecraft's </em> cake recipe. </p>";
          }
          if ($item == "Sugar"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> You are correct that <strong> sugar </strong> is used to make a cake in <em> Minecraft. </em> </p>";
          }
          if ($item == "Apples"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> The red toppings on a <em> Minecraft </em> cake might lead you to think that <strong> apples </strong> are involved in the recipe, but this is not the case. </p>";
          }
          if ($item == "Milk"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> You are correct that <strong> milk </strong> is used to make a cake in <em> Minecraft. </em> </p>";
          }
          if ($item == "Water"){
            $Q5Feedback .= "<p class=\"minecraftText minecraftTitle\"> Water could be an ingredient in a cake, but <em> Minecraft's </em> cake recipe does not involve the use of <strong> water. </strong> </p>";
          }
        }
      }
      else{
        $Q5Feedback = "<h5 class=\"minecraftText minecraftTitle\" style=\"color: red\"> Incorrect. </h5> <p class=\"minecraftText minecraftTitle\"> You did not provide an answer. </p>";
      }
      $score .= "/5";
    } 
    else {
      header("Location: index.php");
      die("Unauthorized access! Please complete the quiz to see this page.");
    }
?>

<html>
    <head>
      <title>
          Your Results
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

    <body style="margin-left: unset; margin-right: unset; margin-top: unset; margin-bottom: unset; background-image: url('assign5_files/dirt.png'); background-size: cover">

      <div class="container">
        <!-- MADE A SEPARATE PHP FILE FOR THE NAVBAR ELEMENT BECAUSE IT WILL BE USED IN OTHER ASSIGNMENTS -->
        <?php include('navbar.php'); ?>
        
        <br>     

        <h1 class="stylizedHeading shadow-lg" style="text-align: center; background-color: #a39ca0"> Minecraft Quiz Results </h1>
        <br>

        <div class="card custom-card shadow-lg">
          <div class="card-body">
            <h1 class="minecraftText">Hello, <?php echo $inputName ?>! </h1>
            <hr>
            <h3 class="minecraftText" style="text-align: center"> Your quiz result is: </h3>
            <h1 name="score" class="minecraftText" style="text-align: center"> <?php echo $score ?> </h1>
          </div>
        </div>

        <br>

        <div class="card custom-card shadow-lg">
          <div class="card-body">
            <h3 class="minecraftText" style="text-align: center"> Question Feedback: </h3>

            <fieldset class="border p-3">
              <legend class="w-auto minecraftText">
                Question 1:
              </legend>
              <h3 class="questionText" style="font-weight: bold">When was the <em> full version </em> of Minecraft released to the public? </h3> <br>
              <h5 class="minecraftText" style="color: orange"> You answered: </h5>
              <p class="minecraftText minecraftTitle"> <?php echo $year ?> </p>
              <br>
              <h5 class="minecraftText" style="color: orange"> Feedback: </h5>
              <?php echo $Q1Feedback ?>
            </fieldset>

            <br>

            <fieldset class="border p-3">
              <legend class="w-auto minecraftText">
                Question 2:
              </legend>
              <h3 class="questionText" style="font-weight: bold"> Following the Cave Update, what is the best Y-Axis level to find diamonds? </h3> <br>
              <h5 class="minecraftText" style="color: orange"> You answered: </h5>
              <p class="minecraftText minecraftTitle"> <?php echo $yAxis ?> </p>
              <br>
              <h5 class="minecraftText" style="color: orange"> Feedback: </h5>
              <?php echo $Q2Feedback ?>
            </fieldset>

            <br>

            <fieldset class="border p-3">
              <legend class="w-auto minecraftText">
                Question 3:
              </legend>
              <h3 class="questionText" style="font-weight: bold"> True or False: <em> "Using a Flint and Steel on a Creeper Makes It Explode" </em> </h3> <br>
              <h5 class="minecraftText" style="color: orange"> You answered: </h5>
              <p class="minecraftText minecraftTitle"> <?php echo $creeper ?> </p>
              <br>
              <h5 class="minecraftText" style="color: orange"> Feedback: </h5>
              <?php echo $Q3Feedback ?>
            </fieldset>

            <br>

            <fieldset class="border p-3">
              <legend class="w-auto minecraftText">
                Question 4:
              </legend>
              <h3 class="questionText" style="font-weight: bold"> What is the name of the block that can be used to execute commands, similar to a terminal, in <em> Minecraft </em>? </h3> <br>
              <h5 class="minecraftText" style="color: orange"> You answered: </h5>
              <p class="minecraftText minecraftTitle"> <?php echo $block ?> </p>
              <br>
              <h5 class="minecraftText" style="color: orange"> Feedback: </h5>
              <?php echo $Q4Feedback ?>
            </fieldset>

            <br>

            <fieldset class="border p-3">
              <legend class="w-auto minecraftText">
                Question 5:
              </legend>
              <h3 class="questionText" style="font-weight: bold"> Which of the following are ingredients used to make a cake? </h3> <br>
              <h5 class="minecraftText" style="color: orange"> You answered: </h5>
              <p class="minecraftText minecraftTitle">
              <?php echo $selectedItems ?>
              </p>
              <br>
              <h5 class="minecraftText" style="color: orange"> Feedback: </h5>
              <?php echo $Q5Feedback ?>
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

<?php

  // IF CSV DOESN'T EXIST CREATE THE HEADERS
  if (!file_exists("data.csv")){
    $myfile = fopen("data.csv", "a") or die("Unable to open file!");
    $headers = "Name, Q1 Response, Q2 Response, Q3 Response, Q4 Response, Q5 Response, Quiz Score\n";
    fwrite($myfile, $headers);
    fclose($myfile);
  }

  // STORE NAME AND QUIZ RESPONSES TO CSV FILE
  $myfile = fopen("data.csv", "a") or die("Unable to open file!");
  
  $userResponse = '"' . $inputName . '","' . $year . '","' . $yAxis . '","' . $creeper . '","' . $block . '","' . $selectedItems . '","' . $score . '"' . "\n";
  fwrite($myfile, $userResponse);
  fclose($myfile);

?>