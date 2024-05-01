function findStatistics(){

    //MAKE IT SO THE BUTTON IS NO LONGER TOGGLEABLE AFTER THE FIRST CLICK
    var button = document.getElementById("submitButton");
    button.removeAttribute('data-bs-toggle');

    var input = document.getElementById("inputText").value;
    var values = input.split(" ");
    var numbers = [];
    for (var i = 0; i < values.length; i++) {
        var num = parseFloat(values[i]);
        numbers.push(num);
    }

    const hasOnlyNaN = numbers.every(isNaN);

    if (hasOnlyNaN){
      document.getElementById("displayNum").innerHTML = "No values entered.";
      resetTable();
    }
    else{
      var displayString = "";
    
      for (var i = 0; i < numbers.length - 1; i++) {
          displayString += numbers[i] + ", "
      }

      displayString += numbers[numbers.length - 1];

      document.getElementById("displayNum").innerHTML = displayString;

      document.getElementById("number").innerHTML = findN(numbers);
      document.getElementById("sum").innerHTML = findSum(numbers);
      document.getElementById("mean").innerHTML = findMean(numbers).toFixed(2);
      document.getElementById("median").innerHTML = findMedian(numbers).toFixed(2);
      document.getElementById("mode").innerHTML = findMode(numbers);
      document.getElementById("max").innerHTML = findMax(numbers);
      document.getElementById("min").innerHTML = findMin(numbers);
      document.getElementById("range").innerHTML = findRange(numbers);
      if (isNaN(findVariance(numbers))){
        document.getElementById("variance").innerHTML = findVariance(numbers);
      }
      else{
        document.getElementById("variance").innerHTML = findVariance(numbers).toFixed(2);
      }
      if (isNaN(findStandardDeviation(numbers))){
        document.getElementById("SD").innerHTML = findStandardDeviation(numbers);
      }
      else{
        document.getElementById("SD").innerHTML = findStandardDeviation(numbers).toFixed(2);
      }
    }
}

function resetTable(){
  document.getElementById("number").innerHTML = "";
  document.getElementById("sum").innerHTML = "";
  document.getElementById("mean").innerHTML = "";
  document.getElementById("median").innerHTML = "";
  document.getElementById("mode").innerHTML = "";
  document.getElementById("max").innerHTML = "";
  document.getElementById("min").innerHTML = "";
  document.getElementById("range").innerHTML = "";
  document.getElementById("variance").innerHTML = "";
  document.getElementById("SD").innerHTML = "";
}