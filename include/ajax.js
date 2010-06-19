function grabContent(id){
	window.location.hash = id;
	_currentHash = window.location.hash
	_animating = true;
	$("#content").fadeTo("fast",0, function() {_animating = false;});
	$("#bottom").fadeTo("fast",0);
	jah("pages?page="+id,'content');
}
function sendPost(url){
	_animating = true;
	$("#content").fadeTo("fast",0, function() {_animating = false;});
	$("#bottom").fadeTo("fast",0);
	jah(url,'content');
}
function startPage(){
	_req = Array();
	_currentHash='';
	_animating = false;
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	updateMods();
}
function updateMods(){
	if(document.getElementById('modjs')==null)
		jah("modules","modules");
	else
		try{
			eval(document.getElementById('modjs').innerHTML);
		} catch (jserror) {
			alert("module js error: "+ jserror + "\n\n"+document.getElementById("pagejs").innerHTML + "\n\n" + document.getElementById('modjs').innerHTML);
		}
	setTimeout("updateMods();",500);
}
function forceUpdateMods(){
	jah("modules","modules");
}
function checkHash(){
	if(_currentHash != window.location.hash)
		grabContent(window.location.hash.substring(1));
	setTimeout("checkHash()",150);
}
function jah(url,target) {
    // native XMLHttpRequest object
    document.getElementById('loader').innerHTML = '<img src="aesthetics/images/loading.gif" alt="loading..."/>';
    if (window.XMLHttpRequest) {
        _req[target] = new XMLHttpRequest();
        _req[target].onreadystatechange = function() {jahDone(target);};
        _req[target].open("GET", url, true);
        _req[target].send(null);
    // IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        _req = new ActiveXObject("Microsoft.XMLHTTP");
        if (_req[target]) {
            _req[target].onreadystatechange = function() {jahDone(target);};
            _req[target].open("GET", url, true);
            _req[target].send();
        }
    }
}
function jahDone(target) {
    // only if _req is "loaded"	
    if (_req[target].readyState == 4) {
        // only if "OK"
		document.getElementById('loader').innerHTML = '';
		if(target == 'content' && _animating){ //delay rendering if content is still _animating - only affects content
			setTimeout("jahDone('"+target+"');",10);
			return false;
		}
        if (_req[target].status == 200) {
            document.getElementById(target).innerHTML = _req[target].responseText;
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
				jah("pages?page=error&code="+_req[target].status+"&msg="+_req[target].statusText,"content");
			else {
				document.getElementById('loader').innerHTML='<div id="error"> loading ' + target + ": " + _req[target].statusText + '</div>';
				setTimeout("document.getElementById('loader').innerHTML=''",1000);
			}
        }
		if(target=='content'){
			$("#content").fadeTo("fast",1);
			$("#bottom").fadeTo("fast",1);
		}
    }
}