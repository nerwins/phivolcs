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

function ReplaceNumberWithCommas(yourNumber) {
    //Seperates the components of the number
    var n = yourNumber.toString().split(".");
    //Comma-fies the first part
    n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return n.join(".");
}
function createTableBodyFrom2DJSON(JSON,tableid,align){
    if(typeof align === "undefined")
        align = "text-align:center";
    else
        align = "text-align:left";
    var table = document.getElementById(tableid).getElementsByTagName("tbody")[0];
    for (var z = 0; z < JSON.length; z++) {
        var tr = document.createElement("tr");
        for (var y = 0; y < JSON[z].length; y++) {
            var td = document.createElement("td");
            td.setAttribute("style","word-break: break-all;"+align);
            td.innerHTML = JSON[z][y];
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }
    //hides first column, usually a column for the row id
    hidecolumn(0,tableid);
}

$( document ).ajaxStart(function() {
    var controller = document.location.href.match(/[^\/]+$/) != null?document.location.href.match(/[^\/]+$/)[0]:0;
    var excludes = ["login","records","projectload"];
    if(jQuery.inArray(controller,excludes) === -1 && controller != 0)
        $('#loading').modal('show');
});
$( document ).ajaxStop(function() {
    $('#loading').modal('hide');
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
