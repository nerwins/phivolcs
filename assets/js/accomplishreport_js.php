<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/25/2016
 * Time: 7:34 PM
 */
?>

<script>
	$(function(){
		$('#reports').addClass("active");
    	$('#rproj7').addClass("active");
    	$("#divisions").chosen({ width: '100%' });
    	activateSorting("accomplishtable");
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
	            getAccomplishmentsAndProject();
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
	            getAccomplishmentsAndProject();
	        }
	    });
    	$("#datefrom").datepicker( "setDate", -365);
        $("#dateto").datepicker( "setDate", new Date());
        $('#divisions').on('change', function(evt, params) {
		    getAccomplishmentsAndProject();
		});
    	getProjectsAndHeads();
	});
	function getAccomplishmentsAndProject(){
		$.getJSON("<?=base_url()?>AccomplishReport/get_accomplished_reports_projects_control",{
			name: $('#names').val(),
			nature: $('#natures').val(),
			head: $('#heads').val(),
			division: $('#divisions').val(),
			datefrom: $('#datefrom').val(),
			dateto: $('#dateto').val(),
		}, function(data){
			$("#accomplishtable > tbody").html("");
			if(data != "error"){
				createTableBodyFrom2DJSON(data,"accomplishtable", false);
				$("#accomplishtable").show();
			}else{
				$("#accomplishtable").hide();
			}
		});
	}
	function getProjectNatures(){
		$.getJSON("<?=base_url()?>AccomplishReport/get_nature_list_for_dropdown_control",{},function(data){
			var natures="";
 			natures+='<select data-placeholder="Select Natures" style="width:510px;" id="natures" class="chosen-select a form-control" tabindex="8">';
 			natures+= "<option value='0'>All</option>";
 			for(var x=0;x<data.length;x++){
                natures+="<option value='"+data[x][0]+"'>"+data[x][1]+"</option>";
            }
            natures+='</select>';
            $('#projectnaturediv').html(natures);
            $("#natures").chosen({ width: '100%' });
            $('#natures').on('change', function(evt, params) {
			    getAccomplishmentsAndProject();
			});
			getAccomplishmentsAndProject();
		});
	}
	function getProjectsAndHeads(){
		$.getJSON("<?=base_url()?>AccomplishReport/get_project_name_and_heads_for_dropdown_control",{},function(data){
			var projects = '<select data-placeholder="Select projects" id="names" class="chosen-select a form-control" tabindex="8">';
			var heads = '<select data-placeholder="Select heads" id="heads" class="chosen-select a form-control" tabindex="8">';
			projects+= "<option value='0'>All</option>";
			heads+= "<option value='0'>All</option>";
			var headsarr = [];
			for(var x=0;x<data.length;x++){
                projects+="<option value='"+data[x].projects[0]+"'>"+data[x].projects[1]+"</option>";
                if(jQuery.inArray(data[x].heads[0], headsarr) === -1){
                	heads+="<option value='"+data[x].heads[0]+"'>"+data[x].heads[1]+"</option>";
                	headsarr.push(data[x].heads[0]);
                }
            }
            projects+="</select>";
            heads+="</select>";
            $('#projectnamediv').html(projects);
            $('#projectheaddiv').html(heads);
            $("#names").chosen({ width: '100%' });
            $("#heads").chosen({ width: '100%' });
            $("#names, #heads").on('change',function(evt,params){
            	getAccomplishmentsAndProject();
            });
            getProjectNatures();
		});
	}
	function print(){
		$('#divprint').printThis({
      		pageTitle: "Accomplishment Report",
      		header: "Accomplishment Report"            
		});
	}
</script>