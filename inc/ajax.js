//global action
var anidone = true; //tag to show whether animation has completed
var ajaxinuse = false;
var currenthash = '';//current #code in browser
var queue = array();

function queueJah(action){
	
	if(action=='')
		ajaxinuse = false; //push - shift
	else
		try {
			eval("jah("+action+");");
		} catch (err) {
			alert(err+"\n\n"+action);
		}
}
function updateContent(url){
	anidone = false;
	var params = "";
	if(url.indexOf('?')!=-1){
		params = url.substring(url.indexOf('?')+1);
		url = url.substring(0,url.indexOf('?'));
	}
	currenthash = "#"+url.substring(0,url.length-4);
	window.location.hash = currenthash;
    document.getElementById("loader").innerHTML = '<img src="aesthetics/images/loading.gif" />';
	$("#content").fadeTo("fast",0, function() {anidone=true;});
	$("#bottom").fadeTo("fast",0);
	queueJah("'"+url+"', 'content', '"+params+"', 'contentUpdated();'");
}
function contentUpdated(){
	if(req.readyState == 4){
		if(anidone){ //animation hasnt completed - try again in a split second or so
			if(req.status == 200){
				jahDone("content");
				$("#content").fadeTo("fast",1);
				$("#bottom").fadeTo("fast",1);
				if(document.getElementById("pagejs") != null) //run page js
					{ try {eval(document.getElementById("pagejs").innerHTML); } catch (jserror){alert("inpage js error: "+ jserror + "\n\n"+document.getElementById("pagejs").innerHTML);}; }
				else
					alert("Warning: page.php may not have been included.\n\nThis error seems to always come up in IE.");
			} else {//show error page
				queueJah(action);
				updateContent("error.php?code="+req.status+"&msg="+req.responseText);
			}
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
	jah("modules","modules"); //sometimes changes content (only on hard refresh maybe)
	setTimeout("updatemods();",15000);
}
function checkhash(){
	if(currenthash != window.location.hash)
		updateContent(window.location.hash.substring(1)+".php");
	setTimeout("checkhash()",150);
}
function jah(url,target, params, callback) {
	if(ajaxinuse) alert(url+" multiple requests running");
	else {
		ajaxinuse = true;
		document.getElementById("loader").innerHTML = '<img src="aesthetics/images/loading.gif" />';
		// native XMLHttpRequest object
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			if(callback == null || callback == '') req.onreadystatechange = function() {jahDone(target);};
				else req.onreadystatechange = function() {eval(callback);};
			req.open("POST", url, true);
			if(params != null && params != ''){
				req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				req.setRequestHeader("Content-length", params.length);
				req.setRequestHeader("Connection", "close");
				req.send(params);
			} else
				req.send(null);
		// IE/Windows ActiveX version
		} else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
			if (req) {
				if(callback == null || callback == '') req.onreadystatechange = function() {jahDone(target);};
					else req.onreadystatechange = function() {eval(callback);};
				req.open("POST", url, true);
				if(params != null && params != ''){
					req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					req.setRequestHeader("Content-length", params.length);
					req.setRequestHeader("Connection", "close");
					req.send(params);
				} else
					req.send(null);
			}
		}
	}
}
function jahDone(target) {
    // only if req is "loaded"
    if (req.readyState == 4) {
		document.getElementById("loader").innerHTML = "";
        // only if "OK"
        if (req.status == 200) {
            results = req.responseText;
            document.getElementById(target).innerHTML = results;
        } else {
            document.getElementById(target).innerHTML="ajax error:\n" + req.statusText;
        }
		queueJah('');
    }
}