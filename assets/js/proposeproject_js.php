<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 1/19/2016
 * Time: 7:56 PM
*/
?> 

<script>
    $(function(){
        $("#projectDurationFrom, #projectDurationTo").datepicker({
          dateFormat: "MM dd, yy",
          minDate: '+1M', // your min date
          //maxDate: '+1w', // one week will always be 5 business day - not sure if you are including current day
          beforeShowDay: $.datepicker.noWeekends // disable weekends
      });
        $(".btnEditOutput").bind("click", editOutputTableRow);
        $(".btnDeleteOutput").bind("click", deleteOutputTableRow);
        $("#btnAddOutput").bind("click", addOutputTableRow);
        $(".btnEditBudget").bind("click", editBudgetTableRow);
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow);
        $(".btnEditObjective").bind("click", editObjectiveTableRow);
        $(".btnDeleteObjective").bind("click", deleteObjectiveTableRow);
        $("#btnAddObjective").bind("click", addObjectiveTableRow);

        counter = 0;
        $("#btnAddBudget").click(function(){
            counter++;
            $('#budgetContainer table').append(
                  $('<tr id="'+counter+'">')
                   .append($('<td id="bItem">').html("Budget Item"))
                   .append($('<td id="eType">').html("General Expense"))
                   .append($('<td id="qty">').html("0"))
                   .append($('<td id="amt">').html("0"))
                   .append($('<td id="total">').html("0"))
                   .append($('<td>').html('<button id="editBudget" class="btn btn-info edit">Edit</button><button id="editBudget" class="btn btn-danger delete">Delete</button>'))
                   );
            $('#budgetContainer').on('click', '.edit', function(){
                //get id, by a simple method of finding the element
                $('#modalAddBudgetItem').modal();
                id = $(this).parents('tr').find('td:first').text();
                document.getElementById("budgetItem").value = document.getElementById("budgetTable").rows[counter].cells.item(0).innerHTML;
                document.getElementById("budgetQuantity").value = document.getElementById("budgetTable").rows[counter].cells.item(2).innerHTML;
                document.getElementById("budgetAmount").value = document.getElementById("budgetTable").rows[counter].cells.item(3).innerHTML;
            });

            $('#budgetContainer').on('click', '.delete', function(){
                //get id, by a simple method of finding the element
                var par = $(this).parent().parent(); 
                par.remove();   
            });

            $('#modalAddBudgetItem').on('click', '.save', function(){
                //get id, by a simple method of finding the element
                // event.preventDefault();
                console.log("this works");
            });

            //change text
            // $('.change').live('click',function(){
            //    //get id via button value
            //     id = $(this).val();
            //     //get the closest input text
            //     new_text = $(this).siblings('input[type="text"]').val();
                
            //     //find the specific tr that has an id of.. and look for the corresponding td to change, please read about eq() in jquery
            //     $('#budgetContainer table').find('tr#' +id).find('td').eq('1').text(new_text);
                
            // });
        });
        totalExpenseTable();
        initProjectTypes();
        // initMapCanvas();
        initializeMap();
        initProjectObject();
        $("#btnProceed").bind("click", proceedToWorkPlan);
        $("#btnSaveAsDraft").bind("click", saveAsDraft);
        $("#btnLoadDraft").bind("click", loadDraft);
        $("#btnResetForm").bind("click", resetForm);

    });
    function initProjectObject(){
        project =  {
            project_name:"",
            project_type:"",
            date_from:"",
            date_to:"",
            project_head:"",
            priority:"",
            description:"",
            background:"",
            latitude:"",
            longitude:"",
            location_name:"",
            significance:"",
            draft_name:"",
            createdby:""
        };

        budget = [];
        outputs = [];
        objectives = [];

        // workplan = {};

        console.log(budget);
        console.log(outputs);
        console.log(objectives);
        console.log(project);
    }
    function resetForm(){
        window.location.reload();
    }
    function proceedToWorkPlan(){ 
        prepareProjectObject();
        // var json = JSON.stringify(project);
        // console.log(json);
    }
    function addBudget(){
        // $("#modalAddBudgetItem").modal();
        
    }
    function saveAsDraft(){
        $("#modalSaveAsDraft").modal();
        prepareProjectObject();
        document.getElementById("draftName").value = "[Draft] "+ project.project_name;
        project.draft_name = document.getElementById("draftName").value;
        var json_objectives = JSON.stringify(objectives);
        var json_outputs = JSON.stringify(outputs);

        $("#btnSubmitDraft").click(function(event){
            event.preventDefault();
            $.post("<?=base_url()?>proposeproject/add_project_draft_control", {
                project_name: project.project_name,
                project_type: project.project_type,
                date_from: project.date_from,
                date_to: project.date_to,
                project_head: project.project_head,
                priority: project.priority,
                description: project.description,
                background: project.background,
                latitude: project.latitude,
                longitude: project.longitude,
                location_name: project.location_name,
                significance: project.significance,
                draft_name: project.draft_name,
                createdby: project.createdby,
                objectives: json_objectives,
                outputs: json_outputs
            }, function(data){
                data = data.replace(/\"/g, "");
                if(data == 'error')
                    console.log(error);
                else{
                    $('#modalSaveAsDraft').modal('hide');
                    prepareProjectObject();
                }
            });
        });
    }
    function loadDraft(){

    }
    function prepareProjectObject(){
        var empid = <?=$_SESSION['id'];?>;
        project.project_name = document.getElementById("projectName").value;
        project.project_type = document.getElementById("projectTypeSelect").value;
        project.date_from = document.getElementById("projectDurationFrom").value;
        project.date_to = document.getElementById("projectDurationTo").value;
        project.project_head = document.getElementById("projectHead").value;
        project.priority = document.getElementById("projectPriorityLevel").value;
        project.description = document.getElementById("projectDescription").value;
        project.background = document.getElementById("projectBackground").value;
        project.latitude = document.getElementById("map-latitude").value;
        project.longitude = document.getElementById("map-longitude").value;
        project.location_name = document.getElementById("map-address").value;
        project.significance = document.getElementById("projectSignificance").value;
        project.createdby = empid;

        var TableData1 = new Array();
        $('#outputTable tr').each(function(row, tr){
            TableData1[row]={
                expected : $(tr).find('td:eq(0)').text(), 
                pindicator :$(tr).find('td:eq(1)').text()
            }
            outputs = TableData1;
        });

        var TableData2 = new Array();
        $('#objectiveTable tr').each(function(row, tr){
            TableData2[row]={
                objective : $(tr).find('td:eq(0)').text()
            }
            objectives = TableData2;
        });

        console.log(project);
        console.log(outputs);
        console.log(objectives);
    }

    function addObjectiveTableRow(){
        $("#objectiveTable tbody").append( "<tr>"+ "<td><input type='text' class='form-control'/></td>" + 
            "<td><button class='btn btn-info btnSave' id='btnSave'>Save</button> <button class='btn btn-danger btnDeleteObjective' id='btnDeleteObjective'>Delete</button></td>"+ "</tr>"); 
        $(".btnSave").bind("click", saveObjectiveTableRow); 
        $(".btnDeleteObjective").bind("click", deleteObjectiveTableRow);
    }
    function saveObjectiveTableRow(){ 
        var par = $(this).parent().parent(); 
        var tdObjective = par.children("td:nth-child(1)"); 
        var tdButtons = par.children("td:nth-child(2)"); 
        tdObjective.html(tdObjective.children("input[type=text]").val()); 
        tdButtons.html("<button class='btn btn-info btnEditObjective' id='btnEditObjective'>Edit</button> <button class='btn btn-danger btnDeleteObjective' id='btnDeleteObjective'>Delete</button>"); 
        $(".btnEditObjective").bind("click", editObjectiveTableRow); 
        $(".btnDeleteObjective").bind("click", deleteObjectiveTableRow); 
    }
    function editObjectiveTableRow(){ var par = $(this).parent().parent(); 
        var tdObjective = par.children("td:nth-child(1)"); 
        var tdButtons = par.children("td:nth-child(2)"); 
        tdObjective.html("<input type='text' id='txtName' value='"+tdObjective.html()+"'/>"); 
        tdButtons.html("<button class='btn btn-info btnSave' id='btnSave'>Save</button>"); 
        $(".btnSave").bind("click", saveObjectiveTableRow);
        $(".btnEditObjective").bind("click", editObjectiveTableRow); 
        $(".btnDeleteObjective").bind("click", deleteObjectiveTableRow); 
    }
    function deleteObjectiveTableRow(){ 
        var par = $(this).parent().parent(); 
        par.remove();   
    }
    function addOutputTableRow(){
        $("#outputTable tbody").append( "<tr>"+ "<td><input type='text' class='form-control'/></td>"+ "<td><input type='text' class='form-control'/></td>"+ 
            "<td><button class='btn btn-info btnSave' id='btnSave'>Save</button> <button class='btn btn-danger btnDeleteOutput' id='btnDeleteOutput'>Delete</button></td>"+ "</tr>"); 
        $(".btnSave").bind("click", saveOutputTableRow); 
        $(".btnDeleteOutput").bind("click", deleteOutputTableRow);
    }
    function saveOutputTableRow(){ 
        var par = $(this).parent().parent(); 
        var tdExpectedOutput = par.children("td:nth-child(1)"); 
        var tdPerformanceIndicator = par.children("td:nth-child(2)"); 
        var tdButtons = par.children("td:nth-child(3)"); 
        tdExpectedOutput.html(tdExpectedOutput.children("input[type=text]").val()); 
        tdPerformanceIndicator.html(tdPerformanceIndicator.children("input[type=text]").val()); 
        tdButtons.html("<button class='btn btn-info btnEditOutput' id='btnEditOutput'>Edit</button> <button class='btn btn-danger btnDeleteOutput' id='btnDeleteOutput'>Delete</button>"); 
        $(".btnEditOutput").bind("click", editOutputTableRow); 
        $(".btnDeleteOutput").bind("click", deleteOutputTableRow); 
    }
    function editOutputTableRow(){ var par = $(this).parent().parent(); 
        var tdExpectedOutput = par.children("td:nth-child(1)"); 
        var tdPerformanceIndicator = par.children("td:nth-child(2)"); 
        var tdButtons = par.children("td:nth-child(3)"); 
        tdExpectedOutput.html("<input type='text' id='txtName' value='"+tdExpectedOutput.html()+"'/>"); 
        tdPerformanceIndicator.html("<input type='text' id='txtPhone' value='"+tdPerformanceIndicator.html()+"'/>"); 
        tdButtons.html("<button class='btn btn-info btnSave' id='btnSave'>Save</button>"); 
        $(".btnSave").bind("click", saveOutputTableRow);
        $(".btnEditOutput").bind("click", editOutputTableRow); 
        $(".btnDeleteOutput").bind("click", deleteOutputTableRow); 
    }
    function deleteOutputTableRow(){ 
        var par = $(this).parent().parent(); 
        par.remove();   
    }
    function addBudgetTableRow(){
        var stringSelect = "<select class='form-control' id='expenseTypeSelect'> <option value='1'>General Expense</option> <option value='2'>Equipment</option> </select>";
        $("#budgetTable tbody").append( "<tr>"+ "<td><input type='text' class='form-control'/></td>"+ "<td>"+ stringSelect +"</td>"+ 
            "<td><input type='text' class='form-control'/></td>" + "<td><input type='text' class='form-control'/></td>" + "<td></td>" +
            "<td><button class='btn btn-info btnSave' id='btnSave'>Save</button> <button class='btn btn-danger btnDeleteOutput' id='btnDeleteOutput'>Delete</button></td>"+ "</tr>"); 
        $(".btnSave").bind("click", saveBudgetTableRow); 
        $(".btnDeleteOutput").bind("click", deleteBudgetTableRow);
    }
    function saveBudgetTableRow(){ 
        var par = $(this).parent().parent(); 
        var tdBudgetItem = par.children("td:nth-child(1)"); 
        var tdExpenseType = par.children("td:nth-child(2)");
        var tdQuantity = par.children("td:nth-child(3)"); 
        var tdAmount = par.children("td:nth-child(4)");
        var tdTotal = par.children("td:nth-child(5)"); 
        var tdButtons = par.children("td:nth-child(6)"); 
        tdBudgetItem.html(tdBudgetItem.children("input[type=text]").val()); 
        tdExpenseType.html(tdExpenseType.children(document.getElementById("expenseTypeSelect").selectedIndex).text());
        var qty = tdQuantity.html(tdQuantity.children("input[type=text]").val()); 
        var amt = tdAmount.html(tdAmount.children("input[type=text]").val());
        var sum = qty.text() * amt.text();
        tdTotal.html(sum);
        tdButtons.html("<button class='btn btn-info btnEditBudget' id='btnEditBudget'>Edit</button> <button class='btn btn-danger btnDeleteBudget' id='btnDeleteBudget'>Delete</button>"); 
        $(".btnEditBudget").bind("click", editBudgetTableRow); 
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow); 
        document.getElementById("totalamount").html(tdTotal.val()); 
    }
    function editBudgetTableRow(){ var par = $(this).parent().parent(); 
        var stringSelect = "<select class='form-control' id='expenseTypeSelect'> <option value='1'>General Expense</option> <option value='2'>Equipment</option> </select>";
        var tdBudgetItem = par.children("td:nth-child(1)"); 
        var tdExpenseType = par.children("td:nth-child(2)");
        var tdQuantity = par.children("td:nth-child(3)"); 
        var tdAmount = par.children("td:nth-child(4)");
        var tdTotal = par.children("td:nth-child(5)"); 
        var tdButtons = par.children("td:nth-child(6)"); 
        tdBudgetItem.html("<input type='text'  value='"+tdBudgetItem.html()+"'/>"); 
        tdExpenseType.html(stringSelect);  
        tdQuantity.html("<input type='text'  value='"+tdQuantity.html()+"'/>"); 
        tdAmount.html("<input type='text'  value='"+tdAmount.html()+"'/>"); 
        tdButtons.html("<button class='btn btn-info btnSave' id='btnSave'>Save</button>"); 
        $(".btnSave").bind("click", saveBudgetTableRow);
        $(".btnEditBudget").bind("click", editBudgetTableRow); 
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow); 
    }
    function deleteBudgetTableRow(){ 
        var par = $(this).parent().parent(); 
        par.remove();   
    }
    function totalExpenseTable(){

    }
    function initProjectTypes(){
        //get project types and populate projectTypeSelect
        $.getJSON("<?=base_url()?>proposeproject/get_project_nature_list_control", function(data){
            var items = "";
            $.each(data,function(key,value) {
                items+="<option value='"+value.id+"'>"+value.name+"</option>";
            });

            $("#projectTypeSelect").html(items); 
        });
    }

    var map;
    var markers = [];
    function initializeMap(){

      var mapProp = {
        center:new google.maps.LatLng(13.624633438236152, 122.49755859375),
        zoom:12,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map-canvas"),mapProp);
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });

    var infoWindow = new google.maps.InfoWindow({map: map});

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
        };

        infoWindow.setPosition(pos);
        infoWindow.setContent('You are located here.');
        map.setCenter(pos);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
  });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }

    var geocoder = new google.maps.Geocoder();
    document.getElementById('map-search').addEventListener('click', function() {
        geocodeAddress(geocoder, map);
    });
    document.getElementById('map-reset').addEventListener('click', function() {
        initializeMap();
        document.getElementById('map-address').value = "";
        document.getElementById('map-latitude').value = "";
        document.getElementById('map-longitude').value = "";
        document.getElementById('map-address').readOnly = false;
    });
    document.getElementById('map-submit').addEventListener('click', function() {
        document.getElementById('map-address').readOnly = true;
        project.latitude = document.getElementById('map-latitude').value;
        project.longitude = document.getElementById('map-longitude').value;
        document.getElementById('map-search').disabled = true;
    });
}
function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location,
        map: map,
    });
    markers.push(marker);

    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
    });
    infowindow.open(map,marker);
    document.getElementById('map-latitude').value = location.lat();
    document.getElementById('map-longitude').value = location.lng();
}
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
    'Error: The Geolocation service failed.' :
    'Error: Your browser doesn\'t support geolocation.');
}
function geocodeAddress(geocoder, resultsMap) {
  var address = document.getElementById('map-address').value;
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      resultsMap.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location
    });
      var location = resultsMap.getCenter();
      document.getElementById('map-latitude').value = location.lat();
      document.getElementById('map-longitude').value = location.lng();
      console.log(location.lat());
      console.log(location.lng());
  } else {
      alert('Geocode was not successful for the following reason: ' + status);
  }
});
}
google.maps.event.addDomListener(window, 'load', initializeMap);

</script>