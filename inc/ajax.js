function jah(url,target) {
    // native XMLHttpRequest object
	$("#"+target).fadeTo("slow", 0);
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
        // only if "OK"
		document.getElementById("loader").innerHTML = "<img src=\"aesthetics/notloading.gif\" />";
		$("#"+target).fadeTo("slow", 1);
        if (req.status == 200) {
            results = req.responseText;
            document.getElementById(target).innerHTML = results;
        } else {
            document.getElementById(target).innerHTML="There has been an ajax error:\n" +
                req.statusText;
        }
    }
}
/*
$(document).ready(function(){
	$("#content").fadeTo("slow", 0.3); // This sets the opacity of the thumbs to fade down to 30% when the page loads
	$("#content").hover(function(){
	$(this).fadeTo("slow", 1.0); // This should set the opacity to 100% on hover
	},function(){
	$(this).fadeTo("slow", 0.3); // This should set the opacity back to 30% on mouseout
	});
});*/