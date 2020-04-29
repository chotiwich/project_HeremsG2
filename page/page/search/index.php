<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>

    <script src="js/jquery-3.5.0.min.js"></script>

    <script>
      $(() => {
        $("#btnLoad").click(btnLoad_Click);
      });

      function btnLoad_Click() {
        var idclick = $("#ID").val();
        var urlAPI = "http://localhost/search/slimsearch.php/getdb/"+idclick;

        $.getJSON(urlAPI, { format: "json" })
          .done(function (data) {
            console.log(data);
            $("#id").text(data["0"]["id"]);
            $("#name").text(data["0"]["name"]);
            $("#lastname").text(data["0"]["lastname"]);
            $("#status").text(data["0"]["status"]);
            $("#telephone").text(data["0"]["telephone"]);
          })
          .fail(function (jqxhr, testStatus, error) {}
          );
      }
    </script>
    
</head>
<body>
    <input type="text" name="" id="ID" /><br />
    <button id="btnLoad">Load</button><br />
    </br>
   ID: <span id="id"></span><br />
   Name: <span id="name"></span><br />
   Lastname: <span id="lastname"></span><br />
   Status: <span id="status"></span><br />
   Telephone: <span id="telephone"></span><br />


</body>
</html>