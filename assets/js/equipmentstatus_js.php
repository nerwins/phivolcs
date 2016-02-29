<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:57 PM
 */
?>

<script>
	$(function(){
		$('#reports').addClass("active");
	    $('#rproj2').addClass("active");
	    $("#status").chosen({ width: '100%' });
	    $('#status').on('change', function(e) {
			getEquipmentStatus();
	  	});
	    $('#returndate').datepicker({dateFormat: "yy-mm-dd",
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
	            getEquipmentStatus();
	        }
	    });
        $("#returndate").datepicker( "setDate", new Date());
        activateSorting('etable');
        getProjectList();
	});
	function getEquipmentStatus(){
		$.getJSON("<?=base_url()?>equipmentstatus/get_equipment_status_control",{
			equipment: $("#equipments").val(),
			returndate: $("#returndate").val(),
			status: $("#status").val(),
			project: $("#projects").val()
		},function(data){
			$('#etable > tbody').html("");
			$('#rtitle').html("Equipment Statuses");
			if(data != 'error'){
				$("#etable").show();
				var table = document.getElementById('etable').getElementsByTagName("tbody")[0];
			    for (var z = 0; z < data.length; z++) {
			        var tr = document.createElement("tr");
			        for (var y = 0; y < data[z].length; y++) {
			            var td = document.createElement("td");
			            td.setAttribute("style","word-break: break-all;");
			            td.innerHTML = data[z][y];
			            tr.appendChild(td);
			        }
			        table.appendChild(tr);
			    }
			}else{
				$("#etable").hide();
			}
		});
	}
	function getProjectList(){
		$.getJSON("<?=base_url()?>equipmentstatus/get_project_list_dropdown_control",{},function(data){
			var projects = "<select id='projects'><option value='0'>All</option>";
			if(data != "error"){
				for(var x = 0; x < data.length; x++){
					projects += "<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
				}
			}
			projects +="</select>";
			$("#projectdiv").html(projects);
			$("#projects").chosen({ width: '100%' });
			$('#projects').on('change', function(e) {
				getEquipmentStatus();
		  	});
		  	getEquipmentList();
		});
	}
	function getEquipmentList(){
		$.getJSON("<?=base_url()?>equipmentstatus/get_equipment_list_dropdown_control",{},function(data){
			var equipments = "<select id='equipments'><option value='0'>All</option>";
			if(data != "error"){
				for(var x = 0; x < data.length; x++){
					equipments += "<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
				}
			}
			equipments +="</select>";
			$("#equipmentdiv").html(equipments);
			$("#equipments").chosen({ width: '100%' });
			$('#equipments').on('change', function(e) {
				getEquipmentStatus();
		  	});
		  	getEquipmentStatus();
		});
	}
</script>