<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 1/15/2016
 * Time: 7:23 PM
 */?>
<script>
	$(function(){
		initDateTime();
        initDepartmentName();
        initCalendar();
        getProjects();
        initProjectStatusCount();
        initTaskStatusCount();
        initTaskMemberStatusCount();
        // initEmpTasks();
        // initProjectsInDue();
        // initTasksInProgress();
        // initInventory();
    });
    function initDateTime() {
    	setInterval(function() {
		    var currentTime = new Date ( );    
		    var currentHours = currentTime.getHours ( );   
		    var currentMinutes = currentTime.getMinutes ( );   
		    var currentSeconds = currentTime.getSeconds ( );
		    currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
		    currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
		    var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";    
		    currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;    
		    currentHours = ( currentHours == 0 ) ? 12 : currentHours;    
		    var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
		    document.getElementById("ct").innerHTML = currentTimeString;
		}, 1000);

		var date = new Date();
		var n = date.toDateString();
		var time = date.toLocaleTimeString();
		document.getElementById('dt').innerHTML = n;
    }
    function initDepartmentName(){
    	// var divisionID = $_SESSION['division'];
    	switch(<?=$_SESSION['division'];?>){
    		case 1: document.getElementById("division").innerHTML = "Volcanology Division";
    		break;
    		case 2: document.getElementById("division").innerHTML = "Seismology Division";
			break;
			case 3: document.getElementById("division").innerHTML = "Finance and Administration Division";
    		break;
    		case 4: document.getElementById("division").innerHTML = "Research and Development Division";
    		break;
    		case 5: document.getElementById("division").innerHTML = "Disaster Preparedness Division";
    		break;
    	}
    }
    function initCalendar(){
    	var date = new Date();
	    var d = date.getDate();
	    var m = date.getMonth();
	    var y = date.getFullYear();

		daySource = new Object();       
		daySource.title = 'MONTH'; // this should be string
		daySource.start = new Date(y, m, d); // this should be date object
		daySource.end = new Date(y, m, d);

		var day =new Array();
		day[0]= daySource;

		monthSource = new Object();       
		monthSource.title = 'MONTH'; // this should be string
		monthSource.start = new Date(y, m, d); // this should be date object
		monthSource.end = new Date(y, m, d);

		var month =new Array();
		month[0]= monthSource;

		$('#calendar').fullCalendar({
		            header: {
		                left: 'prev,next',
		                center: 'title',
		                // right: 'month,agendaWeek,agendaDay'
		                right: 'today'
		            },
		            columnFormat: {
		                month: 'ddd',
		                week: 'ddd d/M',
		                day: 'dddd d/M'
		            },          
		            defaultView: 'month',     

		        viewDisplay: function(view) {
		            if (lastView == undefined) { lastView = 'firstRun';  }

		            if (view.name != lastView ) {

		            if (view.name == 'agendaWeek') { 
		                $('#calendar').fullCalendar( 'addEventSource', month ); 
		                $('#calendar').fullCalendar( 'removeEventSource', day ); 
		                $('#calendar').fullCalendar( 'removeEventSource', day ); 
		                $('#calendar').fullCalendar('renderEvents');
		            }
		            if (view.name == 'agendaDay') { 
		                $('#calendar').fullCalendar( 'addEventSource', day ); 
		                $('#calendar').fullCalendar( 'removeEventSource', month ); 
		                $('#calendar').fullCalendar( 'removeEventSource', month ); 
		                $('#calendar').fullCalendar('renderEvents');
		            }

		            if (view.name == 'month') { 
		                $('#calendar').fullCalendar( 'addEventSource', month ); 
		                $('#calendar').fullCalendar( 'removeEventSource', day ); 
		                $('#calendar').fullCalendar( 'removeEventSource', day );
		                $('#calendar').fullCalendar('renderEvents'); 
		            }
		            lastView = view.name;
		            }
		        },

		        timeFormat: { // for event elements
		            agendaDay: '',
		            agendaWeek: '',
		            month: '',
		            '': 'h(:mm)t' // default
		        },          

		    });
    }
    function getProjects(){
    	
    }
    function initProjectStatusCount(){
		$.getJSON("<?=base_url()?>dashboard/get_projects_status_control",  function(data) {
			if(data == "error") {

			}
            if (data.count_project_inProgress != 0 && data.count_project_completed != 0 && data.count_project_total != 0) { 
            	document.getElementById("p1").innerHTML= data.count_project_inProgress;
            	document.getElementById("p2").innerHTML= data.count_project_completed;
            	document.getElementById("p3").innerHTML= data.count_project_total;
            } else {
            	document.getElementById("projectsCountList").style.display = "none";
            	document.getElementById("projectsCountTable").innerHTML = "<p> Your have no projects. </p>";
            }
        });
    }
    function initTaskStatusCount(){
    	$.getJSON("<?=base_url()?>dashboard/get_tasks_status_control",  function(data) {
    		if(data == "error") {

			}
            if (data.count_task_inProgress != 0 && data.count_task_completed != 0 && data.count_task_total != 0) { 
            	document.getElementById("t1").innerHTML= data.count_task_inProgress;
            	document.getElementById("t2").innerHTML= data.count_task_completed;
            	document.getElementById("t3").innerHTML= data.count_task_total;
            } else {
            	document.getElementById("tasksCountList").style.display = "none";
            	document.getElementById("tasksCountTable").innerHTML = "<p> Your have no tasks. </p>";
            }
    	});
    }
    function initTaskMemberStatusCount(){
 		var position = <?=$_SESSION['position'];?>;
    	if(position != 2) {
    		document.getElementById("membertasksCountList").style.display = "none";
    		document.getElementById("membertasksTitle").style.display = "none";
    	}

    	$.getJSON("<?=base_url()?>dashboard/get_member_tasks_status_control",  function(data) {
    		if(data == "error") {

			}
            if (data.count_task_inProgress.length !== 0 && data.count_task_completed.length !== 0 && data.count_task_total.length !== 0) { 
            	document.getElementById("c1").innerHTML= data.count_task_inProgress;
            	document.getElementById("c2").innerHTML= data.count_task_completed;
            	document.getElementById("c3").innerHTML= data.count_task_total;
            } else {
            	document.getElementById("membertasksCountList").style.display = "none";
            	document.getElementById("membertasksCountTable").innerHTML = "<p> Your have no tasks. </p>";
            }
    	});
    }
	


</script>
