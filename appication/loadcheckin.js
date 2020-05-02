$(() => {
    display();
    $("#btnSearch").click(btnSearch_Click);
  });
  function display() {
    var urlAPI = "http://localhost/project_HeremsG2/apicheckin.php/getdb";
    $.getJSON(urlAPI).done(function (data) {
      // console.log(JSON.stringify(data));
  
      var line = "";
      $.each(data, function (k, item) {
        // console.log(item);
        line += "<tr>";
        line += "<td > </td>";
        line += "<td >" + item.resinfo_first_name + "</td>";
        line += "<td >" + item.room_name + "</td>";
        line += "<td >" + item.agency_name + "</td>";
        line += "<td >" + item.resinfo_telno + "</td>";
        line += "<td >" + item.resinfo_first_name + "</td>";
        line += "<td >" + item.bl_checkin + "</td>";
        line += "<td >" + item.resinfo_bookdate + "</td>";
        line += "</tr>";
      });
  
      $("#tblData").empty();
      $("#tblData").append(line);
    });
  }
  function btnSearch_Click() {
    alert("ok");
    var idcheck = $("#keyword").val();
    var urlAPI = "http://localhost/project_HeremsG2/apicheckin.php/getdb/" + idcheck;
    $.getJSON(urlAPI).done(function (data) {
      // console.log(JSON.stringify(data));
      var line = "";
      $.each(data, function (k, item) {
        // console.log(item);
        line += "<tr>";
        line += "<td > </td>";
        line += "<td >" + item.resinfo_first_name + "</td>";
        line += "<td >" + item.room_name + "</td>";
        line += "<td >" + item.agency_name + "</td>";
        line += "<td >" + item.resinfo_telno + "</td>";
        line += "<td >" + item.resinfo_first_name + "</td>";
        line += "<td >" + item.bl_checkin + "</td>";
        line += "<td >" + item.resinfo_bookdate + "</td>";
        line += "</tr>";
      });
  
      $("#tblData").empty();
      $("#tblData").append(line);
    });
    $(function dd() {
      $("#date").datepicker();
    });
  }
  function displayroomva() {
    alert("oh");
    var urlAPI = "http://localhost/project_HeremsG2/apicheckin.php/getroomva";
    $.getJSON(urlAPI).done(function (data) {
      // console.log(JSON.stringify(data));
  
      var line = "";
      $.each(data, function (k, item) {
        // console.log(item);
        line += "<tr>";
        line +=
          "<td class=" +
          "checkbox" +
          "><label><input type=" +
          "checkbox" +
          "></label></td>";
        line += "<td >" + item.room_name + "</td>";
        line += "<td >" + item.building_name + "</td>";
        line += "<td >" + item.rtype_eng + "</td>";
        line += "<td >" + item.rview_eng + "</td>";
        line += "<td >" + item.room_price + "</td>";
        line += "<td >" + item.room_guest + "</td>";
        line += "<td >" + item.rstatus_eng + "</td>";
        line += "</tr>";
      });
  
      $("#tblroom").empty();
      $("#tblroom").append(line);
    });
  }
  