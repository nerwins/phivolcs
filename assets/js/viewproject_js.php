<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/04/2016
 * Time: 7:45 PM
 */?>

 <script>
 	var projectStatus = 0;
 	var projectLatitude = "";
 	var projectLongitude = "";
 	var projectLocationName = "";
 	var projectDateFrom = "";
 	var projectDateTo = "";
 	var revisions = [];
 	var newobjectives = [];
    var oldobjectives = [];
    var oldworkplan = [];
    var newworkplan = [];
    var oldoutput = [];
    var newoutput = [];
    var markerz = [];
	 $(function() {
	 	getProjectDetails(getUrlParameter("id"));
	 	$('#section1').on('click', function () {
	 		$('#projheader').html("Edit Project Description");
	        $('#proj').html("Project Description");
	        $('#projcom').val($('#pdescription').html());
	        $('#projbutton').html("<button class='btn btn-success' id='pdesc'>Save</button>");
	        $('#pdesc').on('click', function () {
	            $('#pdescription').html($('#projcom').val());
	            $('#changeProject').modal('hide');
	        });
	        $('#changeProject').modal('show');
	 	});
	 	$('#section3').on('click', function () {
	        $('#projheader').html("Edit Project Background");
	        $('#proj').html("Project Background");
	        $('#projcom').val($('#pbackground').html());
	        $('#projbutton').html("<button class='btn btn-success' id='pback'>Save</button>");
	        $('#pback').on('click', function () {
	            $('#pbackground').html($('#projcom').val());
	            $('#changeProject').modal('hide');
	        });
	        $('#changeProject').modal('show');
	    });
	    $('#section4').on('click', function () {
	        $('#projheader').html("Edit Significance of Project");
	        $('#proj').html("Significance of Project");
	        $('#projcom').val($('#psignificance').html());
	        $('#projbutton').html("<button class='btn btn-success' id='psig'>Save</button>");
	        $('#psig').on('click', function () {
	            $('#psignificance').html($('#projcom').val());
	            $('#changeProject').modal('hide');
	        });
	        $('#changeProject').modal('show');
	    });
	    $('#section2').on('click', function () {
	        $('#objective').val("");
	        $('#btns').html("<button class='btn btn-success' id='osave' type='button'>Add</button>");
	        $('#addObjective').modal('show');
	        $('#osave').on('click', function () {
	            document.getElementById("pobjectives").innerHTML += "<li onclick='editObjectives(this)' style='word-break: break-all;' id='n" + (newobjectives.length + 1) + "'>" + $('#objective').val() + "</li>";
	            newobjectives.push({id: (newobjectives.length + 1), value: $('#objective').val()});
	            $('#addObjective').modal('hide');
	        });
	    });
	    $('#appProj').on('click', function () {
        	$.post("<?=base_url()?>viewproject/approve_project_control", {id:getUrlParameter("id")}, function (data) {
	            window.location.replace("projectarchive?status=1");
	        });
	    });
	    $('#revProj').on('click', function () {
	        $('#directorbuttons').css('display', 'none');
	        $('#dirrevbuttons').css('display', 'block');
	        for (var x = 0; x < 8; x++) {
	            $('#rev' + (x + 1)).removeAttr("style");
	            $('#rev' + (x + 1)).css('visibility', 'visible');
	            $('#rev' + (x + 1)).attr('class', 'btn btn-warning');
	        }
	    });
	    $('#decProj').on('click', function () {
	        $('#projreason').val("");
	        $('#closeProject').modal('show');
	    });
	    $('#subreason').on('click', function () {
	        if ($('#projreason').val().trim() === "") {
	        	swal("Unable to close the project", "A reason should be supplied!","info");
	            return;
	        }
	        $.post("<?=base_url()?>viewproject/decline_project_control", 
	        	{id:getUrlParameter("id"), reason: $('#projreason').val()}, function (data){
	            window.location.replace("projectarchive?status=3");
	        });
	    });
	    $('#section6').on('click', function () {
	        $('#btnoutputs').html("<button id='saveOutput' class='btn btn-success'>Add</button>");
	        $('#pindicator').val("");
	        $('#eoutput').val("");
	        $('#saveOutput').on('click', function (e) {
	            e.preventDefault();
	            var outputtable = document.getElementById("outputtable").getElementsByTagName("tbody")[0];
	            outputtable.innerHTML += "<tr onclick='editOutput(this)'><td style='display:none'>o" + (oldoutput.length + 1) + "</td><td style='word-break: break-all;text-align:center'>" + $('#eoutput').val() + "</td><td style='word-break: break-all;text-align:center'>" + $('#pindicator').val() + "</td></tr>"
	            newoutput.push({id: (oldoutput.length + 1), pindicator: $('#pindicator').val(), eoutput: $('#eoutput').val()});
	            $('#addOutput').modal('hide');
	        });
	        $('#addOutput').modal('show');
	    });
	    $('#appRev').on('click', function () {
	        $.post("<?=base_url()?>viewproject/approve_revisions_control", 
	        	{id:getUrlParameter("id"), revisions: JSON.stringify(revisions)}, function (data){
	            window.location.replace("projectarchive?status=2");
	        });
	    });
	    $('#cancRev').on('click', function () {
	        revisions = [];
	        $('#directorbuttons').css('display', 'block');
	        $('#dirrevbuttons').css('display', 'none');
	        for (var x = 0; x < 9; x++) {
	            $('#rev' + (x + 1)).css('visibility', 'hidden');
	        }
	    });
	    $('#cancDirRev').on('click', function () {
	        $('#projreason').val("");
	        $('#closeProject').modal('show');
	    });
	    $('#appDirRev').on('click', function () {
	    	var description = $('#pdescription').html();
	        var background = $('#pbackground').html();
	        var significance = $('#psignificance').html();
	        var oldworkplans = "";
	        var newworkplans = "";
	        var oldobjective = "";
	        var newobjective = "";
	        var oldoutputs = "";
	        var newoutputs = "";
	        var latitude = "";
	        var longitude = "";
	        var locationname = "";
	        if (oldworkplan.length !== 0)
	            oldworkplans = JSON.stringify(oldworkplan);
	        if (newworkplan.length !== 0)
	            newworkplans = JSON.stringify(newworkplan);
	        if (oldobjectives.length !== 0)
	            oldobjective = JSON.stringify(oldobjectives);
	        if (newobjectives.length !== 0)
	            newobjective = JSON.stringify(newobjectives);
	        if (oldoutput.length !== 0)
	            oldoutputs = JSON.stringify(oldoutput);
	        if (newoutput.length !== 0)
	            newoutputs = JSON.stringify(newoutput);
	        if (markerz.length !== 0) {
            latitude = markerz[0].getPosition().lat();
            longitude = markerz[0].getPosition().lng();
            locationname = markerz[0].title;
	        } else {
	            latitude = projectLatitude;
	            longitude = projectLongitude;
	            locationname = projectLocationName;
	        }
	        $.post("<?=base_url()?>viewproject/update_revisions_control", {
	        	id:getUrlParameter("id"),
	        	description: description, 
	        	background: background, 
	        	significance: significance, 
	        	oldworkplans: oldworkplans, 
	        	newworkplans: newworkplans, 
	        	oldobjective: oldobjective, 
	        	newobjective: newobjective, 
	        	oldoutputs: oldoutputs, 
	        	newoutputs: newoutputs, 
	        	latitude: latitude, 
	        	longitude: longitude, 
	        	locationname: locationname
	        }, function (data) {
	                window.location.replace("projectarchive?status=4");
	        });
	    });
	    $('#section5').on('click', function () {
	    	$('#milestone').val("");
	        $('#taskpriority').val(-1);
	        $('#workskills').val("");
	        $('#workskills').trigger('chosen:updated');
	        $('#taskfrom').val("");
	        $('#taskto').val("");
	        $('#aname').val("");
	        $('#inv').val("1");
	        $('#numemp').val("1");
	        $('#outputs').val("");
	        $('#addtaskalert').css('display', 'none');
	        $('#taskskillz .chosen-choices').removeAttr("style");
	        document.getElementById("taskpriority").style.borderColor = "";
	        document.getElementById("taskfrom").style.borderColor = "";
	        document.getElementById("taskto").style.borderColor = "";
	        document.getElementById("aname").style.borderColor = "";
	        $('#workplanbtns').html('<a class="btn btn-success pull-right" href="" id="saveWorkplan" >Add</a>');
	        reloaddatepickers();
	        $('#saveWorkplan').on('click', function (e) {
	        	e.preventDefault();
	        	('#taskskillz .chosen-choices').removeAttr("style");
	            $('#addtaskalert').css('display', 'none');
	            document.getElementById("taskpriority").style.borderColor = "";
	            document.getElementById("taskfrom").style.borderColor = "";
	            document.getElementById("taskto").style.borderColor = "";
	            document.getElementById("aname").style.borderColor = "";
	            var alerts = "";
	            if ($('#workskills').val() === null) {
	                alerts += "Skillsets  should be assigned to tasks!<br>";
	                $('#taskskillz .chosen-choices').attr("style", "border: 1px solid red");
	            }
	            if ($('#taskpriority').val() === null) {
	                alerts += "Tasks should have priority!<br>";
	                document.getElementById("taskpriority").style.borderColor = "red";
	            }
	            if ($('#taskfrom').val() === '' || $('#taskto').val() === '') {
	                alerts += "Tasks should have duration!<br>";
	                if ($('#taskfrom').val() === '') 
	                    document.getElementById("taskfrom").style.borderColor = "red";
	                if ($('#taskto').val() === '') 
	                    document.getElementById("taskto").style.borderColor = "red";
	            }
	            if ($('#aname').val() === '') {
	                alerts += "Task should have name!<br>";
	                document.getElementById("aname").style.borderColor = "red";
	            }
	            if (alerts !== '') {
	                $('#addtaskalert').html("<strong>The following conflicts were found:</strong><br>" + alerts);
	                $('#addtaskalert').css('display', 'block');
	                $("#workplan").animate({
	                    scrollTop: 0
	                }, 600);
	                return;
	            }
	            var priority = "";
	            if (parseInt($('#taskpriority').val()) === 1) 
	                priority = "<label class='label label-success'>Low</label>";
	            else if (parseInt($('#taskpriority').val()) === 2) 
	                priority = "<label class='label label-warning'>Medium</label>";
	            else if (parseInt($('#taskpriority').val()) === 3) 
	                priority = "<label class='label label-danger'>High</label>";
	            else if (parseInt($('#taskpriority').val()) === 4) 
	                priority = "<label class='label label-emergency'>Emergency</label>";
	            var tasktable = document.getElementById("tasktable").getElementsByTagName("tbody")[0];
	            tasktable.innerHTML += "<tr onclick='editWorkplan(this)'><td style='display:none'>w" + (newworkplan.length + 1) + "</td><td>" + $('#aname').val() + "</td><td style='word-break: break-all;text-align:center'>" + $('#milestone').val() + "</td><td style='word-break: break-all;text-align:center'>" + $('#taskfrom').val() + " to " + $('#taskto').val() + "</td><td style='word-break: break-all;text-align:center'>" + $('#numemp').val() + "</td><td style='word-break: break-all;text-align:center'>" + priority + "</td><td style='word-break: break-all;text-align:center'>" + $('#outputs').val() + "</td></tr>";

	            newworkplan.push({id: (newworkplan.length + 1), name: $('#aname').val(), milestone: $('#milestone').val(), priority: $('#taskpriority').val(), numemp: $('#numemp').val(), workskills: $('#workskills').val(), taskfrom: $('#taskfrom').val(), taskto: $('#taskto').val(), inv: $('#inv').val(), outputs: $('#outputs').val()});
	            $('#workplan').modal('hide');
	        });
	        $('#workplan').modal('show');
	    });
			$.getJSON("<?=base_url()?>viewproject/get_skillset_list_control", {}, function (data) {
	            var skillsets = "";
	            skillsets+='<select data-placeholder="Filter Tags" style="width:510px;" id="filters" multiple class="chosen-select a form-control" tabindex="8">';
	            for (var x = 0; x < data.length; x++) {
	                skillsets += "<option value='" + data[x][0] + "'>" + data[x][1] + "</option>";
	            }
	            skillsets+='</select>';
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
	            $('#workskills').html(skillsets);
	            $('#workskills').trigger('chosen:updated');
	        });
	        $("#uploadButton").click(function() {
			  $.FileDialog({
					accept: "*",
					cancelButton: "Close",
					dragMessage: "Drop files here",
					dropheight: 200,
					errorMessage: "An error occured while loading file",
					multiple: false,
					okButton: "OK",
					readAs: "DataURL",
					removeMessage: "Remove&nbsp;file",
					title: "Load file(s)"
				}).on('files.bs.filedialog', function(ev) {
				  var files_list = ev.files;
				  var files = [];
				  for(var x = 0; x < files_list.length; x++){
				  	var file = files_list[x];
				  	var fileobj = {
				  		name: file.name,
				  		size: file.size
				  	};
				  	files.push(fileobj);
				  }
				  $.post("<?=base_url()?>viewproject/save_file_control", 
			        	{projectid:getUrlParameter("id"),files: files
					  }, function (data){
			        	getFileList();
			        });

				  //content, name, lastmodified, lastmodifieddate, slice, size, type
				});
			});
		    for (var x = 0; x < 8; x++) {
		        $('#rev' + (x + 1)).css('display', 'none');
		        $('#section' + (x + 1)).css('display', 'none');
		    }
		    getFileList();
		    activateSorting('budgettable');
		    loadGantt();
		 });
	 function getProjectDetails(id){
	 	$.getJSON("<?=base_url()?>viewproject/get_project_details_control",
 			{projectid:id},function(data){
 				if(data != "error"){
 					$('#pname').html(data['name']);
		            $('#datefrom').html(data['datefromformat']);
		            $('#dateto').html(data['datetoformat']);
		            $('#pstatus').html(data['priority']);
		            $('#projstatus').html(data['status']);
		            $('#budget').html(data['budgettotal'].split(": ")[0] + " Php" + ReplaceNumberWithCommas(data['budgettotal'].split(": ")[1]));
		            $('#ptask').html(data['pendingtaskcount']);
		            $('#ctask').html(data['completedtaskcount']);
		            $('#ttask').html(data['totaltaskcount']);
		            $('#pdescription').html(data['description']);
		            $('#pbackground').html(data['background']);
		            $('#psignificance').html(data['significance']);
		            $('#pobjectives').html(data[12]);
		            $('#totalamount').html("Php " + ReplaceNumberWithCommas(data['budgettotal'].split(": ")[1]));
 					var headString = "";
 					if(data['statusnum'] == -1){
 						if(data['position'] == 2)
 							headString += "<label class='label label-default'>Pending</label>";
 						else
 							if(<?php echo $_SESSION['id'];?> == data['empid'])
 								headString += "<button id='aproj' title='Approve' class='btn btn-primary btn-sm'><i class='icon_check_alt'></i></button>"
                                              + "&nbsp;<button id='dproj' title='Decline' class='btn btn-danger btn-sm'><i class='icon_close_alt'></i></button>";
                        $('#tasktable thead tr').append( $('<th />', {text : 'Approval',style: 'text-align:center'}) );
                    }else if(data['statusnum'] == 1)
                    	if(<?php echo $_SESSION['position'];?> == 2)
                    		headString += "<label class='label label-success'>Approved</label>";
                    else if(data['statusnum'] == 2)
                    	if(<?php echo $_SESSION['position'];?> == 2){
                    		headString += "<label class='label label-danger'>Declined</label>";
                            headString += "<br><div style='margin-top:10px;'><button title='View Reason' onclick='viewReason(" + id + ",1)' class='btn btn-danger btn-sm'><i class='icon_documents_alt'></i></button>"
                                        + "&nbsp;<button onclick='cemployee2(" + id + "," + data['priority'] + "," + <?php echo $_SESSION['id'];?> + ")' title='Change Employee' class='btn btn-primary btn-sm'><i class='icon_search_alt'></i></button>"
                                        + "&nbsp;<button onclick='outsource(" + id + ",1)' title='Outsource' class='btn btn-warning btn-sm'><i class='icon_group'></i></button></div>";
                    	}
 					$("#projecthead").append(headString);
 					/*if(data['statusnum'] == 2)
 						$('#tasktable thead tr').append( $('<th />', {text : 'Output',style: 'text-align:center'}) );*/
 					if(data['statusnum'] == 4){
 						$("#revCommentDiv").append('<textarea class="form-control" rows="9" cols="73" id="revcomment2" style="min-width: 100%;"></textarea>');
 					}else{
 						$("#revCommentDiv").append("<div id='revcomment2'></div>");
 					}
 					if(data['statusnum'] >= 6){
 						var taskString = "<li class=''>"
                                +"<a  id='exp' data-toggle='tab' href='#pexpenses' >"
                                +    "<i class='icon-envelope'></i>"
                                +    "Project Expense"
                                +"</a>"
                           	+"</li>";
 						$("#projectexpense").append(taskString);
 					}
 					if(data['statusnum'] == 6){
 						$("#pexpenses").prepend('<button class="btn btn-primary btn-small" id="aexpense"><i class="icon_plus_alt"></i>&nbsp;Add</button>');
 					}
		            if (parseInt(data['emp_stat']) >= 0 && parseInt(data['statusnum']) <= 4) {
		                $('#gantttitle').html("Proposed Schedule");
		                $('#projmap').html("Proposed Site");
		            } else {
		                $('#gantttitle').html("Project Schedule");
		                $('#projmap').html("Project Hazard Map");
		            }
		            $('#projectHeadName').html(data['projectheadname']);
		         	if(<?php echo $_SESSION['position'];?> == 1 && data['statusnum'] == 4) 
		         		$('#directorbuttons').css('display', 'block');
		         	if(<?php echo $_SESSION['position'];?> == 2 && data['statusnum'] == 2)
		         		$('#dirrevemp').css('display', 'block');

		         	projectStatus = data['statusnum'];
		         	projectLatitude = data['latitude'];
		         	projectLongitude = data['longitude'];
		         	projectLocationName = data['locationname'];
		         	projectDateFrom = data['datefrom'];
 					projectDateTo = data['dateto'];

 					arrangeDisplayActionButtons(data['percentage'], data['statusnum']);
 					createTableBodyFrom2DJSON(data['tasks'],'tasktable');
 					createTableBodyFrom2DJSON(data['budgets'],'budgettable');
 					createTableBodyFrom2DJSON(data['outputs'],'outputtable');
 					getDirectorComments(data['directorcomments']);
 					hidecolumn(4,'tasktable');
 				}
 		});
	 }
	 function getDirectorComments(directorcomments){
	 	if(directorcomments.length != 0){
	 		for (var z = 0; z < directorcomments.length; z++) {
                $('#rev' + directorcomments[z][0]).removeAttr("style");
                $('#rev' + directorcomments[z][0]).css('visibility', 'visible');
    			if(<?php echo $_SESSION['position'];?> != 1){
                    $('#section' + directorcomments[z][0]).removeAttr("style");
                    $('#section' + directorcomments[z][0]).css('visibility', 'visible');
    			}
                $('#rev' + directorcomments[z][0]).attr("value", directorcomments[z][1]);
            }
            for (var x = 0; x < directorcomments.length; x++) {
                if (parseInt(directorcomments[x][0]) === 5) {
                    var workplantable = document.getElementById("tasktable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
                    for (var z = 0; z < workplantable.length; z++) {
                        workplantable[z].setAttribute("onclick", "editWorkplan(this)");
                    }
                }
                if (parseInt(directorcomments[x][0]) === 6) {
                    var outputtable = document.getElementById("outputtable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
                    for (var z = 0; z < outputtable.length; z++) {
                        outputtable[z].setAttribute("onclick", "editOutput(this)");
                    }
                }
                if (parseInt(directorcomments[x][0]) === 2) {
                    var objectives = document.getElementById("pobjectives").getElementsByTagName("li");
                    for (var z = 0; z < objectives.length; z++) {
                        objectives[z].setAttribute("onclick", "editObjectives(this)");
                    }
                }
            }
	 	}
	 }
	 function arrangeDisplayActionButtons(percentage, status, empid){
	 	var longestButton = $("#redirectButton1").width();
	 	$("#redirectButton2").width(longestButton);
	 	$("#redirectButton3").width(longestButton);
	 	$("#redirectButton4").width(longestButton);
	 	$("#redirectButton5").width(longestButton);
	 	if(status == 7)
	 		$("#redirectButton1").show();
	 	if(status >= 6){
	 		$("#redirectButton3").show();
	 		$("#redirectButton2").show();
	 	}
	 	if(status == 5 && empid == <?php echo $_SESSION['id']; ?>){
	 		$("#redirectButton4").show();
	 	}
	 	if(percentage >= 80 && status != 7){
	 		$("#redirectButton1").show();
	 		$("#redirectButton5").show();
	 	}
	 }
	 function showRedirect(redirectTo){
	 	var pages = ['viewreport','progress','task','assignproject','createreport'];
	 	window.location.replace(pages[redirectTo] +'?id=' + getUrlParameter("id"));
	 }
	 function addComment(item, id) {
        $('#revcomment2').val("");
        var status = 0;
        var index = 0;
    	if(projectStatus == 4){
        for (var x = 0; x < revisions.length; x++) {
            if (parseInt(revisions[x].id) === parseInt(id)) {
                status = 1;
                index = x;
            }
        }
        if (parseInt(status) === 1) {
            $('#revcomment2').val(revisions[index].comment);
        }
        $('#commentbutton').html("<button class='btn btn-primary' id='subreason2'>Save Comment</button>");
        $('#subreason2').on('click', function () {
            var status = 0;
            var index = 0;
            for (var x = 0; x < revisions.length; x++) {
                if (parseInt(revisions[x].id) === parseInt(id)) {
                    status = 1;
                    index = x;
                }
            }
            if (parseInt(status) === 1) {
                revisions[index].comment = $('#revcomment2').val();
            } else {
                revisions.push({id: id, comment: $('#revcomment2').val()});
            }
            $('#revComment').modal('hide');
            item.className = "btn btn-success";
            item.title = "Revised";
        });
	    }else
	        $('#revcomment2').html(item.value);

	        $('#revComment').modal('show');
    }
    function reloaddatepickers() {
        $('#taskfrom').datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            dateFormat: 'yy-mm-dd',
            onClose: function (selectedDate) {
                $("#taskto").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#taskfrom").datepicker("option", "minDate", projectDateFrom);
        $('#taskto').datepicker({
            beforeShowDay: $.datepicker.noWeekends,
            dateFormat: 'yy-mm-dd',
            onClose: function (selectedDate) {
                $("#taskfrom").datepicker("option", "maxDate", selectedDate);
            }
        });
        $('#taskto').datepicker("option", "minDate", projectDateFrom);
        $('#taskto').datepicker("option", "maxDate", projectDateTo);
    }
    function editOutput(item) {
        $('#btnoutputs').html("<button id='editOutput' class='btn btn-success'>Edit</button>&nbsp;&nbsp;<button id='deleteOutput' class='btn btn-danger'>Delete</button>");
        $('#eoutput').val(item.getElementsByTagName("td")[1].innerHTML);
        $('#pindicator').val(item.getElementsByTagName("td")[2].innerHTML);

        $('#editOutput').on('click', function (e) {
            e.preventDefault();
            item.getElementsByTagName("td")[1].innerHTML = $('#eoutput').val();
            item.getElementsByTagName("td")[2].innerHTML = $('#pindicator').val();
            var id = item.getElementsByTagName("td")[0].innerHTML;
            if (isNaN(id)) {
                var status = 0;
                var index = 0;
                for (var z = 0; z < newoutput.length; z++) {
                    if ("o" + newoutput[z].id === id) {
                        status = 1;
                        index = z;
                    }
                }
                if (parseInt(status) === 1) {
                    newoutput[index].eoutput = $('#eoutput').val();
                    newoutput[index].pindicator = $('#pindicator').val();
                }
            } else {
                var status = 0;
                var index = 0;
                for (var z = 0; z < oldoutput.length; z++) {
                    if (parseInt(oldoutput[z].id) === id) {
                        status = 1;
                        index = z;
                    }
                }
                if (parseInt(status) === 1) {
                    oldoutput[index].eoutput = $('#eoutput').val();
                    oldoutput[index].pindicator = $('#pindicator').val();
                }else
                    oldoutput.push(
                    	{id: id, pindicator: $('#pindicator').val(), eoutput: $('#eoutput').val(), type: 1});
            }
            $('#addOutput').modal('hide');
        });
        $('#deleteOutput').on('click', function (e) {
            e.preventDefault();
            document.getElementById("outputtable").deleteRow(item.rowIndex);
            var id = item.getElementsByTagName("td")[0].innerHTML;
            if (isNaN(id)) {
                var size = newoutput.length;
                while (size--) {
                    if (newoutput[size].id === id)
                        newoutput.splice(size, 1);
                }
                var ids = [];
                var outputtable = document.getElementById("outputtable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
                for (var z = 0; z < outputtable.length; z++) {
                    if (isNaN(outputtable[z].getElementsByTagName("td")[0].innerHTML))
                        ids.push(z);
                }
                for (var x = 0; x < ids.length; x++) {
                    outputtable[ids[x]].getElementsByTagName("td")[0].innerHTML = "o" + (x + 1);
                }
                for (var xx = 0; xx < newoutput.length; xx++) {
                    newoutput[xx].id = parseInt(xx) + 1;
                }

            } else {
                var status = 0;
                var index = 0;
                for (var z = 0; z < oldoutput.length; z++) {
                    if (parseInt(oldoutput[z].id) === parseInt(id)) {
                        status = 1;
                        index = z;
                    }
                }
                if (parseInt(status) === 1)
                    oldoutput[index].type = 2;
                else
                    oldoutput.push(
                    	{id: id, pindicator: $('#pindicator').val(), eoutput: $('#eoutput').val(), type: 2});
            }
            $('#addOutput').modal('hide');
        });
        $('#addOutput').modal('show');
    }
    function editWorkplan(item) {
        $('#workplanbtns').html('<a class="btn btn-success" href="" id="editWorkplan" >Edit</a>&nbsp;&nbsp;<a class="btn btn-danger" href="" id="deleteWorkplan" >Delete</a>');
        reloaddatepickers();
        var id = item.getElementsByTagName("td")[0].innerHTML;
        var aname = item.getElementsByTagName("td")[1].innerHTML;
        var milestone = item.getElementsByTagName("td")[2].innerHTML;
        var taskfrom = item.getElementsByTagName("td")[3].innerHTML.split(" to ")[0];
        var taskto = item.getElementsByTagName("td")[3].innerHTML.split(" to ")[1];
        var numemp = item.getElementsByTagName("td")[4].innerHTML;
        var outputs = item.getElementsByTagName("td")[6].innerHTML;

        var div = document.createElement("div");
        div.innerHTML = item.getElementsByTagName("td")[5].innerHTML;
        var priority = div.textContent || div.innerText || "";

        var priorityval = 0;
        if (priority.toLowerCase() === "low") {
            priorityval = 1;
        } else if (priority.toLowerCase() === "medium") {
            priorityval = 2;
        } else if (priority.toLowerCase() === "high") {
            priorityval = 3;
        } else if (priority.toLowerCase() === "emergency") {
            priorityval = 4;
        }
        $('#aname').val(aname);
        $('#milestone').val(milestone);
        $('#taskfrom').val(taskfrom);
        $('#taskto').val(taskto);
        $('#numemp').val(numemp);
        $('#taskpriority').val(priorityval);
        $("#outputs").val(outputs);
        $('#addtaskalert').css('display', 'none');
        $('#taskskillz .chosen-choices').removeAttr("style");
        document.getElementById("taskpriority").style.borderColor = "";
        document.getElementById("taskfrom").style.borderColor = "";
        document.getElementById("taskto").style.borderColor = "";
        document.getElementById("aname").style.borderColor = "";
        var status = 0;
        var index = 0;
        for (var x = 0; x < oldworkplan.length; x++) {
            if (parseInt(oldworkplan[x].id) === parseInt(item.id)) {
                status = 1;
                index = x;
            }
        }
        if (!isNaN(id)) {
            if (status === 1) {
                $('#workskills').val(oldworkplan[index].workskills);
                $('#inv').val(oldworkplan[index].inv);
            } else {
                $.getJSON("<?=base_url()?>viewproject/get_skillset_from_task_control", {
                	taskid: id, id:getUrlParameter("id")}, function (data) {
                    $('#workskills').val(data[0]);
                    $('#workskills').trigger('chosen:updated');
                    $('#inv').val(data[1]);
                });
            }
        } else {
            for (var x = 0; x < newworkplan.length; x++) {
                if ("w" + parseInt(newworkplan[x].id) === id) {
                    $('#workskills').val(newworkplan[x].workskills);
                    $('#workskills').trigger('chosen:updated');
                    $('#inv').val(newworkplan[x].inv);
                }
            }
        }
        $('#editWorkplan').on('click', function (e) {
            e.preventDefault();
            $('#taskskillz .chosen-choices').removeAttr("style");
            $('#addtaskalert').css('display', 'none');
            document.getElementById("taskpriority").style.borderColor = "";
            document.getElementById("taskfrom").style.borderColor = "";
            document.getElementById("taskto").style.borderColor = "";
            document.getElementById("aname").style.borderColor = "";
            var alerts = "";

            if ($('#workskills').val() === null) {
                alerts += "Skillsets  should be assigned to tasks!<br>";
                $('#taskskillz .chosen-choices').attr("style", "border: 1px solid red");
            }


            if ($('#taskpriority').val() === null) {
                alerts += "Tasks should have priority!<br>";
                document.getElementById("taskpriority").style.borderColor = "red";

            }
            if ($('#taskfrom').val() === '' || $('#taskto').val() === '') {
                alerts += "Tasks should have duration!<br>";
                if ($('#taskfrom').val() === '') {
                    document.getElementById("taskfrom").style.borderColor = "red";
                }
                if ($('#taskto').val() === '') {
                    document.getElementById("taskto").style.borderColor = "red";
                }
            }
            if ($('#aname').val() === '') {
                alerts += "Task should have name!<br>";
                document.getElementById("aname").style.borderColor = "red";
            }

            if (alerts !== '') {
                $('#addtaskalert').html("<strong>The following conflicts were found:</strong><br>" + alerts);
                $('#addtaskalert').css('display', 'block');
                $("#workplan").animate({
                    scrollTop: 0
                }, 600);
                return;
            }
            item.getElementsByTagName("td")[1].innerHTML = $('#aname').val();
            item.getElementsByTagName("td")[2].innerHTML = $('#milestone').val();
            item.getElementsByTagName("td")[3].innerHTML = $('#taskfrom').val() + " to " + $("#taskto").val();
            item.getElementsByTagName("td")[4].innerHTML = $('#numemp').val();
            var priority = "";
            if (parseInt($('#taskpriority').val()) === 1) {
                priority = "<label class='label label-success'>Low</label>";
            } else if (parseInt($('#taskpriority').val()) === 2) {
                priority = "<label class='label label-warning'>Medium</label>"
            } else if (parseInt($('#taskpriority').val()) === 3) {
                priority = "<label class='label label-danger'>High</label>"
            } else if (parseInt($('#taskpriority').val()) === 4) {
                priority = "<label class='label label-emergency'>Emergency</label>"
            }
            item.getElementsByTagName("td")[5].innerHTML = priority;
            item.getElementsByTagName("td")[6].innerHTML = $('#outputs').val();
            if (isNaN(item.getElementsByTagName("td")[0].innerHTML)) {
                for (var z = 0; z < newworkplan.length; z++) {
                    if (item.getElementsByTagName("td")[0].innerHTML === "w" + newworkplan[z].id) {
                        newworkplan[z].name = $('#aname').val();
                        newworkplan[z].milestone = $('#milestone').val();
                        newworkplan[z].priority = $('#taskpriority').val();
                        newworkplan[z].workskills = $('#workskills').val();
                        newworkplan[z].taskfrom = $('#taskfrom').val();
                        newworkplan[z].taskto = $('#taskto').val();
                        newworkplan[z].inv = $('#inv').val();
                        newworkplan[z].numemp = $('#numemp').val();
                        newworkplan[z].outputs = $('#outpus').val();
                    }
                }
            } else {
                var status = 0;
                var index = 0;
                for (var x = 0; x < oldworkplan.length; x++) {
                    if (parseInt(oldworkplan[x].id) === parseInt(item.id)) {
                        status = 1;
                        index = x;
                    }
                }
                if (parseInt(status) === 1) {
                    oldworkplan[index].name = $('#aname').val();
                    oldworkplan[index].milestone = $('#milestone').val();
                    oldworkplan[index].priority = $('#taskpriority').val();
                    oldworkplan[index].workskills = $('#workskills').val();
                    oldworkplan[index].taskfrom = $('#taskfrom').val();
                    oldworkplan[index].taskto = $('#taskto').val();
                    oldworkplan[index].inv = $('#inv').val();
                    oldworkplan[index].numemp = $('#numemp').val();
                    oldworkplan[index].outputs = $('#outputs').val();
                } else {
                    oldworkplan.push({id: item.getElementsByTagName("td")[0].innerHTML, name: $('#aname').val(), milestone: $('#milestone').val(), priority: $('#taskpriority').val(), workskills: $('#workskills').val(), taskfrom: $('#taskfrom').val(), taskto: $('#taskto').val(), inv: $('#inv').val(), type: 1, numemp: $('#numemp').val(), outputs: $('#outputs').val()});
                }
            }
            $('#workplan').modal('hide');
        });
        $('#deleteWorkplan').on('click', function (e) {
            e.preventDefault();
            document.getElementById("tasktable").deleteRow(item.rowIndex);
            if (isNaN(item.getElementsByTagName("td")[0].innerHTML)) {
                var size = newworkplan.length;
                while (size--) {
                    if ("w" + newworkplan[size].id === item.getElementsByTagName("td")[0].innerHTML) {
                        newworkplan.splice(size, 1);
                    }
                }
                var tr = document.getElementById("tasktable").getElementsByTagName("tbody")[0].getElementsByTagName("tr");
                var indexes = [];
                for (var z = 0; z < tr.length; z++) {
                    if (isNaN(tr[z].getElementsByTagName("td")[0].innerHTML)) {
                        indexes.push(z);
                    }
                }
                for (var x = 0; x < indexes.length; x++) {
                    tr[indexes[x]].getElementsByTagName("td")[0].innerHTML = "w" + (parseInt(x) + 1);
                }
                for (var z = 0; z < newworkplan.length; z++) {
                    newworkplan[z].id = parseInt(z) + 1;
                }
            } else {
                var status = 0;
                var index = 0;
                for (var z = 0; z < oldworkplan.length; z++) {
                    if (parseInt(oldworkplan[z].id) === parseInt(item.getElementsByTagName("td")[0].innerHTML)) {
                        status = 1;
                    }
                }
                if (parseInt(status) === 1) {
                    oldworkplan[index].type = 2;
                } else {
                    oldworkplan.push({id: item.getElementsByTagName("td")[0].innerHTML, name: $('#aname').val(), milestone: $('#milestone').val(), priority: $('#taskpriority').val(), workskills: $('#workskills').val(), taskfrom: $('#taskfrom').val(), taskto: $('#taskto').val(), inv: $('#inv').val(), type: 2, outputs: $('#outputs').val()});
                }
            }
            $('#workplan').modal('hide')
	        });
	        $('#workplan').modal('show');
    	}
    	function getFileList(){
    		$.getJSON("<?=base_url()?>viewproject/get_file_list_control", {
    			projectid: getUrlParameter("id")
    		}, function (data) {
    			$("#filestable > tbody").html("");
    			if (data != "error"){
	            	var table = document.getElementById("filestable").getElementsByTagName("tbody")[0];
	            	for (var z = 0; z < data.length; z++) {
	                    var tr = document.createElement("tr");
	                    for (var y = 0; y < data[z].length; y++) {
	                        var td = document.createElement("td");
	                        td.innerHTML = "<center>" +data[z][y] +"</center>";
	                        tr.appendChild(td);
	                    }
	                    var td = document.createElement("td");
	                    td.innerHTML = "<center><button class='btn btn-success' onclick='actionsForFile(this,1)'>&darr;</button><button class='btn btn-danger' onclick='actionsForFile(this,0)'>X</button><center>";
	                    tr.appendChild(td);
	                    table.appendChild(tr);
	                }
	                hidecolumn(0,'filestable');
	            }
    		});
    	}

    	function actionsForFile(x,actiontype){
    		var row_index = $(x).parent().index() + 1;
    		var name=$('#filestable tr:eq("'+row_index+'") td:eq(1)').html();
    		var div = document.createElement("div");
    		div.innerHTML = name;
    		var filename = div.textContent || div.innerText || "";
    		if(actiontype == 0)
	    		$.post("<?=base_url()?>viewproject/delete_file_control", {
	    			projectid: getUrlParameter("id"),
	    			filename: filename
	    		}, function (data) {
	    			getFileList();
	    		});
	    	else
	    		$.post("<?=base_url()?>viewproject/download_file_control", {
	    			projectid: getUrlParameter("id"),
	    			filename: filename
	    		}, function (data) {
	    			swal(filename, "File successfully downloaded to: C:/Downloads/","success");
	    		});
    	}
    	function print(){
			$('#divprint').printThis({
	      		pageTitle: "Project Details",
	      		header: "",
	      		loadCSS: "<?=base_url()?>assets/css/print.css",            
			});
		}
		function loadGantt() {
        $.getJSON("<?=base_url()?>viewproject/get_project_details_ganttchart_control", {id:getUrlParameter("id")}, function (data) {
            //if (data != null) {
	            $("#ganttChart").ganttView({
	                data: data,
	                slideWidth: 900,
	                behavior: {
	                    draggable: false,
	                    resizable: false,
	                    onClick: function (data) {
	                        //var msg = "You clicked on an event: { start: " + data.start.toString("M/d/yyyy") + ", end: " + data.end.toString("M/d/yyyy") + " }";
	                        //  $("#eventMessage").text(msg);
	                        //$('#taskname').html("Details of "+data.tname);
	                        //$('#scheduletitle').html(data.name);
	                        //$('#taskModal').modal('show');
	                    }
	                }
	            });
        	//}
        });
    }
 </script>