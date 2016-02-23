<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:57 PM
 */

?>

<script type="text/javascript">
	$(function(){
		$('#reports').addClass("active");
    	$('#rproj6').addClass("active");
    	$("#division").chosen({ width: '100%' });
    	activateSorting("budgettable");
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
	            getProjectBudgets();
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
	            getProjectBudgets();
	        }
	        });
    	$("#datefrom").datepicker( "setDate", -365);
        $("#dateto").datepicker( "setDate", new Date());
        $('#division').on('change', function(evt, params) {
		    getProjectBudgets();
		});
    	getProjectNatures();
	});
	function getProjectBudgets(){
		$.getJSON("<?=base_url()?>budgetreport/get_project_list_for_budget_report_controller",{
			datefrom: $("#datefrom").val(),
			dateto: $("#dateto").val(),
			division: $("#division").val(),
			nature: $("#natures").val(),
		},function(data){
			$("#budgettable > tbody").html("");
 			if(data != 'error'){
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
	 			$("#budgettable > tbody").append(body);
	 			$("#budgettable").show();
	 			hidecolumn(0,'budgettable');
	 		}else
	 			$("#budgettable").hide();
		});
	}
	function getProjectNatures(){
		$.getJSON("<?=base_url()?>budgetreport/get_nature_list_for_dropdown_control",{},function(data){
			var natures="";
 			natures+='<select data-placeholder="Select Employee" style="width:510px;" id="natures" class="chosen-select a form-control" tabindex="8">';
 			natures+= "<option value='0'>All</option>";
 			for(var x=0;x<data.length;x++){
                natures+="<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
            }
            natures+='</select>';
            $('#naturesdiv').html(natures);
            $("#natures").chosen({ width: '100%' });
            $('#natures').on('change', function(evt, params) {
			    getProjectBudgets();
			});
			getProjectBudgets();
		});
	}
</script>>