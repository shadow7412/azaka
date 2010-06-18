function grabContent(id){
	window.location.hash = id;
	$("#content").fadeTo("fast",0, function() {anidone=true;});
	$("#bottom").fadeTo("fast",0);
	jah("pages?page="+id,'content');
}
function updateModule(id){
	jah("modules?update="+id,'mod-'+id);
}
function startPage(){
	req = Array();
	currenthash='';
	if (window.location.hash == '') grabContent('news'); //if no hash default to news page
	checkHash();
	updateMods();
}
function updateMods(){
	//jah("'modules','modules'"); //sometimes changes content (only on hard refresh maybe)
	setTimeout("updateMods();",15000);
}
function checkHash(){
	if(currenthash != window.location.hash){
		currenthash = window.location.hash
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
        if (req[target].status == 200) {
            document.getElementById(target).innerHTML = req[target].responseText;
        } else {
			if(target=='content')
				jah("pages/error.php?code="+req[target].status+"&msg="+req[target].statusText,"content");
			else {
				document.getElementById('loader').innerHTML='<div id="error"> loading ' + target + ": " + req[target].statusText + '</div>';
				setTimeout("document.getElementById('loader').innerHTML=''",1000);
			}
        }
		if(target=='content'){
				$("#content").fadeTo("fast",1);
				$("#bottom").fadeTo("fast",1);
		}
    }
}