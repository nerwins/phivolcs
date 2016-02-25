<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/19/2016
 * Time: 7:57 PM
 */
?>
<script>
	$(function() {
		$('#reports').addClass("active");
    	$('#rproj3').addClass("active");
    	load_employee_list();
    	get_project_load("All");
	});
	function load_employee_list(){
		$('#employeesdiv').html("");
		$.getJSON("<?=base_url()?>ProjectLoad/get_employees_list_control",{},function(data){
			var employees = '<select data-placeholder="Choose Employee" id="employees" multiple class="chosen-select a form-control" tabindex="8">';
			for(var x=0;x<data.length;x++){
				for(var x=0;x<data.length;x++){
	                employees+="<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
	            }
			}
			employees += "</select>";
			$('#employeesdiv').html(employees);
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
            $("#employees").chosen({ width: '100%' });
            $('#employees').on('change', function(e) {
            	var selected = $(this).val() === null?0:$(this).val();
            	var employeeIDs = [];
            	for(var x = 0; x < selected.length; x++){
            		employeeIDs.push(selected[x]);
            	}
            	if(parseInt(selected.length) > 0){
            		$("#reset").show();
            		get_project_load(employeeIDs);
            	}else{
            	    $("#reset").hide();
            	    get_project_load("All");
            	}
			});
			$("#reset").click(function(){
				$('#employees').val('').trigger('chosen:updated');
				$('#employees').change();
	    	});
		});
	}
	function get_project_load(employeeIDs){
		$.getJSON("<?=base_url()?>ProjectLoad/get_employee_project_load_control",
			{employeeIDs:employeeIDs},function(data){
				$('#ploadtable > tbody').html("");
				 var tbody = $('#ploadtable > tbody');
				 var string = "";
				 for(var x = 0; x < data.length; x++){
				 	string += "<tr>";
				 	if(data[x][1] != 'N/A'){
				 		var innertable = "";
					 	for(var y = 0; y < data[x][1].table.length; y++){
					 		innertable += data[x][1].table[y];
					 	}
					 	string += "<td>" + data[x][0] +"</td>";
					 	string += "<td>" + innertable +"<br><font color='red'><b>Total Projects: "+data[x][1].count+"</b></font></td>";
				 	}else{
				 		for(var y = 0; y < data[x].length; y++){
					 		string += "<td>" + data[x][y] +"</td>";
					 	}
				 	}
				 	string += "</tr>";
				 }
				 tbody.append(string);
				 $("#ploadtable").show();
		});
	}
	function print(){
		$('#ploadtable').printThis({
      		pageTitle: "Project Load Comparison",
      		header: "Project Load Comparison"            
		});
	}
</script>