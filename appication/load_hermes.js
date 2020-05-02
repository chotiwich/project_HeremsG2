$(() => {
    // split id of url(?id=)
    var query = window.location.search.substring(1);
    // alert("query :"+query);
    var vars = query.split("=");
    var ID = vars[1];
    var url = "http://localhost/project_HeremsG2/api.php/ShowReservation/" + ID;
    // jquery  session  display END
    getjson(url);
    // jquery  session  display END




    $("a#c").click(update);

    $("#next").click(function (e) {
        e.preventDefault();
        $("#paicrush").submit();//id form
        var query = window.location.search.substring(0);
        var url = "http://localhost/project_HeremsG2/api.php/updateReservation" + query + "&id=248";
        alert("url :" + url);
        getjson(url);
    });

    // $("#c").click(function(){
    //     alert("pass");
    //     var url = "http://localhost/hermes/projectHermes/api.php/updateReservation?display_firstname=test03&display_lastname=test02&display_telephone=&display_email=&display_note&id=248";
    //     getjson(url);
    // })
});

function getjson(url) {
    $.getJSON(url, { format: "json" })
        .done(function (data) {
            // Display contact/agent
            $("#display_check_inout").val(data[0]['ginfo_in']);
            $("#display_firstname").val(data[0]['resinfo_first_name']);
            $("#display_lastname").val(data[0]['resinfo_last_name']);
            $("#display_email").val(data[0]['resinfo_email']);
            $("#display_telephone").val(data[0]['resinfo_telno']);
            $("#display_note").val(data[0]['resinfo_comments']);

            // Display detail reser
            $("#head_room_name").text(data[0]['rtype_eng']);
            $("#head_guest_firstname").text(data[0]['ginfo_first_name']);
            $("#head_guest_lastname").text(data[0]['ginfo_last_name']);


            // Display detail reser room
            $("#display_room").text(data[0]['room_name']);
            $("#display_roomtype").text(data[0]['rtype_eng']);
            $("#display_roombuilding").text(data[0]['building_name']);
            $("#display_roomviews").text(data[0]['rview_eng']);

            // Display detail reser
            $("#display_guest_firstname").val(data[0]['ginfo_first_name']);
            $("#display_guest_lastname").val(data[0]['ginfo_last_name']);
            $("#display_guest_email").val(data[0]['ginfo_email']);
            $("#display_guest_telephone").val(data[0]['ginfo_telno']);
        })
        .fail(function (jqxhr, textStatus, error) {
            alert("fail2");
        })
}

function update(){
    alert("pass update");
    window.location.replace("http://localhost/project_HeremsG2/api.php/updateReservation")
}