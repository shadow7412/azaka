function grabContent(id){
	window.location.hash = id;
	currenthash = window.location.hash
	animating = true;
	$("#content").fadeTo("fast",0, function() {animating = false;});
	$("#bottom").fadeTo("fast",0);
	jah("pages?page="+id,'content');
}
function updateModule(id){
	jah("modules?update="+id,'mod-'+id);
}
function startPage(){
	req = Array();
	currenthash='';
	var animating = false;
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	updateMods();
}
function updateMods(){
	jah("modules","modules");
	setTimeout("updateMods();",4000);
}
function checkHash(){
	if(currenthash != window.location.hash){
		grabContent(window.location.hash.substring(1));
	}
	setTimeout("checkHash()",150);
}
function jah(url,target) {
    // native XMLHttpRequest object
    document.getElementById('loader').innerHTML = '<img src="aesthetics/images/loading.gif" alt="loading..."/>';
    if (window.XMLHttpRequest) {
        req[target] = new XMLHttpRequest();
        req[target].onreadystatechange = function() {jahDone(target);};
        req[target].open("GET", url, true);
        req[target].send(null);
    // IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req[target]) {
            req[target].onreadystatechange = function() {jahDone(target);};
            req[target].open("GET", url, true);
            req[target].send();
        }
    }
}
function jahDone(target) {
    // only if req is "loaded"	
    if (req[target].readyState == 4) {
        // only if "OK"
		document.getElementById('loader').innerHTML = '';
		if(target == 'content' && animating){ //delay rendering if content is still animating - only affects content
			setTimeout("jahDone('"+target+"');",10);
			return false;
		}
        if (req[target].status == 200) {
            document.getElementById(target).innerHTML = req[target].responseText;
			if(target=='content'){
				if(document.getElementById("pagejs") != null) { //run page js
						try {
							eval(document.getElementById("pagejs").innerHTML);
						} catch (jserror){
							alert("inpage js error: "+ jserror + "\n\n"+document.getElementById("pagejs").innerHTML);
						}
					} else
						alert("Warning: page.php may not have been included. You will be sent straight to the error pages later in development.");
			}
        } else {
			if(target=='content')
				jah("pages?page=error&code="+req[target].status+"&msg="+req[target].statusText,"content");
			else {
				document.getElementById('loader').innerHTML='<div id="error"> loading ' + target + ": " + req[target].statusText + '</div>';
				setTimeout("document.getElementById('loader').innerHTML=''",1000);
			}
        }
		if(target=='content'){
				$("#content").fadeTo("fast",1);
				$("#bottom").fadeTo("fast",1);
		} else if(target=="module"){
			alert('runjs');
		}
    }
}