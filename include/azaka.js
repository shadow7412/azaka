/************************************************************************************
azaka javascript for page.
Commands to be used:

startPage()
	Makes sidebar and module bar active,
	Inits global variables
	Starts checking hashes.
	If no hash defined, default to news.
	no return
	
errorMsg(message, [extra info])
	Displays message for a few seconds. Used instead of alert()
	no return

runJs(elementID)
	evals value of element provided. Note to provide id and not the actual element.
	no return

grabContent(pagename, [attributes])
	loads page into main content area.
	if attributes are present, they will be added to the url as a GET
	no return
	
validateEmail(string)
	checks to see if supplied string is a valid email
	returns booleen
	
validateNumber(string)
	checks to see if string is made of numbers only
***************************************************************************************/

//PAGE SETUP FUNCTIONS
function startPage(){	
	//initiate global variables
	_currentHash = ''; //for tracking the page hash
	_req = Array(); // the request array for ajax
	_errorMessageHandle = ''; // the timer event for error messages. So it can be cancelled should a new one come in.
	
	//beta warning
	errorMsg('Core is undergoing reconstruction.','Expect things to go BOOM CRASH SPLASH KADO-O-O-O-KU!');
	
	//start hashing
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	
	//Set sidebar/modlist to be draggable
	$("#modulelist, #sidebarlist").sortable({
			connectWith: '.connectedSortable'
	}).disableSelection();
}
function errorMsg(message,extrainfo){
	clearTimeout(_errorMessageHandle);
	var table;
	if (extrainfo==undefined) table='<table>';
	else table='<table onclick="alert(\''+extrainfo+'\')">';
	document.getElementById('error').innerHTML=table+'<tr><td><span class=\"ui-icon ui-icon-alert\"></span></td><td>'+message+'</td></tr></table>  ';
	_errorMessageHandle = setTimeout("document.getElementById('error').innerHTML=''",3000);
}
function runJs(target){
	if(document.getElementById(target) != null)
		try { eval(document.getElementById(target).innerHTML); }
		catch (jserror) { errorMsg(target+" has thrown a javascript error:"+jserror,document.getElementById(target).innerHTML);}
	else
		errorMsg(target+" does not exist. Javascript not run.");
}
function grabModules(){
	
}
function grabSidebar(){
	
}
function forceUpdateMods(){
	loadPage("modules","modules");
}
function forceHash(){
	grabContent(window.location.hash.substring(1));
}
function checkHash(){
	if(_currentHash != window.location.hash)
		grabContent(window.location.hash.substring(1));
	setTimeout("checkHash()",150);
}

//AJAX
function grabContent(id, attr){
	window.location.hash = id;
	_currentHash = window.location.hash;
	_animating = true;
	$("#content").fadeTo("fast",1, function() {_animating = false;});
	$("#bottom").fadeTo("fast",1);
	runJs('sidebarjs');
	if(attr==undefined)	loadPage("pages?page="+id,'content');
	else loadPage("pages?page="+id+"&"+attr,'content');
}
function grabXML(){

}
function loadContent(){

}
function loadXML(){

}
function loadPage(url, target, callback) {
    document.getElementById('loader').innerHTML = '<img src="aesthetics/images/loading.gif" alt="loading..."/>';
    if (window.XMLHttpRequest) // native XMLHttpRequest object
        _req[target] = new XMLHttpRequest();
     else if (window.ActiveXObject) // IE/Windows ActiveX version
        _req[target] = new ActiveXObject("Microsoft.XMLHTTP");
	_req[target].onreadystatechange = function() {jahDone(target)};
	_req[target].open("GET", url, true);
	_req[target].send();
}
function jahDone(target) {
    // only if _req is "loaded"	
    if (_req[target].readyState == 4) {
        // only if "OK"
		document.getElementById('loader').innerHTML = '';
		if(target == 'content' && _animating){ //delay rendering if content is still animating - only affects content
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
				loadPage("pages?page=error&code="+_req[target].status+"&msg="+_req[target].statusText,"content");
			else
				errorMsg(' loading ' + target + ": " + _req[target].statusText)
        }
		if(target=='content'){
			$("#content").fadeTo("fast",1);
			$("#bottom").fadeTo("fast",1);
		}
    }
}

//INPUT ENTRY
function enterNumbers(element){
	evt = (evt) ? evt : window.event;
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)){
		errorMsg('This field only likes numbers.');
		return false;
	} else
		return true;
}

//VALIDATION
function validateEmail(str){
	//http://www.smartwebby.com/DHTML/email_validation.asp#explanation
	var lat=str.indexOf("@");
	var lstr=str.length;
	var ldot=str.indexOf(".");
	if (str.indexOf("@")==-1)
	   return false;
	if (str.indexOf("@")==-1 || str.indexOf("@")==0 || str.indexOf("@")==lstr)
	   return false;
	if (str.indexOf(".")==-1 || str.indexOf(".")==0 || str.indexOf(".")==lstr)
		return false;
	 if (str.indexOf("@",(lat+1))!=-1)
		return false;
	 if (str.substring(lat-1,lat)=="." || str.substring(lat+1,lat+2)==".")
		return false;
	 if (str.indexOf(".",(lat+2))==-1)
		return false;
	 if (str.indexOf(" ")!=-1)
		return false;
	 return true;
}
function validateNumber(str){
	return !isNaN(str);
}