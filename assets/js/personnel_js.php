<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:57 PM
 */?>

 <script>
 	$(function(){
 		$('#reports').addClass("active");
	    $('#rproj4').addClass("active");
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
	            getEmployeeList();
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
	            getEmployeeList();
	        }
	        });
        $( "#datefrom" ).datepicker( "setDate", -365);
        $( "#dateto" ).datepicker( "setDate", new Date());
 		getEmployeeList();
 	});
 	function getEmployeeList(){
 		$.getJSON("<?=base_url()?>personnel/get_employees_list_control",{},function(data){
 			var employees="";
 			employees+='<select data-placeholder="Select Employee" style="width:510px;" id="employeeddl" class="chosen-select a form-control" tabindex="8">';
 			employees+= "<option value='0'>All</option>";
 			for(var x=0;x<data.length;x++){
                employees+="<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
            }
            employees+='</select>';
            $('#employeesdiv').html(employees);
 			$("#employeeddl").chosen({ width: '49%' });
 			$('#employeeddl').on('change', function(e) {
				getPersonnelInvolvement($(this).val());    
		  	});
 			getPersonnelInvolvement(0);
 		});
 	}
 	function getPersonnelInvolvement(employeeID){
 		$.getJSON("<?=base_url()?>personnel/get_projects_and_employees_control",{
 			employeeID: employeeID,
 			datefrom: $('#datefrom').val(),
 			dateto: $('#dateto').val()
 		},function(data){
 			$("#personneltable > tbody").html("");
 			if(data.length > 0){
	 			var body = "";
	 			for(var x = 0 ; x < data.length; x++){
	 				body += "<tr>";
	 				for(var y = 0; y < data[x].length; y++){
	 					body += "<td>";
	 					body += data[x][y];
	 					body += "</td>";
	 				}
	 				body += "</tr>";
	 				body = body.replace("<td><td>","<td>");
	 			}
	 			$("#personneltable > tbody").append(body);
	 			$("#personneltable").show();
	 		}else
	 			$("#personneltable").hide();
	 		activateSorting("personneltable");
 		});
 	}
 </script>