// JavaScript Document
<!--
function popup(url) 
{
 var width  = 100;
 var height = 100;
 var left   = (screen.width  - width)/10;
 var top    = (screen.height - height)/10;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=yes';
 params += ', scrollbars=yes';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
// -->


