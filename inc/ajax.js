//global action
var anidone = false;
var currenthash = '';

function jah(url,target) {
    // native XMLHttpRequest object
	var params;
	if(url.indexOf('?')!=-1){
		params = url.substring(url.indexOf('?')+1);
		url = url.substring(0,url.indexOf('?'));
	}
	currenthash = "#"+url.substring(0,url.length-4);
	window.location.hash = currenthash;
	anidone = false;
    document.getElementById("loader").innerHTML = '<img src="aesthetics/images/loading.gif" />';
	$("#"+target).fadeTo("fast",0, function() {anidone=true;});
	$("#bottom").fadeTo("fast",0);
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = function() {jahDone(target);};
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
            req.onreadystatechange = function() {jahDone(target);};
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
function jahDone(target) {
    // only if req is "loaded"
    if (req.readyState == 4) {
	document.getElementById("loader").innerHTML = "";
		if(!(anidone)){ //animation hasnt completed - try again in a split second or so
			setTimeout("jahDone('"+target+"')",10);
			return false;
		}
        // only if "OK"
		document.getElementById("loader").innerHTML = "";
        if (req.status == 200) {
            results = req.responseText;
            document.getElementById(target).innerHTML = results;
			$("#"+target).fadeTo("fast",1);
			$("#bottom").fadeTo("fast",1);
			if(document.getElementById("pagejs") != null)
				eval(document.getElementById("pagejs").innerHTML);
			else {
				alert("Warning: page.php may not have been included.\n\nThis error seems to always come up in IE.");
			}	
        } else
			jah("error.php?code="+req.status+"&msg="+req.responseText,"content");
    }
}
function startautomation(){
	if (window.location.hash == '') jah('news.php','content'); //if no hash default to news page
	setTimeout("checkhash()",500);
	updatemods();
}
function checkmods(){
	jah("modules/","modules");
	setTimeout("updatemods();",1000);
}
function checkhash(){
	if(currenthash != window.location.hash)
		jah(window.location.hash.substring(1)+".php","content");
	setTimeout("checkhash()",150);
}
