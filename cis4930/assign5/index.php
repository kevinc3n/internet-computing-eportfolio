#!/usr/local/bin/php

<html>
    <head>
      <title>
          Minecraft Quiz
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

      <script>
        var audio = new Audio('assign5_files/song.mp3');
        document.addEventListener('click', function() {
          audio.play();
        });

        audio.addEventListener('canplaythrough', function() {
          audio.autoplay = true;
          audio.loop = true;
        });
      </script>

    </head>

    <body style="margin-left: unset; margin-right: unset; margin-top: unset; margin-bottom: unset; background-image: url('assign5_files/cloud.png'), linear-gradient(to bottom, rgb(181,219,245), rgb(135,188,254)); background-size: contain; background-position: top">
      <div class="container">
        <!-- MADE A SEPARATE PHP FILE FOR THE NAVBAR ELEMENT BECAUSE IT WILL BE USED IN OTHER ASSIGNMENTS -->
        <?php include('navbar.php'); ?>
        
        <br>     

        <h1 class="stylizedHeading shadow-lg" style="text-align: center; background-color: #7aad72"> Minecraft Quiz </h1>

        <h2 class="stylizedHeading shadow-lg" style="background-color: #a47964; color: #0c1d24;">
            <center>
                Kevin Cen
            </center>
        </h2>

        <div style="text-align: center">
          <img src="assign5_files/spinning.gif" alt="image" class="photoFormat">
        </div> 
    
        <hr>

        <h3 class="minecraftText" style="color: #FFFF00; text-shadow: 3px 3px 0px #3F3F00; margin-bottom: 8px;"><em> Test Your Knowledge of Minecraft!</em> </h3>

        <br>

        <div class="accordion shadow-lg" id="descAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <h5 class="minecraftText"> <i class="fa-solid fa-book"></i> <strong> Preliminary Instructions </strong> </h5>
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#descAccordion">
              <div class="accordion-body questionText">
                <ul>
                  <li> <p> Test your knowledge of <em> Minecraft </em> by taking this five question quiz! </p> </li>
                  <li> <p> A name <strong> must </strong> be entered in order to submit the quiz, but every question <strong> does not </strong> need to be answered (you will be effectively skipping the question by not answering). </p> </li>
                  <li> <p> Follow the instructions under each question to fill out the question type. </p> </li>
                  <li> <p> This quiz is worth <strong> five </strong> points, with each question totaling one point. </p> </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <br>

        <hr>

        <div class="card custom-card shadow-lg">
          <div class="card-body">
            <form id="form" action="process.php" method="post" class="needs-validation" novalidate>
              <!-- ASK FOR NAME -->
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 0:
                </legend>

                <div class="form-group">
                  <label class="questionText" style="font-weight: bold" >What is your name? </label>
                  <p style="font-size: larger"> <em> Please enter your name in the textbox below. </em> </p>
                  
                  <div class="input-group">
                    <input type='text' name='inputName' class="form-control minecraftTitle minecraftText" placeholder="Enter your name here" pattern="^(?=.{1,20}$)[a-zA-Z]+(?: [a-zA-Z]+)?$" required><br>
                    <div class="invalid-feedback minecraftText minecraftTitle">
                      <i class="fas fa-arrow-up"></i> <em> Please type in a valid, 20 character max, name. </em> <br>
                      <br>
                      <strong> Note: </strong> A green outline indicates a valid input, <strong> not </strong> a correct answer choice.
                    </div>
                  </div>
                </div>
                <br>
              </fieldset>

              <!-- FIRST QUESTION -->
              <br>
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 1:
                </legend>

                <div class="form-group row">
                  <div class="col-md-8">
                    <h3 class="questionText" style="font-weight: bold">When was the <em> full version </em> of Minecraft released to the public? </h3>
                    <p style="font-size: larger"> <em> Please select a <strong> single </strong> answer choice below. </em> </p>

                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name='year' value="November 18, 2011" id="2011">
                      <label class="form-check-label minecraftText minecraftTitle" for="2011">
                        November 18, 2011
                      </label>
                    </div>
                    
                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name='year' value="February 2, 2012" id="2009">
                      <label class="form-check-label minecraftText minecraftTitle" for="2009">
                        February 2, 2012
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name='year' value="May 17, 2009" id="2012">
                      <label class="form-check-label minecraftText minecraftTitle" for="2012">
                        May 17, 2009
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name='year' value="November 6, 2014" id="2014">
                      <label class="form-check-label minecraftText minecraftTitle" for="2014">
                        November 6, 2014
                      </label>
                    </div>
                  </div>
                
                  <div class="col-md-4">
                    <img src="assign5_files/notch.png" alt="image" class="photoFormat">
                  </div>
                </div>
                <br>
              </fieldset>

              <!-- SECOND QUESTION -->
              <br>
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 2:
                </legend>

                  <div class="form-group row">
                    <div class="col-md-8">
                      <label class="questionText" style="font-weight: bold"> Following the Cave Update, what is the best Y-Axis level to find diamonds? </label>
                      <p style="font-size: larger"> <em> Please select the correct Y coordinate from the list below. </em> </p>
                    
                      <select name="Y" id="YLevel" class="form-select minecraftText minecraftTitle">
                        <option disabled selected value=""> Click to choose a coordinate </option>
                        <option value="Y = 13"> Y = 13 </option>
                        <option value="Y = -59"> Y = -59 </option>
                        <option value="Y = 0"> Y = 0 </option>
                        <option value="Y = -20"> Y = -20 </option>
                        <option value="There is no coordinate where diamonds spawn more."> There is no coordinate where diamonds spawn more. </option>
                        
                      </select>
                    </div>

                    <div class="col-md-4">
                      <img src="assign5_files/diamond.png" alt="image" class="photoFormat">
                    </div>
                </div>
              </fieldset>

              <!-- THIRD QUESTION -->
              <br>
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 3:
                </legend>

                <div class="form-group row">
                  <div class="col-md-8">
                    <h3 class="questionText" style="font-weight: bold"> True or False: <em> "Using a Flint and Steel on a Creeper Makes It Explode" </em> </h3>
                    <p style="font-size: larger"> <em> Please select either <strong> true </strong> or <strong> false </strong> below. </em> </p>

                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name="creeper" value="True" id="true">
                      <label class="form-check-label minecraftText minecraftTitle" for="true">
                        True
                      </label>
                    </div>
                    
                    <div class="form-check questionText">
                      <input class="form-check-input" type="radio" name="creeper" value="False" id="false">
                      <label class="form-check-label minecraftText minecraftTitle" for="false">
                        False
                      </label>
                    </div>
                
                  </div>

                  <div class="col-md-4">
                    <img src="assign5_files/fire.webp" alt="image" class="photoFormat">
                  </div>
                
              </div>
              </fieldset>


              <!-- FOURTH QUESTION -->
              <br>
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 4:
                </legend>

                <div class="form-group row">
                  <div class="col-md-8">
                    <label class="questionText" style="font-weight: bold" >What is the name of the block that can be used to execute commands, similar to a terminal, in <em> Minecraft </em>? </label>
                    <p style="font-size: larger"> <em> Please enter the name of the block in the textbox below. </em> </p>
                    
                    <div class="input-group">
                      <input type="text" name="block" class="form-control minecraftTitle minecraftText" placeholder="Enter the block name here">
                    </div>

                  </div>

                  <div class="col-md-1">
                    <img src="assign5_files/command.webp" alt="image" class="photoFormat">
                  </div>

                </div>

              </fieldset>

              <!-- FIFTH QUESTION -->
              <br>
              <fieldset class="border p-3">
                <legend class="w-auto minecraftText">
                  Question 5:
                </legend>

                <br>

                <label class="questionText" style="font-weight: bold"> Which of the following are ingredients used to make a cake? </label>
                <p style="font-size: larger"> <em> Please select all ingredients that are used to make a cake in a 3x3 crafting table. </em> </p>

                <div class="form-group row">
                  <div class="col-md-2">

                    <div class="form-check questionText">
                      <input name="eggs" class="form-check-input" type="checkbox" id="eggs">
                      <label class="form-check-label minecraftText minecraftTitle" for="eggs">
                        Eggs
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="wheat" class="form-check-input" type="checkbox" id="wheat">
                      <label class="form-check-label minecraftText minecraftTitle" for="wheat">
                        Wheat
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="honey" class="form-check-input" type="checkbox" id="honey">
                      <label class="form-check-label minecraftText minecraftTitle" for="honey">
                        Honey
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="bread" class="form-check-input" type="checkbox" id="bread">
                      <label class="form-check-label minecraftText minecraftTitle" for="bread">
                        Bread
                      </label>
                    </div>

                  </div>

                  <div class="col-md-6">
                    <div class="form-check questionText">
                      <input name="sugar" class="form-check-input" type="checkbox" id="sugar">
                      <label class="form-check-label minecraftText minecraftTitle" for="sugar">
                        Sugar
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="apples" class="form-check-input" type="checkbox" id="apples">
                      <label class="form-check-label minecraftText minecraftTitle" for="apples">
                        Apples
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="milk" class="form-check-input" type="checkbox" id="milk">
                      <label class="form-check-label minecraftText minecraftTitle" for="milk">
                        Milk
                      </label>
                    </div>

                    <div class="form-check questionText">
                      <input name="water" class="form-check-input" type="checkbox" id="water">
                      <label class="form-check-label minecraftText minecraftTitle" for="water">
                        Water
                      </label>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <img src="assign5_files/cake.png" alt="image" class="photoFormat">
                  </div>
                </div>
              </fieldset>
              <br>
              <div class="submitResetButton" value ="process">
                <button type="submit" id="submitButton" class="btn btn-dark btn-lg minecraftText"> Submit Quiz </button>
                <button id="reset" type="reset" class="btn btn-dark btn-lg minecraftText">Reset</button>
              </div>      
            </form>
          </div>
        </div>

        <br>

        <!-- ADDITIONAL BOOTSTRAP CDN -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


        <script>
          (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
              form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                  event.preventDefault();
                  event.stopPropagation();

                  //GET THE FIRST INVALID ELEMENT IN THE FORM
                  const firstInvalidElem = $(':invalid', form).first();

                  //SCROLL TO THE FIRST INVALID ELEMENT
                  firstInvalidElem.get(0).scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                form.classList.add('was-validated')
              }, false)
            });

            //FIND THE FORM
            const form = $('#form');

            //FIND THE RESET BUTTON
            const resetBtn = $('#reset');

            //WHEN THE BUTTON IS CLICKED, REMOVE THE WAS-VALIDATED CLASS
            resetBtn.on('click', function() {
              // THIS GETS RID OF THE ERROR MESSAGES
              form.removeClass('was-validated');
            });
          
          })()
        </script>
      </div>        
    </body>
    <footer class="minecraftText" style="padding-top: 50px;">Copyright &#169; 2023 Kevin Cen</footer>
</html>