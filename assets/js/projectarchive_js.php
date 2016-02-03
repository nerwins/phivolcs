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
    });

    function getProjectList(){
        $.getJSON("<?=base_url()?>ProjectArchive/get_project_list_control", function (data) {
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
            }
        });
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
        }
    }
</script>
