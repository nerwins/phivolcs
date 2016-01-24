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
        $('#skillbutton').click(function(){
            newSkillSet();
        });
        $("#saveSkillSet").click(function(){
            var id = $(this).attr('name') == "null"?0:$(this).attr('name');
            saveSkillSet(id);
        })

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
        $.get("<?=base_url()?>records/get_skillset_list_control",
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
                            td.setAttribute("onclick","getDetails(this);");
                            td.setAttribute("style","word-wrap: break-word;");
                            td.appendChild(document.createTextNode(data[x][y]));
                            tr.appendChild(td);
                        }
                        var tdbutton=document.createElement("td");
                        tdbutton.innerHTML="<button onclick='deleteSkillSet(this)' class='btn btn-danger'><i class='icon_close_alt2'></i></button>";
                        tr.appendChild(tdbutton);
                        tbody.appendChild(tr);
                    }
                    tbl.appendChild(thead);
                    tbl.appendChild(tbody);
                    document.getElementById("skillsets").appendChild(tbl);
                    hidecolumn(0,"skillstable");
                    toggleAlert(1);
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
                    $('#skillsModal').modal('hide');
                    toggleAlert(5);
                    getSkillSetList();
                }
        });
    }
    function getDetails(x){
        $('#skilltitle').html("Update Skillset");
        var index=x.parentNode.rowIndex;
        rowindex=index;
        var id=document.getElementById("skillstable").getElementsByTagName("tbody")[0].getElementsByTagName("tr")[index].getElementsByTagName("td")[0].innerHTML;
        $('#saveSkillSet').attr('name',id);

        $.getJSON("<?=base_url()?>records/get_skillset_detail_control",{type:1,id:id},function(data){
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
                }else
                    getSkillSetList();
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
                break;
            case 3:
                //show employee table
                break;
            case 4:
                //skillset already exists
                $('#smodalalert').show();
                break;
            case 5:
                //skillset exists hide
                $('#smodalalert').hide();
                break;
        }
    }
</script>
