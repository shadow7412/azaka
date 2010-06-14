//global action
var anidone = false;
var currenthash = '';

function jah(url,target) {
    // native XMLHttpRequest object
	if(url.indexOf('?')!=-1)
		currenthash = String(url).substring(indexOf('?'));
	else 
		currenthash = url;
	window.location.hash = currenthash;
	
	anidone = false;
    document.getElementById("loader").innerHTML = '<img src="aesthetics/loading.gif" />';
	$("#"+target).fadeTo("fast",0, function() {anidone=true;});
	$("#bottom").fadeTo("fast",0);
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
        req.onreadystatechange = function() {jahDone(target);};
        req.open("GET", url, true);
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
function gethashing(){
	if (window.location.hash == '')
		jah('news.php','content');
	setTimeout("checkhash()",500);
}

function checkhash(){
	if("#"+currenthash != window.location.hash){
		jah(window.location.hash.substring(1),"content");
	}
	setTimeout("checkhash()",200);
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
        } else {
			jah("error.php?code="+req.status+"&msg="+req.responseText,"content");
        }
    }
}

//for later reference
function sendPost(){
	var url = "get_data.php";
	var params = "lorem=ipsum&name=binny";
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