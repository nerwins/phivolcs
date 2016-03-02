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
        $("#projectDurationFrom").datepicker({
          dateFormat: "MM dd, yy",
          minDate: '+1M', // your min date
          //maxDate: '+1w', // one week will always be 5 business day - not sure if you are including current day
          beforeShowDay: $.datepicker.noWeekends, // disable weekends
          onSelect: function (date) {
                var date1 = $('#projectDurationFrom').datepicker('getDate');
                var date2 = $('#projectDurationFrom').datepicker('getDate');
                date2.setDate(date2.getDate() + 1);
                $('#projectDurationTo').datepicker('setDate', date2);
                //sets minDate to dt1 date + 1
                $('#projectDurationTo').datepicker('option', 'minDate', date2);
                $('#duedate').datepicker('option', 'minDate', date1);
            }
        });
        $('#projectDurationTo').datepicker({
            dateFormat: "MM dd, yy  ",
            beforeShowDay: $.datepicker.noWeekends,
            onClose: function () {
                var dt1 = $('#projectDurationFrom').datepicker('getDate');
                var dt2 = $('#projectDurationTo').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#projectDurationTo').datepicker('option', 'minDate');
                    $('#projectDurationTo').datepicker('setDate', minDate);
                }
                var date1 = $('#projectDurationTo').datepicker('getDate');
                $('#duedate').datepicker('option', 'maxDate', date1);
            }
        });
        $(".btnEditOutput").bind("click", editOutputTableRow);
        $(".btnDeleteOutput").bind("click", deleteOutputTableRow);
        $("#btnAddOutput").bind("click", addOutputTableRow);
        $(".btnEditBudget").bind("click", editBudgetTableRow);
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow);
        $(".btnEditObjective").bind("click", editObjectiveTableRow);
        $(".btnDeleteObjective").bind("click", deleteObjectiveTableRow);
        $("#btnAddObjective").bind("click", addObjectiveTableRow);
        $("#btnAddBudget").bind("click", addBudgetTableRow);
        initProjectTypes();
        initializeMap();
        initProjectObject();
        $("#btnRecommendation").bind("click", getRecommendations);
        $("#btnProceed").bind("click", proceedToWorkPlan);
        $("#btnSaveAsDraft").bind("click", saveAsDraft);
        $("#btnLoadDraft").bind("click", loadDraft);
        $("#btnResetForm").bind("click", resetForm);
        $("#btnViewRec").bind("click", getRecommendedTaskEmployee);
        $("#btnAddEquipment").bind("click", addEquipmentToTask);
        $("#btnAddTask").bind("click", addTask);
        getProjectHeads();
        getSkillsets();
        getEquipmentExpenses();
        $( "#duedate" ).datepicker({
            dateFormat: "MM dd, yy",
            beforeShowDay: $.datepicker.noWeekends
        });
        $(".task-container").droppable();
        $(".todo-task").draggable({ revert: "valid", revertDuration:200 });
        // todo.init();
    });
    function addTask(){
        // TableData = new Array();
        tasks.task_name = document.getElementById("task_name").value;
        tasks.task_priority = document.getElementById("taskPriorityLevel").value;
        tasks.task_skillsets = $('#taskSkillset').chosen().val();
        tasks.task_milestone = document.getElementById("taskMilestone").value;
        tasks.task_output = document.getElementById("taskOutput").value;
        tasks.task_due_date = document.getElementById("duedate").value;
        var TableData1 = new Array();
        $('#assignedEmployees tr').has('td').each(function() {
            // var arrayItem = {};
            $('td', $(this)).each(function(index, item) {
                TableData1.push($(item).html())
            });
            tasks.task_employees = TableData1;
        });
        var TableData2 = new Array();
        $('#taskEquipment tr').has('td').each(function() {
            // var arrayItem = {};
            $('td', $(this)).each(function(index, item) {
                TableData2.push($(item).html())
            });
            tasks.task_equipment = TableData2;
        });
        console.log(tasks);
        // task_name:"",
        //     task_priority:"",
        //     task_skillsets:[],
        //     task_milestone:"",
        //     task_output:"",
        //     task_due_date:"",
        //     task_employees:[],
        //     task_equipment:[]
    }
    function addEquipmentToTask(){
        getEquipmentExpenses();
        var row = $("<tr  />")
        $("#taskEquipment").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
        row.append($("<td>" + document.getElementById("eqName").value + "</td>"));
        row.append($("<td>" + document.getElementById("eqQty").value + "</td>"));
        document.getElementById("eqName").value = "";
    }
    function getRecommendations(){
        $("#modalRecommendation").modal();
        $.getJSON("<?=base_url()?>proposeproject/get_recommendations_control", {projectType: $("#projectTypeSelect :selected").val()} , function(data) {
            if(data == "error") {

            }
            $("#recommendationTable tbody").empty();
            drawTable(data);
            $("#recommendationTable tr").click(function(){
               $(this).addClass('selected').siblings().removeClass('selected');    
               var value=$(this).find('td:first').html();
               $("#btnSubmitRecommendation").click(function(){
                    document.getElementById('projectHead').value = value; 
                    $("#modalRecommendation").modal('hide');
               }); 
            });
        });
    }
    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            drawRow(data[i]);
        }
    }
    function drawRow(rowData) {
        var row = $("<tr  />")
        $("#recommendationTable").append(row); //this will append tr element to table... keep its reference for a while since we will add cels into it
        row.append($("<td>" + rowData[3] + "</td>"));
        row.append($("<td id='dept'>" + getDepartmentName(rowData[5]) + "</td>"));
        row.append($("<td>" + rowData[4] + "</td>"));
        row.append($("<td>" + rowData[2]+ "</td>"));
        row.append($("<td>" + rowData[6]+ "</td>"));
        row.append($("<td>" + rowData[7]+ "</td>"));
    }
    function getRecommendedTaskEmployee(){
        $("#modalRecommendation").modal();
        $.getJSON("<?=base_url()?>proposeproject/get_recommendations_control", {projectType: $("#projectTypeSelect :selected").val()} , function(data) {
            if(data == "error") {

            }
            $("#recommendationTable tbody").empty();
            drawTable(data);
            value = "";
            $("#recommendationTable tr").click(function(){
               $(this).addClass('selected').siblings().removeClass('selected');    
               value=$(this).find('td:first').html();
            });
            $("#btnSubmitRecommendation").click(function(){
                if(value != ""){
                    $("#assignedEmployees tbody:eq(0)").append(
                    $('<tr>')
                        .append($('<td>').html(value))
                    );
                 value = "";
                }
                $("#modalRecommendation").modal('hide');
           }); 
        });
    }

    function getDepartmentName(division_id){
        switch(division_id){
            case '1': return "Volcanology Division";
            break;
            case '2': return "Seismology Division";
            break;
            case '3': return "Finance and Administration Division";
            break;
            case '4': return "Research and Development Division";
            break;
            case '5': return "Disaster Preparedness Division";
            break;
        }
    }
    function getGeneralExpenses(){
        budgetItems = [];
        $.getJSON("<?=base_url()?>proposeproject/get_general_expenses_control",  function(data) {
            if(data == "error") {

            }
            budgetItems = data;
            $( "#bItem" ).autocomplete({
              source: budgetItems
            });
        });
    }
    function getEquipmentExpenses(){
        budgetItems = [];
        $.getJSON("<?=base_url()?>proposeproject/get_equipment_expenses_control",  function(data) {
            if(data == "error") {

            }
            budgetItems = data;
            // console.log("budgets: "+budgetItems);
            $( "#bItem" ).autocomplete({
              source: budgetItems
            });
            $( "#eqName" ).autocomplete({
              source: budgetItems
            });
        });
    }
    function getProjectHeads(){
        projectheads = [];
        $.getJSON("<?=base_url()?>proposeproject/get_project_heads_control",  function(data) {
            if(data == "error") {

            }
            projectheads = data;
            $( "#projectHead" ).autocomplete({
              source: projectheads
            });
             $( "#assignedEmployee" ).autocomplete({
              source: projectheads
            });
        });
    }
    function getSkillsets(){
        skillsets = [];
        $.getJSON("<?=base_url()?>proposeproject/get_skillsets_control",  function(data) {
            if(data == "error") {

            }
            var items = "";
            $.each(data,function(key,value) {
                items+="<option>"+value+"</option>";
            });
            $("#taskSkillset").html(items); 
            $(".chosen-select").chosen({
                width: "290px",
                enable_search_threshold: 10
            }).change(function(event)
            {
                if(event.target == this)
                {
                    var value = $(this).val();
                    $("#result").text(value);
                }
            });
            // console.log(items);
        });
    }
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

        tasks = {
            task_name:"",
            task_priority:"",
            task_skillsets:[],
            task_milestone:"",
            task_output:"",
            task_due_date:"",
            task_employees:[],
            task_equipment:[]
        };

        console.log(budget);
        console.log(outputs);
        console.log(objectives);
        console.log(tasks)
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
        getGeneralExpenses();
         $("#budgetContainer table").append(
            $('<tr>')
                .append($('<td id="eType">').html("<select class='form-control' id='expenseTypeSelect' onchange='changeAutoComplete()'> <option value='1'>General Expense</option> <option value='2'>Equipment</option> </select>"))
                .append($('<td>').html('<input id="bItem" type="text" class="form-control" placeholder="" onchange="searchEquipmentPrice()">'))
                .append($('<td id="eType">').html('<textarea class="form-control" id="budgetReason" rows="3" placeholder="Reason..."></textarea>'))
                .append($('<td>').html('<input class="form-control" id="bQty" style = "width:70px;" type="number" name="quantity" min="1" max="99">'))
                .append($('<td>').html('<input class="form-control" id="bAmt" type="number" name="quantity" min="1" step="any">'))
                .append($('<td id="total">').html("0"))
                .append($('<td>').html('<button id="btnSave" class="btn btn-info btnSave">Save</button><button id="btnDeleteBudget" class="btn btn-danger btnDeleteBudget">Delete</button>'))
            );
         document.getElementById("bQty").defaultValue = "1";
         document.getElementById("bQty").readOnly = true;
        $(".btnSave").bind("click", saveBudgetTableRow); 
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow);
    }
    function searchEquipmentPrice(){
        // console.log("working");
        price = "";
         $.getJSON("<?=base_url()?>proposeproject/search_equipment_price_control",{equipment:$("#bItem").val()}, function(data){
                price = data;
                document.getElementById("bAmt").value = price;
        });
    }
    function changeAutoComplete() {
        var x = document.getElementById("expenseTypeSelect");
        if(x.value == 1){
            getGeneralExpenses();
            document.getElementById("bQty").defaultValue = "1";
            document.getElementById("expenseHeader").innerHTML = "Amount";
            document.getElementById("bQty").readOnly = true;
        } else if(x.value == 2) {
            getEquipmentExpenses();
            document.getElementById("expenseHeader").innerHTML = "Unit Price";
            document.getElementById("bQty").readOnly = false;
        }
    }

    totalBudget = new Array();
    function saveBudgetTableRow(){ 
        var par = $(this).parent().parent(); 
        var sel = document.getElementById("expenseTypeSelect");
        var tdExpenseType = par.children("td:nth-child(1)");
        var tdBudgetItem = par.children("td:nth-child(2)"); 
        var tdReason = par.children("td:nth-child(3)");
        var tdQuantity = par.children("td:nth-child(4)"); 
        var tdAmount = par.children("td:nth-child(5)");
        var tdTotal = par.children("td:nth-child(6)"); 
        var tdButtons = par.children("td:nth-child(7)"); 
        tdBudgetItem.html(tdBudgetItem.children("input[type=text]").val()); 
        tdExpenseType.html(sel.options[sel.selectedIndex].text);
        tdReason.html(tdReason.children("textarea").val());
        var qty = tdQuantity.html(tdQuantity.children("input[type=number]").val()); 
        var amt = tdAmount.html(tdAmount.children("input[type=number]").val());
        var sum = qty.text() * amt.text();
        tdTotal.html(sum);
        tdButtons.html("<button class='btn btn-danger btnDeleteBudget' id='btnDeleteBudget'>Delete</button>"); 
        $(".btnEditBudget").bind("click", editBudgetTableRow); 
        $(".btnDeleteBudget").bind("click", deleteBudgetTableRow); 
        totalBudget.push(sum);
        var total = totalBudget.reduce(function(a, b) { 
            return a + b; 
        }, 0);
        document.getElementById("totalamount").innerHTML = total;
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
        totalBudget = [];
        document.getElementById("totalamount").innerHTML = 0;
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