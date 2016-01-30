/**
 * Created by George Vasquez II on 1/24/2016.
 */

function hidecolumn(colno,tableid){
    var theadrows = document.getElementById(tableid).getElementsByTagName("thead")[0].getElementsByTagName("th");
    theadrows[colno].style.display="none";
    var tbodyrows = document.getElementById(tableid).getElementsByTagName("tbody")[0].getElementsByTagName("tr");
    for(var x=0;x<tbodyrows.length;x++){
        var cell=tbodyrows[x].getElementsByTagName("td");
        cell[colno].style.display="none";
    }
}

$( document ).ajaxStart(function() {
    var controller = document.location.href.match(/[^\/]+$/) != null?document.location.href.match(/[^\/]+$/)[0]:0;
    var excludes = ["login"];
    if(jQuery.inArray(controller,excludes) === -1 && controller != 0)
        $('#loading').modal('show');
});
$( document ).ajaxStop(function() {
    $('#loading').modal('hide');
});