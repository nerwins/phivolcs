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
        $("#projectlevel").chosen({ width: '100%' });
        $('#datefrom').datepicker({dateFormat: "yy-mm-dd",
            beforeShow: function(input, inst){
                var cal = inst.dpDiv;
                 var top  = $(this).offset().top + $(this).outerHeight();
                 var left = $(this).offset().left;
                 setTimeout(function() {
                    cal.css({
                        'top' : top,
                        'left': left
                    });
                 }, 10);
            },
            onClose: function (selectedDate) {
                $("#dateto").datepicker("option", "minDate", selectedDate);
            },
            onSelect: function(dateText, inst) {
                //getProjectList();
            }
        });
        $('#dateto').datepicker({dateFormat: "yy-mm-dd",
            beforeShow: function(input, inst){
                var cal = inst.dpDiv;
                 var top  = $(this).offset().top + $(this).outerHeight();
                 var left = $(this).offset().left;
                 setTimeout(function() {
                    cal.css({
                        'top' : top,
                        'left': left
                    });
                 }, 10);
            },
            onClose: function (selectedDate) {
                $("#datefrom").datepicker("option", "maxDate", selectedDate);
            },
            onSelect: function(dateText, inst) {
                //getProjectList();
            }
            });
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
        $("#datefrom").datepicker( "setDate", -365);
        $("#dateto").datepicker( "setDate", new Date());
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
        getProjectList();
        activateSorting('projecttable');
        $("#searchButton").click(function(){
            getProjectList(1);
        });
    });

    function getProjectList(init){
        $.getJSON("<?=base_url()?>ProjectArchive/get_project_list_control",{
                projectid: typeof $("#projectname").val() === 'undefined'?0:$("#projectname").val(),
                location: typeof $("#projectlocation").val() === 'undefined'?0:$("#projectlocation").val(),
                priority: $("#projectlevel").val(),
                datefrom: $("#datefrom").val(),
                dateto: $("#dateto").val(),
                init: typeof init === 'undefined'?0:init
            }, function (data) {
            var projects = '<select data-placeholder="Select Project" id="projectname" class="chosen-select a form-control" tabindex="8">';
            var location = '<select data-placeholder="Select Location" id="projectlocation" class="chosen-select a form-control" tabindex="8">';
            projects += '<option value="0">All</option>';
            location += '<option value="0">All</option>';
            $("#projecttable > tbody").html("");
            if (data == "error")
                toggleAlert(0);
            else{
                var table = document.getElementById("projecttable").getElementsByTagName("tbody")[0];

                var locationarray = [];
                for (var z = 0; z < data.length; z++) {
                    var tr = document.createElement("tr");
                    projects+="<option value='"+data[z][0]+"'>"+data[z][1]+"</option>";
                    if(jQuery.inArray(data[z][4], locationarray) === -1){
                        location+="<option value='"+data[z][4]+"'>"+data[z][4]+"</option>";
                        locationarray.push(data[z][4]);
                    }
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
            projects+='</select>';
            location+='</select>';
            $('#projectnamediv').html(projects);
            $('#projectlocationdiv').html(location);
            $("#projectname").chosen({ width: '100%' });
            $("#projectlocation").chosen({ width: '100%' });
            $('#projectlevel, #projectname, #projectlocation').on('change', function(evt, params) {
                //getProjectList();
            });
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
