/*---------------------------------

---- Margus David
---- created: 01.02.2014
---- oDesk job - Custom PHP survey application
---- file: index.js, jQuery Plugin,

---------------------------------*/


////////////////////////////////////
// Get App
window.app = new kendo.mobile.Application($(document.body), {
	transition: "fade",
	inital: "page-home",
	platform: {
		device: "ipad",
		name: "ios",
		ios: true,
		majorVersion: 7,
		minorVersion: "0.0",
		flatVersion: 500,
		appMode: true,
		tablet: "ipad"
	},
	loading: "<h3>Processing...</h3>"
});

// Load App
window.kendoMobileApplication = window.app;

// global variables
var gender = "";
var answers = new Array;
var result = new Array;

// contoller model
var bsModel = kendo.observable({
	initHome: function(){
		setTimeout(function(){
			// go to start page
			window.app.navigate("#page-start");
		}, 1000);
	},
	initStart: function(){
		$("#page-start input[type=button]#start-app").click(function(){
			window.app.navigate("#page-gender");
		});
	},
	initGender: function(){
		$("#page-gender input[type=button]#go-next").click(function(){
			gender = $("#page-gender input[type=radio][name=gender]:checked").val();
			if(!gender){
				alert("Please choose gender!");
				return false;
			} else {
				window.app.navigate("#page-first-description");
			}
		});
	},
	initFristDes: function(){
		$("#page-first-description input[type=button]#go-next").click(function(){
			window.app.navigate("#page-first");
		});
	},
	initFirst: function(){		
		$("#page-first input[type=button]#go-next").click(function(){
			var tmp = new Array;
			for(var i = 1; i <= 4; i++){
				answers["q" + i] = parseFloat($("#page-first input[type=radio][name=q" + i + "]:checked").val());
				tmp[tmp.length] = answers["q" + i];
				if(!answers["q" + i]){
					alert("Please choose answers correctly");
					return false;
				}
			}
			tmp.sort();
			for(var i = 0; i < tmp.length - 1; i++){
				if(tmp[i] == tmp[i + 1]){
					alert("Please choose answers correctly");
					return false;
				}
			}
			
			window.app.navigate("#page-second-description");
		});
	},
	initSecondDes: function(){	
		$("#page-second-description input[type=button]#go-next").click(function(){
			window.app.navigate("#page-second");
		});
	},
	initSecond: function(){	
		$("#page-second input[type=button]#go-next").click(function(){
			var tmp = new Array;
			for(var i = 5; i <= 7; i++){
				answers["q" + i] = parseFloat($("#page-second input[type=radio][name=q" + i + "]:checked").val());
				if(!answers["q" + i]){
					alert("Please choose answers correctly");
					return false;
				}
			}
			
			window.app.navigate("#page-result");
		});
	},
	initResult: function(){
		if(!answers){
			alert("Sorry, couldn't find params info, please try again.");
			//window.location.href = baseURL;
			return false;
		}
		
		var countResult = 0;

		////
		$("#page-result input[type=button]#go-next").click(function(){
			if(countResult > 0){				
				window.app.navigate("#page-contact");
			} else {
				if(confirm("Sorry, calculation have no result. Do you want to retry calculation?")){
					window.location.href = baseURL;
				}
			}
		});

		// get result
		$("#page-result .result-section").html("");
		window.app.showLoading();
		$.ajax({
			type: "POST",
			url: ajaxURL,
			data: {
				action: "result",
				values: calcModel.init(answers, gender)
			},
			dataType :"json",
			success : function(response){
				window.app.hideLoading();

				// sample response
			/*	response = {
					result: [
						{
							link: "http://localhost/bs",
							img: "http://localhost/bs/contents/1.jpg"
						},
						{
							link: "http://localhost/bs",
							img: "http://localhost/bs/contents/2.jpg"
						}
					]
				};
			*/
				// process response
				//console.log(response);
				
				result = response.result;
				for(var i in result){
				//	$("#page-result .result-section").append("<a href = \"" + (result[i].link? result[i].link: "") + "\"><img src = \"" + result[i].img + "\"/></a>");
					$("#page-result .result-section").append("<img src = \"" + result[i].img + "\"/>");
					countResult++;
				}
				////
				if(countResult == 0){
					$("#page-result .result-section").html("<error>NO RESULT</error>");
				}
			},
			error: function(httpReq,status,exception){
				//console.log(status + ", " + exception);

				window.app.hideLoading();					
				alert("ERROR: server connection failed");
				return false;
			}
		});
	},
	initContact: function(){
		if(!answers || !result){
			alert("Sorry, couldn't find params info, please try again.");
			window.location.href = baseURL;
			return false;
		}

		////
		$("#page-contact input[type=button]#go-next").click(function(){
			var contact_email = global.isEmail($("#page-contact input[type=text]#email").val());
			var contact_hours = global.parseFloatStr($("#page-contact input[type=text]#hours").val());

			if(!contact_email){
				alert("Please enter email correctly");
				$("#page-contact input[type=text]#email").val("").focus();
				return false;
			}
			if(!contact_hours){
				alert("Please enter hours correctly");
				$("#page-contact input[type=text]#hours").val("").focus();
				return false;
			}

			// save contact info
			var updateAnswers = new Array;
			for(var k in answers){
				updateAnswers[questionIDs[k]] = answers[k];
			}

			window.app.showLoading();
			$.ajax({
				type: "POST",
				url: ajaxURL,
				data: {
					action: "contact",
					gender: (gender == "male"? 1: 2),
					email: contact_email,
					hours: contact_hours,
					answers: updateAnswers,
					result: result
				},
				dataType :"json",
				success : function(response){
					window.app.hideLoading();

					// sample response
				/*	response = {
						result: [
							{
								link: "http://localhost/bs",
								img: "http://localhost/bs/contents/1.jpg"
							},
							{
								link: "http://localhost/bs",
								img: "http://localhost/bs/contents/2.jpg"
							}
						]
					};
				*/
					// process response
					//console.log(response);
					
					if(response.success){
						window.app.navigate("#page-last");
						return true;
					} else {
						if(confirm("Sorry, your contact info or the calculation is incorrect. Do you want to retry calculation?")){
							window.location.href = baseURL;
						}
						return false;
					}
				},
				error: function(httpReq,status,exception){
					//console.log(status + ", " + exception);

					window.app.hideLoading();					
					alert("ERROR: server connection failed");
					return false;
				}
			});
		});
	},
	initLast: function(){
		$("#page-last input[type=button]#go-next").click(function(){
			window.location.href = baseURL;
		});
	}
});