//global action
var anidone = true;  //tag to show whether animation has completed
var currenthash = ''; //current #code in browser

function updateContent(url){
	anidone = false;
	var params = "";
	if(url.indexOf('?') != -1){
		params = url.substring(url.indexOf('?')+1);
		url = url.substring(0,url.indexOf('?'));
	}
	currenthash = "#"+url.substring(0,url.length-4);
	window.location.hash = currenthash;
    document.getElementById("loader").innerHTML = '<img src="aesthetics/images/loading.gif" />';
	//$("#content").fadeTo("fast",0, function() {anidone=true;});
	//$("#bottom").fadeTo("fast",0);
	grab(url,'content', 'params');
}
function contentUpdated(){
	if(req.readyState == 4){
		if(anidone){ //animation hasnt completed - try again in a split second or so
			if(req.status == 200){
				jahDone("content");
				$("#content").fadeTo("fast",1);
				$("#bottom").fadeTo("fast",1);
				if(document.getElementById("pagejs") != null) { //run page js
					try {
						eval(document.getElementById("pagejs").innerHTML);
					} catch (jserror){
						alert("inpage js error: "+ jserror + "\n\n"+document.getElementById("pagejs").innerHTML);
					}
				} else
					alert("Warning: page.php may not have been included. You will be sent straight to the error pages later in development.");
			} else //show error page
				updateContent("error.php?code="+req.status+"&msg="+req.responseText);
		} else 
			setTimeout("contentUpdated();",10);
	}
}
function startautomation(){
	if (window.location.hash == '') updateContent('news.php'); //if no hash default to news page
	setTimeout("checkhash()",500);
	setTimeout("updatemods()",400);
}
function updatemods(){
	queueJah("'modules','modules'"); //sometimes changes content (only on hard refresh maybe)
	setTimeout("updatemods();",15000);
}
function checkhash(){
	if(currenthash != window.location.hash)
		updateContent(window.location.hash.substring(1)+".php");
	setTimeout("checkhash()",150);
}
function queueJah(url,target){
	grab(url,target);
}
function grab(url, target, params) {
	jQuery.post(url, function(d,t,x,target){grabComplete(d,target)});
}
function grabComplete(data,target){
	$(target).html(data);
}