var anidone=false;
function jah(url,target) {
    // native XMLHttpRequest object
	anidone = false;
	$("#"+target).fadeOut("fast", function() {anidone=true;});
	$("#bottom").fadeOut("fast");
    document.getElementById("loader").innerHTML = '<img src="aesthetics/loading.gif" />';
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

function jahDone(target) {
    // only if req is "loaded"
    if (req.readyState == 4) {
			if(!(anidone)){ //animation hasnt completed - 
				setTimeout("jahDone('"+target+"')",100);
				return false;
			}
			
        // only if "OK"
		document.getElementById("loader").innerHTML = "<img src=\"aesthetics/notloading.gif\" />";
		$("#"+target).fadeIn("fast");
		$("#bottom").fadeIn("fast");
        if (req.status == 200) {
            results = req.responseText;
            document.getElementById(target).innerHTML = results;
        } else {
            document.getElementById(target).innerHTML="There has been an ajax error:\n" +
                req.statusText;
        }
    }
}
function changeToolbar($value){
	document.getElementById("toolbar").innerHTML = "lol changed";
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