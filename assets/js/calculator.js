/*---------------------------------

---- Margus David
---- created: 02.02.2014
---- oDesk job - Custom PHP survey application
---- file: calculator model

---------------------------------*/


////////////////////////////////////
// calculator model

var calcModel = kendo.observable({
	init: function(answers, gender){
		if(!answers) return false;

		if(gender == "male" || !gender){
			// male
			var values = new Array;
			values[1] = 0.504 + 0.064 * answers["q3"] + 0.137 * answers["q7"] - 0.055 * answers["q2"] - 0.027 * answers["q5"];
			values[2] = 1.06 + 0.078 * answers["q4"] + 0.002 * answers["q7"] - 0.082 * answers["q1"];
			values[3] = 1.28 + 0.1 * answers["q6"] + 0.027 * answers["q5"] - 0.057 * answers["q2"] - 0.108 * answers["q7"];
			values[4] = 0.237 + 0.162 * answers["q2"] + 0.034 * answers["q4"] + 0.053 * answers["q1"] + 0.033 * answers["q5"];
			values[5] = 1.555 + 0.126 * answers["q1"] - 0.109 * answers["q3"] - 0.138 * answers["q4"];
		} else {
			// female
			var values = new Array;
			values[1] = 0.504 + 0.064 * answers["q3"] + 0.137 * answers["q7"] - 0.055 * answers["q2"] - 0.027 * answers["q5"];
			values[2] = 1.06 + 0.078 * answers["q4"] + 0.002 * answers["q7"] - 0.082 * answers["q1"];
			values[3] = 1.28 + 0.1 * answers["q6"] + 0.027 * answers["q5"] - 0.057 * answers["q2"] - 0.108 * answers["q7"];
			values[4] = 0.237 + 0.162 * answers["q2"] + 0.034 * answers["q4"] + 0.053 * answers["q1"] + 0.033 * answers["q5"];
			values[5] = 1.555 + 0.126 * answers["q1"] - 0.109 * answers["q3"] - 0.138 * answers["q4"];
		}
		//console.log(values);

		var topValue = [0, 0];
		var topValueIndex = [0, 0];
		for(var i in values){
			if(topValue[0] <= values[i]){
				topValue[1] = topValue[0];
				topValueIndex[1] = topValueIndex[0];
				topValue[0] = values[i];
				topValueIndex[0] = i;
			} else if(topValue[1] < values[i]){
				topValue[1] = values[i];
				topValueIndex[1] = i;
			}
		}
		return topValueIndex;
	}
});


