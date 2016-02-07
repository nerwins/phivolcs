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
        getSkillSetList();
        getEmployeesList();
        $("#divisionddl").chosen({width: "100%"});
        $("#positionddl").chosen({width: "100%"});
        $("#datestartfrom, #datestartto").datepicker({
          dateFormat: "yy-mm-dd"
        });
        $('#skillbutton').click(function(){
            newSkillSet();
        });
        $('#empButton').click(function(){
            newEmployee();
        });
        $("#saveSkillSet").click(function(){
            var id = $(this).attr('name') == "null"?0:$(this).attr('name');
            saveSkillSet(id);
        });
        $('#saveEmployee').click(function(){
            var id = $(this).attr('name') == "null"?0:$(this).attr('name');
            saveEmployee(id);
        });
        $("#searchSkillset").keyup(function (e) {
            toggleAlert(11);
            getSkillSetList();
        });
        $('#divisionddl, #positionddl').on('change', function(e) {
            toggleAlert(15);
            getEmployeesList();
        });
        $("#searchEmp").keyup(function (e) {
            toggleAlert(15);
            getEmployeesList();
        });
        $("#datestartfrom, #datestartto").change(function(){
            toggleAlert(15);
            getEmployeesList();
        });
    });
    function newSkillSet(){
        $('#skilltitle').html("Add Skillset");
        $('#sname').val("");
        $('#sdesc').val("");
        $('#saveSkillSet').attr('name','null');
        $('#skillalert').css('display','none');
        $('#smodalalert').css('display','none');
        $('#skillsModal').modal('show');
    }
    function getSkillSetList(){
        $.get("<?=base_url()?>records/get_skillset_list_control",{searchSkillset:$("#searchSkillset").val()},
            function(data) {
                if (data == "error")
                    toggleAlert(0);
                else {
                    $("#skillsets").empty();
                    var tbl=document.createElement('table');
                    tbl.setAttribute("class","table table-striped table-advance table-hover");
                    tbl.setAttribute("id","skillstable");
                    tbl.setAttribute("style","text-align:center");
                    var thead=document.createElement('thead');

                    var th=document.createElement("th");
                    th.innerHTML="<center>ID</center>";
                    var th2=document.createElement("th");
                    th2.innerHTML="<center><i class='icon_profile'></i>&nbsp;Name</center>";
                    var th3=document.createElement("th");
                    th3.innerHTML="<center><i class='icon_document_alt'></i>&nbsp;Description</center>";
                    thead.appendChild(th);
                    thead.appendChild(th2);
                    thead.appendChild(th3);
                    var tbody=document.createElement("tbody");
                    for(var x = 0; x < data.length; x++){
                        var tr=document.createElement("tr");
                        for(var y = 0; y < data[x].length; y++){
                            var td=document.createElement("td");
                            td.setAttribute("onclick","getSkillsetDetails(this);");
                            td.setAttribute("style","word-wrap: break-word;");
                            td.appendChild(document.createTextNode(data[x][y]));
                            tr.appendChild(td);
                        }
                        var tdbutton=document.createElement("td");
                        tdbutton.innerHTML="<button onclick='deleteSkillSet("+data[x][0]+")' class='btn btn-danger'><i class='icon_close_alt2'></i></button>";
                        tr.appendChild(tdbutton);
                        tbody.appendChild(tr);
                    }
                    tbl.appendChild(thead);
                    tbl.appendChild(tbody);
                    document.getElementById("skillsets").appendChild(tbl);
                    hidecolumn(0,"skillstable");
                    activateSorting("skillstable")
                    toggleAlert(1);
                    loadSkills();
                }
            },'JSON');
    }
    function saveSkillSet(id){
        var skillID = id;
        var skillName = $('#sname').val();
        var skillDesc = $('#sdesc').val();
        $.post("<?=base_url()?>records/update_skillset_detail_control",
            {
                skillID: skillID,
                skillName : skillName,
                skillDesc : skillDesc
            },function(data){
                data = data.replace(/\"/g, "");
                if(data == 'error')
                    toggleAlert(4);
                else{
                    toggleAlert(5);
                    $('#skillsModal').modal('hide');
                    if(id == 0)
                        toggleAlert(8);
                    else
                        toggleAlert(9);
                    getSkillSetList();
                }
            });
    }
    function getSkillsetDetails(x){
        $('#skilltitle').html("Update Skillset");
        var index=x.parentNode.rowIndex;
        rowindex=index;
        var id=document.getElementById("skillstable").getElementsByTagName("tbody")[0].getElementsByTagName("tr")[index].getElementsByTagName("td")[0].innerHTML;
        $('#saveSkillSet').attr('name',id);

        $.getJSON("<?=base_url()?>records/get_skillset_detail_control",{id:id},function(data){
            $('#sname').val(data[1]);
            $('#sdesc').val(data[2]);
            toggleAlert(5);
            $('#skillsModal').modal('show');
        });
    }
    function deleteSkillSet(x){
        var index=x.parentNode.parentNode.rowIndex;
        var skillID=document.getElementById("skillstable").getElementsByTagName("tbody")[0].getElementsByTagName("tr")[index].getElementsByTagName("td")[0].innerHTML;
        $.post("<?=base_url()?>records/delete_skillset_detail_control",
            {
                skillID: skillID
            },function(data){
                data = data.replace(/\"/g, "");
                if(data.length > 0){
                    var names = data.split(",");
                    var list = "";
                    for(var x = 0; x < names.length; x++){
                        list += names[x];
                        list += "\n";
                    }
                    swal("Unable to delete", "Conflicts found! The following employee have this skillset:\n"+list,"info");
                }else{
                    toggleAlert(10);
                    getSkillSetList();
                }
            });
    }

    function newEmployee(){
        $("#employeetitle").html("Add Employee");
        $('#fname').val('');
        $('#mi').val('');
        $('#lname').val('');
        $('#email').val('');
        <?php if($_SESSION['position'] == 1){?>
            $('#did').val('1');
            $('#pid').val('2');
        <?php }?>
        $('#employeealert').css('display','none');
        $('#filters option:selected').removeAttr('selected');
        $('#filters').trigger('chosen:updated');
        $('#saveEmployee').attr('name',0);
        $('#employeeModal').modal('show');
    }
    function getEmployeesList(){
        $.get("<?=base_url()?>records/get_employees_list_control",
            {name: $("#searchEmp").val(),
            division: $("#divisionddl").val(),
            position: $("#positionddl").val(),
            datefrom: $("#datestartfrom").val(),
            dateto: $("#datestartto").val()},
            function(data) {
                if (data == "error")
                    toggleAlert(2);
                else{
                    $("#employees").empty();
                    var tbl=document.createElement('table');
                    tbl.setAttribute("class","table table-striped table-advance table-hover");
                    tbl.setAttribute("id","employeestable");
                    tbl.setAttribute("style","text-align:center");
                    var thead=document.createElement('thead');
                    var tr=document.createElement("tr");
                    var th=document.createElement("th");
                    th.innerHTML="<center>ID</center>";
                    var th2=document.createElement("th");
                    th2.innerHTML="<font color='#797979'><center><i class='icon_profile'></i>&nbsp;Name</center></font>";
                    var th3=document.createElement("th");
                    th3.innerHTML="<font color='#797979'><center><i class='icon_globe'></i>&nbsp;Division</center></font>";
                    var th4=document.createElement("th");
                    th4.innerHTML="<font color='#797979'><center><i class='icon_genius'></i>&nbsp;Position</center></font>";
                    var th5=document.createElement("th");
                    th5.innerHTML="<font color='#797979'><center><i class='icon_calendar'></i>&nbsp;Date Started</center></font>";
                    tr.append
                    tr.appendChild(th);
                    tr.appendChild(th2);
                    tr.appendChild(th3);
                    tr.appendChild(th4);
                    tr.appendChild(th5);
                    thead.appendChild(tr);
                    var tbody=document.createElement("tbody");
                    for(var x = 0; x < data.length; x++){
                        var tr=document.createElement("tr");
                        for(var y=0;y<data[x].length;y++){
                            var td=document.createElement("td");
                            td.appendChild(document.createTextNode(data[x][y]));
                            tr.appendChild(td);
                        }
                        var tdbutton2=document.createElement("td");
                        tdbutton2.innerHTML="<button onclick='getEmployeeDetails("+data[x][0]+")' class='btn btn-info'><i class='icon_cog'></i></button>";
                        tr.appendChild(tdbutton2);
                        var tdbutton=document.createElement("td");
                        tdbutton.innerHTML="<button onclick='deleteEmployee("+data[x][0]+")' class='btn btn-danger'><i class='icon_close_alt2'></i></button>";
                        tr.appendChild(tdbutton);
                        tbody.appendChild(tr);
                    }
                    tbl.appendChild(thead);
                    tbl.appendChild(tbody);
                    document.getElementById("employees").appendChild(tbl);
                    hidecolumn(0,"employeestable");
                    activateSorting("employeestable");
                    toggleAlert(3);
                }
            },'JSON');
    }
    function saveEmployee(id){
        var employeeID = id;
        var employeeFName = $('#fname').val();
        var employeeMInitial = $('#mi').val();
        var employeeLName = $('#lname').val();
        var employeeEmail = $('#email').val();
        var employeeSkillsets = $('#filters').val();
        var employeeDID = $("select[id='did'] option:selected").index();
        var employeePID = $("select[id='pid'] option:selected").index();
        $.post("<?=base_url()?>records/update_employee_detail_control",
            {
                employeeID: employeeID,
                employeeFName: employeeFName,
                employeeMInitial: employeeMInitial,
                employeeLName: employeeLName,
                employeeEmail: employeeEmail,
                employeeDID: employeeDID,
                employeePID: employeePID,
                employeeSkillsets: employeeSkillsets
            },function(data){
                data = data.replace(/\"/g, "");
                if(data == 'error')
                    toggleAlert(6);
                else{
                    toggleAlert(7);
                    if(id == 0)
                        toggleAlert(12);
                    else
                        toggleAlert(13);
                    $('#employeeModal').modal('hide');
                    getEmployeesList();
                }
        });
    }
    function getEmployeeDetails(x){
        $("#employeetitle").html("Update Employee");
        var id = x;
        $.getJSON("<?=base_url()?>records/get_employee_detail_control",{id:id},function(data){
            $('#fname').val(data[0]);
            $('#mi').val(data[1]);
            $('#lname').val(data[2]);
            $('#email').val(data[3]);
            <?php if($_SESSION['position'] == 1){?>
                $("#did").get(0).selectedIndex = data[4];
                $("#pid").get(0).selectedIndex = data[5];
            <?php }?>
            $('#filters').val(data[6]);
            $('#filters').trigger('chosen:updated');
        });
        $('#saveEmployee').attr('name',id);
        $('#employeeModal').modal('show');
    }
    function deleteEmployee(x){
        var employeeID = x;
        $.post("<?=base_url()?>records/delete_employee_detail_control",
            {
                employeeID: employeeID
            },function(data){
                data = data.replace(/\"/g, "");
                if(data == 'error'){
                    swal("Unable to delete", "This employee is currently assigned to a project.","info");
                }else{
                    toggleAlert(14);
                    getEmployeesList();
                }
            });
    }
    function loadSkills(){
        $('#sfilters').html("");
        $.getJSON("<?=base_url()?>records/get_skillset_list_control",{},function(data){
            var skillsets="";
            skillsets+='<select data-placeholder="Filter Tags" style="width:510px;" id="filters" multiple class="chosen-select a form-control" tabindex="8">';

            for(var x=0;x<data.length;x++){
                skillsets+="<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
            }
            skillsets+='</select>'
            $('#sfilters').html(skillsets);

            var config = {
                '.chosen-select': {width: "100%"},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "100%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
            $("filters").chosen({ width: '100%' });
        });
    }

    function toggleAlert(status){
        switch(status){
            case 0:
                //hide skillset table
                $("#skillalert").show();
                $("#skillsets").hide();
                break;
            case 1:
                //show skillset table
                $("#skillalert").hide();
                $("#skillsets").show();
                break;
            case 2:
                //hide employee table
                $("#employeealert").show();
                $("#employees").hide();
                break;
            case 3:
                //show employee table
                $("#employeealert").hide();
                $("#employees").show();
                break;
            case 4:
                //skillset already exists
                $('#smodalalert').show();
                break;
            case 5:
                //skillset exists hide
                $('#smodalalert').hide();
                break;
            case 6:
                //employee already exists
                $('#emodalalert').show();
                break;
            case 7:
                //employee exists hide
                $('#emodalalert').hide();
                break;
            case 8:
                //add skillset
                $("#skillalertadd").show();
                $("#skillalert").hide();
                $("#skillalertupdate").hide();
                $("#skillalertdelete").hide();
                break;
            case 9:
                //update skillset
                $("#skillalertadd").hide();
                $("#skillalert").hide();
                $("#skillalertupdate").show();
                $("#skillalertdelete").hide();
                break;
            case 10:
                //delete skillset
                $("#skillalertadd").hide();
                $("#skillalert").hide();
                $("#skillalertupdate").hide();
                $("#skillalertdelete").show();
                break;
            case 11:
                //hide or reset all skillset
                $("#skillalertadd").hide();
                $("#skillalert").hide();
                $("#skillalertupdate").hide();
                $("#skillalertdelete").hide();
                break;
            case 12:
                //add employee
                $("#employeeadd").show();
                $("#employeealert").hide();
                $("#employeeupdate").hide();
                $("#employeedelete").hide();
                break;
            case 13:
                //update employee
                $("#employeeadd").hide();
                $("#employeealert").hide();
                $("#employeeupdate").show();
                $("#employeedelete").hide();
                break;
            case 14:
                //delete employee
                $("#employeeadd").hide();
                $("#employeealert").hide();
                $("#employeeupdate").hide();
                $("#employeedelete").show();
                break;
            case 15:
                //hide or reset all employee
                $("#employeeadd").hide();
                $("#employeealert").hide();
                $("#employeeupdate").hide();
                $("#employeedelete").hide();
                break;
        }
    }
</script>
