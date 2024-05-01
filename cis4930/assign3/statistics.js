function findN(array){
    return array.length;
}

function findSum(array){
    var sum = 0;
    for (var i = 0; i < array.length; i++){
        sum += array[i];
    }
    return sum;
}

function findMean(array){
    return (findSum(array) / findN(array));
}

function findMedian(array){
    //COPY THE ARRAY (BY VALUE) AND SORT IT
    var sortedArray = [];
    sortedArray = array.slice();
    sortedArray.sort(function(a, b){return a - b});

    //IF THE ARRAY IS AN ODD LENGTH
    if (sortedArray.length % 2 == 1){
        return (sortedArray[Math.floor(((sortedArray.length) / 2))]);
    }
    //IF THE ARRAY IS AN EVEN LENGTH
    else{
        return ((sortedArray[(Math.floor((sortedArray.length) / 2))] + sortedArray[(Math.floor(((sortedArray.length) / 2)) - 1)]) / 2);
    }
}

function findMode(array){
    var map = {};
    for (var i = 0; i < array.length; i++){
        //IF THE VALUE IN THE ARRAY IS NOT IN THE MAP, THEN ADD IT AND SET THE COUNT TO 1
        if (!map[array[i]]){
            map[array[i]] = 1;
        }
        else{
            //OTHERWISE INCREMENT THE ALREADY EXISTING VALUE IN THE MAP
            map[array[i]]++;
        }
    }

    var largestCount = 0;
    var modeNum = 0;

    for (var key in map) {
        if (map[key] > largestCount){
            largestCount = map[key];
            modeNum = key;
        }
    }
    return modeNum; 
}

function findMax(array){
    var largestNum = array[0];

    for (var i = 0; i < array.length; i++){
        if (array[i] > largestNum){
            largestNum = array[i];
        }
    }
    return largestNum;
}

function findMin(array){
    var smallestNum = array[0];

    for (var i = 0; i < array.length; i++){
        if (array[i] < smallestNum){
            smallestNum = array[i];
        }
    }
    return smallestNum;
}

function findRange(array){
    return findMax(array) - findMin(array);
}

function findVariance(array){

    if (findN(array) == 1){
        return "Please enter at least two digits to find variance."
    }
    else{
        var numerator = 0;
        var mean = findMean(array);
    
        for (var i = 0; i < array.length; i++){
           numerator += Math.pow((array[i] - mean), 2);
        }
        return (numerator / (findN(array) - 1));
    }
}

function findStandardDeviation(array){
    if (findN(array) == 1){
        return "Please enter at least two digits to find standard deviation."
    }
    else{
        return (Math.sqrt(findVariance(array)));
    }
}