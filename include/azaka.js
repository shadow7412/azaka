function startPage(){
	_req = Array();
	_currentHash='';
	_animating = false;
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	updateMods();
}
function grabContent(id){
	window.location.hash = id;
	_currentHash = window.location.hash;
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
function runJs(target){
	if(document.getElementById(target) != null)
		try {
			eval(document.getElementById(target).innerHTML);
		} catch (jserror) {
		document.getElementById('loader').innerHTML='<span class=\"ui-icon-alert ui-state-error ui-corner-all\" onclick="javascript:alert(document.getElementById(\''+target+'\').innerHTML)"> jserror ' + target + ": " + jserror + '</span>';
				setTimeout("document.getElementById('loader').innerHTML=''",3000);
		}
	else
		errorMsg(target+" does not exist.");
}
function updateMods(){
	if(document.getElementById('modjs')==null)
		jah("modules","modules");
	else
		runJs('modjs');
}
function forceUpdateMods(){
	jah("modules","modules");
}
function forceHash(){
	grabContent(window.location.hash.substring(1));
}
function checkHash(){
	if(_currentHash != window.location.hash)
		grabContent(window.location.hash.substring(1));
	setTimeout("checkHash()",150);
}
function jah(url,target) {
    document.getElementById('loader').innerHTML = '<img src="aesthetics/images/loading.gif" alt="loading..."/>';
    if (window.XMLHttpRequest) // native XMLHttpRequest object
        _req[target] = new XMLHttpRequest();
     else if (window.ActiveXObject) // IE/Windows ActiveX version
        _req[target] = new ActiveXObject("Microsoft.XMLHTTP");
	_req[target].onreadystatechange = function() {jahDone(target)};
	_req[target].open("GET", url, true);
	_req[target].send(null);

}
function grabXML(url, target){
    if (window.XMLHttpRequest) 
        _req[target] = new XMLHttpRequest();
    // IE/Windows ActiveX version
    else if (window.ActiveXObject)
        _req[target] = new ActiveXObject("Microsoft.XMLHTTP");
	_req[target].open("GET", url, false);
	_req[target].send();
	return _req[target].responseText;
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
			if(target=='content')
				runJs('pagejs');
			else if(target=='modules')
				runJs('modjs');
        } else {
			if(target=='content')
				jah("pages?page=error&code="+_req[target].status+"&msg="+_req[target].statusText,"content");
			else
				errorMsg(' loading ' + target + ": " + _req[target].statusText)
        }
		if(target=='content'){
			$("#content").fadeTo("fast",1);
			$("#bottom").fadeTo("fast",1);
		}
    }
}
function errorMsg(message){
	document.getElementById('loader').innerHTML='<span class=\"ui-icon-alert ui-state-error ui-corner-all\">  '+message+'  </span>';
	setTimeout("document.getElementById('loader').innerHTML=''",3000);
}