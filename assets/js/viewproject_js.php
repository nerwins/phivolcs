<?php
/**
 * Created by PhpStorm.
 * User: George Vasquez II
 * Date: 2/04/2016
 * Time: 7:45 PM
 */?>

 <script>
	 $(function() {
	 	//alert(getUrlParameter("id"));
	 	getProjectDetails(getUrlParameter("id"));
	 });
	 function getProjectDetails(id){
	 	$.getJSON("<?=base_url()?>viewproject/get_project_details_control",
 			{projectid:id},function(data){
 				if(data != "error"){
 					var headString = "";
 					if(data.status == -1){
 						if(data.position == 2)
 							headString += "<label class='label label-default'>Pending</label>";
 						else
 							if(<?php echo $_SESSION['id'];?> == data.empid)
 								headString += "<button id='aproj' title='Approve' class='btn btn-primary btn-sm'><i class='icon_check_alt'></i></button>"
                                              + "&nbsp;<button id='dproj' title='Decline' class='btn btn-danger btn-sm'><i class='icon_close_alt'></i></button>";
                    }else if(data.emp_stat == 1)
                    	if(<?php echo $_SESSION['position'];?> == 2)
                    		headString += "<label class='label label-success'>Approved</label>";
                    else if(data.emp_stat == 2)
                    	if(<?php echo $_SESSION['position'];?> == 2){
                    		headString += "<label class='label label-danger'>Declined</label>";
                            headString += "<br><div style='margin-top:10px;'><button title='View Reason' onclick='viewReason(" + id + ",1)' class='btn btn-danger btn-sm'><i class='icon_documents_alt'></i></button>"
                                        + "&nbsp;<button onclick='cemployee2(" + id + "," + data.priority + "," + <?php echo $_SESSION['id'];?> + ")' title='Change Employee' class='btn btn-primary btn-sm'><i class='icon_search_alt'></i></button>"
                                        + "&nbsp;<button onclick='outsource(" + id + ",1)' title='Outsource' class='btn btn-warning btn-sm'><i class='icon_group'></i></button></div>";
                    	}
 					$("#projecthead").append(headString);
 					if(data.emp_stat == 2)
 						$('#tasktable thead tr').append( $('<th />', {text : 'Output',style: 'text-align:center'}) );
 					if(data.emp_stat == 4){
 						$("#revCommentDiv").append('<textarea rows="9" cols="73" id="revcomment2" style="resize: none;overflow-y: scroll;overflow-x: scroll;"></textarea>');
 					}else{
 						$("#revCommentDiv").append("<div id='revcomment2'></div>");
 					}
 					if(data.emp_stat >= 6){
 						var taskString = "<li class=''>"
                                +"<a  id='exp' data-toggle='tab' href='#pexpenses' >"
                                +    "<i class='icon-envelope'></i>"
                                +    "Project Expense"
                                +"</a>"
                           	+"</li>";
 						$("#projectexpense").append(taskString);
 					}
 					$('#pname').html(data['name']);
		            $('#datefrom').html(data['datefrom']);
		            $('#dateto').html(data['dateto']);
		            $('#pstatus').html(data['priority']);
		            $('#projstatus').html(data['emp_stat']);
		            //$('#budget').html(data[5].split(": ")[0] + " Php" + ReplaceNumberWithCommas(data[5].split(": ")[1]));
		            //$('#ptask').html(data[6]);
		            //$('#ctask').html(data[7]);
		            //$('#ttask').html(data[8]);
		            $('#pdescription').html(data['description']);
		            $('#pbackground').html(data['background']);
		            $('#psignificance').html(data['significance']);
		            $('#pobjectives').html(data[12]);
		            //$('#totalamount').html("Php " + ReplaceNumberWithCommas(data[5].split(": ")[1]));
		            if (parseInt(data['status']) >= 0 && parseInt(data['status']) <= 4) {
		                $('#gantttitle').html("Proposed Schedule");
		                $('#projmap').html("Proposed Site");

		            } else {
		                $('#gantttitle').html("Project Schedule");
		                $('#projmap').html("Project Hazard Map");

		            }
 				}
 		});
	 }
	 function showRedirect(redirectTo){
	 	var pages = ['viewreport','progress','task','assignproject','createreport'];
	 	window.location.replace(pages[redirectTo] +'?id=' + getUrlParameter("id"));
	 }

	 var getUrlParameter = function getUrlParameter(sParam) {
	    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
	        sURLVariables = sPageURL.split('&'),
	        sParameterName,
	        i;

	    for (i = 0; i < sURLVariables.length; i++) {
	        sParameterName = sURLVariables[i].split('=');

	        if (sParameterName[0] === sParam) {
	            return sParameterName[1] === undefined ? true : sParameterName[1];
	        }
	    }
	};
 </script>