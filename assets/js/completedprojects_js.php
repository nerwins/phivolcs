<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:56 PM
 */
?>
<script>
    $(function() {
        $('#projectsub').attr('class', 'active');
        $('#vproject').attr('class', 'active');
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
            '.chosen-select-width': {width: "95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        getProjectList();
        var status = "";
        if(getUrlParameter("status") != ""){
            status = getUrlParameter("status");
            if(status == 1)
                toggleAlert(2);
            else if (status == 2)
                toggleAlert(3);
            else if(status == 3)
                toggleAlert(4);
        }
        activateSorting("projecttable");
    });

    function getProjectList(){
        $.getJSON("<?=base_url()?>CompletedProjects/get_project_list_control", function (data) {
            if (data == "error")
                toggleAlert(0);
            else{
                var table = document.getElementById("projecttable").getElementsByTagName("tbody")[0];
                for (var z = 0; z < data.length; z++) {
                    var tr = document.createElement("tr");
                    for (var y = 0; y < data[z].length; y++) {
                        var td = document.createElement("td");
                        td.innerHTML = data[z][y];
                        tr.appendChild(td);
                    }
                    table.appendChild(tr);
                }
                $('td:nth-child(1),th:nth-child(1)').hide();
                $('table td:nth-child(1)').addClass('projid');
                toggleAlert(1);
                $("#projecttemp table tbody tr").click(function() {
                    showRedirect($(this).find(".projid").text(),3);
                });
                $(".showTasks,.viewSreport,.showProgressReports").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
            }
        });
    }
    function showRedirect(id,redirect){
        var pages = ['viewreport','progress','task','viewproject','assignproject','createreport'];
        window.location.replace(pages[redirect] +'?id=' + id);
    }
    function toggleAlert(status){
        switch(status){
            case 0:
                //hide projects table
                $("#projectalert").show();
                $('#projecttemp').hide();
                break;
            case 1:
                //show projects table
                $("#projectalert").hide();
                $('#projecttemp').show();
                break;
            case 2:
                //redirected from approved project
                $("#projectapproved").show();
                $("#projectalert").hide();
                $('#projecttemp').hide();
                $("#revisionapproved").hide();
                $("#projectdeclined").hide();
                break;
            case 3:
                //redirected from approved revisions
                $("#revisionapproved").show();
                $("#projectapproved").hide();
                $("#projectalert").hide();
                $("#projectdeclined").hide();
                $('#projecttemp').hide();
                break;
            case 4:
                //redirected from declined project
                $("#projectdeclined").show();
                $("#revisionapproved").hide();
                $("#projectapproved").hide();
                $("#projectalert").hide();
                $('#projecttemp').hide();
                break;
        }
    }
</script>
