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

function activateSorting(tableid){
    var table = document.getElementById(tableid)
        ,tableHead = table.querySelector('thead')
        ,tableHeaders = tableHead.querySelectorAll('th')
        ,tableBody = table.querySelector('tbody')
    ;
    tableHead.addEventListener('click',function(e){
        var tableHeader = e.target
            ,textContent = tableHeader.textContent
            ,tableHeaderIndex,isAscending,order
        ;
        while (tableHeader.nodeName!=='TH') {
            tableHeader = tableHeader.parentNode;
        }
        tableHeaderIndex = Array.prototype.indexOf.call(tableHeaders,tableHeader);
        isAscending = tableHeader.getAttribute('data-order')==='asc';
        order = isAscending?'desc':'asc';
        tableHeader.setAttribute('data-order',order);
        tinysort(
            tableBody.querySelectorAll('tr')
            ,{
                selector:'td:nth-child('+(tableHeaderIndex+1)+')'
                ,order: order
            }
        );
    });
}

$( document ).ajaxStart(function() {
    var controller = document.location.href.match(/[^\/]+$/) != null?document.location.href.match(/[^\/]+$/)[0]:0;
    var excludes = ["login","records"];
    if(jQuery.inArray(controller,excludes) === -1 && controller != 0)
        $('#loading').modal('show');
});
$( document ).ajaxStop(function() {
    $('#loading').modal('hide');
});