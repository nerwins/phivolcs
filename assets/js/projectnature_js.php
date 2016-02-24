<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:56 PM
 */?>
 <script>


    $('#filters').chosen({width: "100%"});
    function closeAlert() {
        $('#modalAlert').css("display","none");
    }
    //$('#pbutton').on('click', function () {
    function addNature() {
        $('#save').val(0);
        $('#name').val("");
        $('#etitle').html("Add Project Nature");
        $('#description').val("");
        $('#filters').val(-1);
        $('#filters').trigger("chosen:updated");
        $('#dataModal').modal('show');
        $('#modalAlert').hide();
        $('#addmodalbody').find("input,ul,textarea").css('border-color', '');
    }
    //});
    function saveNature() {
        $('#modalAlert').hide();
        $('#addmodalbody').find("input,ul,textarea").css('border-color', '');
        var flag = false;
        $('#addmodalbody').find("input,select,textarea").each(function () {
            if ($(this).val() == "" || $(this).val() == null) {
                if ($(this).is("select")) {
                    $($(this).closest("td")[0]).find("ul").css('border-color', 'red');
                    flag = true;
                } else if ($(this).parent().attr("class") == undefined) {
                    $(this).css('border-color', 'red');
                    flag = true;
                }
            }
        })
        if (flag) {
            $('#alertMessage').html("Field/s cannot be left blank!");
            $('#modalAlert').css("display","block");
            return;
        }
    
        var id = 0;
        if ($('#save').val() == 1) {
            id = $('#save').attr("nid");
        }
     
        var skills_arr = $("#filters").val();
     
        $.post("<?=base_url()?>projectnature/update_nature_control", {id: id, type: $('#save').val(), name: $('#name').val(), description: $('#description').val(), 'skills[]': skills_arr }, function (data) {
            if (data == 1) {
                $('#dataModal').modal('hide');
                loadNatures();
            }
            else {
                $('#alertMessage').html(data);
                $('#modalAlert').css("display","block");
            }

        }, 'json');
    }

    loadNatures();
    loadSkills();

    function loadNatures() {
        $('#pnaturetable tbody').html("");

        $.getJSON("<?=base_url()?>projectnature/get_nature_list_control", {type: 1}, function (data2) {
            var data = data2[0];

            for (var y = 0; y < data.length; y++) {
                $('#pnaturetable tbody').append("<tr><td>" + data[y][1] + "</td><td>" + data[y][2] + "</td>\n\
    	<td><button class='btn btn-info' onclick='editNature(" + data[y][0] + ")'><i class='icon_cog'></i></button>\n\
        <button class='btn btn-danger' onclick='deleteNature(" + data[y][0] + ")'><i class='icon_trash'></i></button></td></tr>");
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
    function editNature(id) {
        $.getJSON("<?=base_url()?>projectnature/get_nature_list_control", {id: id, type: 2}, function (data) {
            $('#etitle').html("Edit Nature");
            $('#save').val(1);
            $('#save').attr("nid", id);
            $('#name').val(data[0][0][1]);
            $('#description').val(data[0][0][2]);
            $('#filters').val(data[1]);
            $('#filters').trigger("chosen:updated");
            $('#dataModal').modal('show');
            $('#modalAlert').hide();
            $('#addmodalbody').find("input,ul,textarea").css('border-color', '');
        });

    }
    function deleteNature(id) {
        var check = confirm("Proceed to deleting project nature?");
        if (check) {
            $.post("<?=base_url()?>projectnature/delete_nature_control", {id: id}, function (data) {
                if (data == "1") {
                    $('#dataModal').modal('hide');
                    loadNatures();
                }
            }, 'json');
        }
    }
    $('#pnature').addClass('active')
</script>