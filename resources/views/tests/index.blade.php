<!DOCTYPE html>
<html>
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
    }

</style>

<body>

    <h2>The XMLHttpRequest Object</h2>

    <button type="button">Get my CD collection</button>
    <br><br>
    <table id="demo"></table>

    <script>
        var xhttp = new XMLHttpRequest();
        var x;
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myObj = JSON.parse(this.response);
                console.log(myObj);
            };
        };
        xhttp.open("GET", "/fullcalendar", true);
        xhttp.send();

    </script>

</body>

</html>
