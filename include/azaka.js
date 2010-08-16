/************************************************************************************
azaka javascript for page.
Commands: (There are other internal commands that you do not need to use or know about)

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
	
forceModulesUpdate()
	reloads all modules and clears timers

grabContent(pagename, [attributes])
	loads page into main content area.
	if attributes are present, they will be added to the url as a GET
	returns false (to prevent standard form action)
	
function sendForm(form, target){
	sends form as a get to target
	will automatically encrypt 'password' and ignore 'cpassword'
	action will be the forms name
	page will be the reciepent page

validateEmail(string)
	checks to see if supplied string is a valid email
	returns boolean
	
validateNumber(string)
	checks to see if string is made of numbers only
	returns boolean
	
validateNotEmpty(string)
	checks to see if string is empty or undefined
***************************************************************************************/

//PAGE SETUP FUNCTIONS
function startPage(){	
	//initiate global variables
	_currentHash = ''; //for tracking the page hash
	_req = Array(); // the request array for ajax
	_errorMessageHandle = ''; // the timer event for error messages. So it can be cancelled should a new one come in.
	_moduleHandles = Array(); // the timer event for module updates. So they can be cancelled when mods are refreshed/removed
	
	//start hashing
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	
	//Set sidebar/modlist to be draggable
	$("#modulelist, #sidebarlist").sortable({
			connectWith: '.connectedSortable',
			placeholder: 'ui-state-highlight'
	}).disableSelection();
	
	//start module bar
	grabModules();
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
	loadPage("modules?type=m", "modulelist");
}
function grabSidebar(){
	loadPage('modules?type=s', 'sidebarlist');
}
function forceHash(){
	grabContent(window.location.hash.substring(1));
}
function checkHash(){
	if(_currentHash != window.location.hash)
		grabContent(window.location.hash.substring(1));
	setTimeout("checkHash()",150);
}
function clearModuleHandles(){
	for (var h in _moduleHandles)
		clearTimeout(h);
}

//AJAX
function grabContent(id, attr){
	window.location.hash = id;
	_currentHash = window.location.hash;
	_animating = true;
	$("#content").fadeTo("fast",0, function() {_animating = false;});
	$("#bottom").fadeTo("fast",0);
	if(document.getElementById('sidebarjs')==undefined) grabSidebar(); else runJs('sidebarjs');
	if(attr==undefined)	loadPage("pages?page="+id,'content');
	else loadPage("pages?page="+id+"&"+attr,'content');
	return false;
}
function sendForm(form, target){
	var options = '';
	for(var counter = 0;form.length != counter;counter++){
		try {
			if(form[counter].name == 'password')
				options += "&" + escape(form[counter].name) + "=" + hex_md5(form[counter].value);
			else if(form[counter].name == 'cpassword');
				//Skip this, no need to send a password twice.				
			else if(form[counter].name != '')
				options += "&" + escape(form[counter].name) + "=" + escape(form[counter].value);
		} catch (e){
			errorMsg(form+"["+counter+"] has thrown error "+e);
		}
	}
	options += "&action="+form.name;
	grabContent(target, options);
	form.action="javascript: return false;";
	return false; //stop default form action from occuring
}
function loadXML(victim){
    if (window.XMLHttpRequest) // native XMLHttpRequest object
        _req["xml"+victim] = new XMLHttpRequest();
     else if (window.ActiveXObject) // IE/Windows ActiveX version
        _req["xml"+victim] = new ActiveXObject("Microsoft.XMLHTTP");
		
	_req["xml"+victim].onreadystatechange = function() {
	
		if (_req["xml"+victim].readyState == 4) {
			if (_req["xml"+victim].status == 200) {
				//var xml = _req["xml"+victim].responseText;
				var xml = (new DOMParser()).parseFromString(_req["xml"+victim].responseText,"text/xml");
				try{eval(document.getElementById('modjs-'+victim).innerHTML);}
				catch(error){
					if(document.getElementById('modjs-'+victim)==undefined)
						errorMsg("Could not find javascript for "+victim);
					else 
						errorMsg("Error running javascript for "+victim);
				}
			} else {
				errorMsg("XML error",victim+" has failed. Error: "+_req["xml"+victim].status+" "+_req[target].statusText);
			}
		}	
	};
	
	_req["xml"+victim].open("GET", "xml/"+victim+".php", true);
	_req["xml"+victim].send();
}
function loadPage(url, target) {
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
			else if(target=='modulelist')
				runJs('modulejs');
			else if(target=='sidebarlist')
				runJs('sidebarjs');
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
function validatePopulated(str){
	return !(str==null || str=='');
}