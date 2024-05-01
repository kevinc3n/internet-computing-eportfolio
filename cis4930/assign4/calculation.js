$(document).ready(function() {
  //IF NONE IS SELECTED, MAKE ALL OTHER OPTIONS DISABLED
  $('#none').change(function() {
    if ($(this).is(':checked')) {
      $('input[type="checkbox"]').not('#none').prop('disabled', true);
      $('input[type="checkbox"]').not('#none').prop('checked', false);
    } else {
      $('input[type="checkbox"]').not('#none').prop('disabled', false);
    }
  });
  
  //IF ONE CHOICE FROM L1-L3 IS SELECTED, DISABLE ALL OTHER CHECKBOXES IN THAT SECTION
  $('input[type="checkbox"]').filter('[id^="L"]').change(function() {
    if ($(this).is(':checked')) {
      $('input[type="checkbox"]').filter('[id^="L"]').not(this).prop('disabled', true);
    } else {
      $('input[type="checkbox"]').filter('[id^="L"]').not(this).prop('disabled', false);
    }
  });

  //IF ONE CHOICE FROM AE1-AE3 IS SELECTED, DISABLE ALL OTHER CHECKBOXES IN THAT SECTION
  $('input[type="checkbox"]').filter('[id^="AE"]').change(function() {
    if ($(this).is(':checked')) {
      $('input[type="checkbox"]').filter('[id^="AE"]').not(this).prop('disabled', true);
    } else {
      $('input[type="checkbox"]').filter('[id^="AE"]').not(this).prop('disabled', false);
    }
  });

  //IF ONE CHOICE FROM AN1-AN3 IS SELECTED, DISABLE ALL OTHER CHECKBOXES IN THAT SECTION
  $('input[type="checkbox"]').filter('[id^="AN"]').change(function() {
    if ($(this).is(':checked')) {
      $('input[type="checkbox"]').filter('[id^="AN"]').not(this).prop('disabled', true);
    } else {
      $('input[type="checkbox"]').filter('[id^="AN"]').not(this).prop('disabled', false);
    }
  });

  var originalForm = null;

  //SERIALIZE THE PAGE (SAVE THE CONTENTS OF IT)
  $('#form').submit(function() {
    originalForm = $(this).serialize();
  });

  //IF THE FORM IS EVER CHANGED AND NOT THE SAME AS THE SERALIZED VERSION, REMOVE THE ANSWER BOX
  $('#form').on('change', function() {
    if (originalForm !== null && $(this).closest('form').serialize() !== originalForm) {
      $('#answerBox').addClass('hidden');
    }
  });
});

//NEED TO BE OUTSIDE $(DOCUMENT).READY SINCE THE FUNCTIONS CANNOT BE CALLED FROM OUTSIDE IF THEY ARE PLACED INSIDE THERE
function convertToCm(inputFeet, inputInch){
  inputFeet = inputFeet * 30.48;
  inputInch = inputInch * 2.54;
  return inputFeet + inputInch;
}

function convertToKilo(inputWeight){
  return inputWeight / (2.205);
}

function calculateMultiplier(){
  //GO THROUGH ALL THE CHECKBOXES AND, FOR EACH CHECKED CHECKBOX, ADD ITS VALUE TO THE SUM
  var totalScore = 0;

  $('input[type="checkbox"]').each(function() {
    if($(this).prop('checked')) {
      totalScore += parseInt($(this).val());
    }
  });  

  if (totalScore >= 8 && totalScore <= 9){
      return 1.725;
  }
  else if (totalScore >= 6 && totalScore <= 7){
      return 1.55;
  }
  else if (totalScore >= 3 && totalScore <= 5){
      return 1.375;
  }
  else if (totalScore >= 1 && totalScore <= 2){
      return 1.2;
  }
  else{
      return 1;
  }
}

function calculateBMR(){
  // GET THE WEIGHT AND STORE IN VARIABLE
  const inputWeight = $('#weightInput').val();
  const weight = convertToKilo(inputWeight);

  // GET THE FEET/INCH AND CONVERT TO CM
  const inputFeet = $('#feetInput').val();
  const inputInch = $('#inchInput').val();
  const height = convertToCm(inputFeet, inputInch);

  const age = $('#ageInput').val();

  const BMRMultiplier = calculateMultiplier();

  var BMR = 0;

  if ($('#male').prop('checked')){
    BMR = (10 * weight) + (6.25 * height) - (5 * age) + 5;
  }
  else{
    BMR = (10 * weight) + (6.25 * height) - (5 * age) - 161;
  }

  $('#answerBox').removeClass('hidden');

  BMR = Math.round(BMR);
  $('#baseline').html(BMR);

  var multipliedBMR = Math.round(BMR * BMRMultiplier);
  $('#adjusted').html(multipliedBMR);
}