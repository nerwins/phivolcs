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
	            getEquipmentStatus();
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
	            getEquipmentStatus();
	        }
	    });
	    $("#datefrom").datepicker( "setDate", -365);
        $("#dateto").datepicker( "setDate", new Date());
        activateSorting('etable');
        getEquipmentStatus();
	});
	function getEquipmentStatus(){
		$.getJSON("<?=base_url()?>equipmentstatus/get_equipment_status_control",{
			datefrom: $("#datefrom").val(),
			dateto: $("#dateto").val()
		},function(data){
			$('#etable > tbody').html("");
			$('#rtitle').html("Equipment Statuses from " + $('#datefrom').val() + " to " + $('#dateto').val());
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
</script>