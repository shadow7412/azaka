/************************************************************************************
azaka javascript for page.
Commands: (There are other internal commands that you do not need to use or know about)

== PAGE ==

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
	
== AJAX ==

grabContent(pagename, [attributes])
	loads page into main content area.
	if attributes are present, they will be added to the url as a GET
	returns false (to prevent standard form action)
	
function sendForm(form, target, [order]){
	sends form as a get to target
	will automatically encrypt 'password' and ignore 'cpassword'
	action will be the forms name
	page will be the reciepent page
	if defined, order will be a list (seperated by whitespace) showing the id of the
		first element in each list item. This can be used to determin the results of
		click/drag type postitioning.

loadXML(module, [atrributes])
	Loads xml for module
	If attributes are given, passed as $_GET to xml
	
== VALIDATION ==
validateEmail(string)
	checks to see if supplied string is a valid email
	returns boolean
	
validateNumber(string)
	checks to see if string is made of numbers only
	returns boolean
	
validatePopulated(string)
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
	checkHash(); //start hashchecking loop
	
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
function grabSidebar(){
	var sbjs;
	//clear current js before reloading it
	if((sbjs = document.getElementById('sidebarjs')) != undefined) sbjs.innerHTML='';
	loadPage('modules?type=s', 'sidebarlist');
}
function grabModules(){
	//Clear running module handles before reloading module bar
	//Not doing this would either:
	//Throw an error should the module not exist when script is run
	//or make the modules run at double speed - as they create a second handle
	//when reloaded.
	
	for (var h in _moduleHandles)
		clearTimeout(_moduleHandles[h]);
	loadPage('modules?type=m', "modulelist");
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
	$("#content").fadeTo("fast",0, function() {_animating = false;});
	$("#bottom").fadeTo("fast",0);
	if(document.getElementById('sidebarjs')==undefined) grabSidebar(); else runJs('sidebarjs');
	if(attr==undefined)	loadPage("pages?page="+id,'content');
	else loadPage("pages?page="+id+"&"+attr,'content');
	false; //returning false makes inferiour browsers say 'false' on the screen
}
function sendForm(form, target, list){
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
	if(list != undefined){
		var order = '';
		var element = list.firstElementChild;
		if(element != undefined){
			order += element.firstElementChild.value+' ';
			while (element = element.nextElementSibling) order += element.firstElementChild.value+' ';
		}
		options += '&order='+order
	}
	options += "&action="+form.name;
	grabContent(target, options);
	form.action="javascript: return false;";
	return false; //stop default form action from occuring
}
function loadXML(victim, attr){
    if (window.XMLHttpRequest) // native XMLHttpRequest object
        _req["xml"+victim] = new XMLHttpRequest();
     else if (window.ActiveXObject) // IE/Windows ActiveX version
        _req["xml"+victim] = new ActiveXObject("Microsoft.XMLHTTP");
	document.getElementById('mod-icon-'+victim).className = "ui-icon ui-icon-arrowrefresh-1-e";
	//The code in the next block runs AFTER the xml is loaded.
	_req["xml"+victim].onreadystatechange = function() {
		if (_req["xml"+victim].readyState == 4) {
				try{
					var xml = (new DOMParser()).parseFromString(_req["xml"+victim].responseText,"text/xml");
				} catch (error){
					//If DOMParser does not fire, user is likely an IE person. Try the ActiveX version.
					errorMsg("IE does not like XML at this stage.");
					return;
				}
			if (_req["xml"+victim].status == 200) {
				try{
					eval(document.getElementById('modjs-'+victim).innerHTML);
					document.getElementById('mod-icon-'+victim).className = "ui-icon ui-icon-arrow-4-diag";
				} catch(error){
					document.getElementById('mod-icon-'+victim).className = "ui-icon ui-icon-alert";
					if(document.getElementById('modjs-'+victim)==undefined)
						errorMsg("Could not find javascript for "+victim);
					else 
						errorMsg("Error running javascript for "+victim +" : "+ error);
				}
			} else {
				document.getElementById('mod-icon-'+victim).className = "ui-icon ui-icon-alert";
				setTimeout(function(){loadXML(victim,attr)},1000);
			}
		}	
	};
	//Back in real code now.
	if(attr==undefined)
		_req["xml"+victim].open("GET", "xml/"+victim+".php", true);
	else
		_req["xml"+victim].open("GET", "xml/"+victim+".php"+'&'+attr, true);
	_req["xml"+victim].send();
	//Will run the 'function' area last
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
				errorMsg('error loading ' + target + ": "  + _req[target].status + _req[target].statusText)
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
