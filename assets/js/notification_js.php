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
	            getNotifications();
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
	            getNotifications();
	        }
	    });
    	$("#datefrom").datepicker( "setDate", -365);
        $("#dateto").datepicker( "setDate", new Date());
    	getNotifications();
	});
	function getNotifications(){
		$.getJSON("<?=base_url()?>Notification/get_notifications_control",{
			datefrom: $('#datefrom').val(),
			dateto: $('#dateto').val(),
		}, function(data){
			$("#ntable > tbody").html("");
			if(data != "error"){
				createTableBodyFrom2DJSON(data,"ntable", false);
				$("#ntable").show();
			}else{
				$("#ntable").hide();
			}
		});
	}
</script>