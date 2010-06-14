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
	currenthash = "#"+url;
	window.location.hash = currenthash;
	anidone = false;
    document.getElementById("loader").innerHTML = '<img src="aesthetics/loading.gif" />';
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
            req.open("GET", url, true);
            req.send();
        }
    }
}
function jahDone(target) {
    // only if req is "loaded"
    if (req.readyState == 4) {
	document.getElementById("loader").innerHTML = "<img src=\"aesthetics/notloading.gif\" />";
		if(!(anidone)){ //animation hasnt completed - try again in a split second or so
			setTimeout("jahDone('"+target+"')",10);
			return false;
		}
        // only if "OK"
		document.getElementById("loader").innerHTML = "<img src=\"aesthetics/notloading.gif\" />";
        if (req.status == 200) {
            results = req.responseText;
            document.getElementById(target).innerHTML = results;
			$("#"+target).fadeTo("slow",1);
			$("#bottom").fadeTo("slow",1);
			if(document.getElementById("pagejs") != null)
				eval(document.getElementById("pagejs").innerHTML);
			else {
				alert("Error - inpage javascript not found. Has 'page' been run?");
			}
				
        } else
			jah("error.php?code="+req.status+"&msg="+req.responseText,"content");
    }
}
function gethashing(){
	if (window.location.hash == '')
		jah('news.php','content');
	setTimeout("checkhash()",500);
}

function checkhash(){
	if(currenthash != window.location.hash)
		jah(window.location.hash.substring(1),"content");
	setTimeout("checkhash()",200);
}

//for later reference
function sendPost(url, params){
	var http = new XMLHttpRequest();
	alert(url+"?"+params);
	http.open("POST", url, true);
	//Send the proper header information along with the request
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			alert(http.responseText);
		}
	}
	http.send(params);
}