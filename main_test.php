<html>
    <head>
        <script>
            function sendForm()
            {
                var un = document.getElementById('idun');
                var value = document.getElementById('idjson');
                var arrayData = {
                    'username': un.value,
                    'passwordHash' : 'none',
                    'code' : 'none'
                };
                var sendJson = JSON.stringify(arrayData);

                value.value = btoa(sendJson);
                alert(value.value);
                form_test.action = "index.php?getstudentallinformation";
            }
        </script>
    </head>
    <body>
        <form method="POST" name="form_test">
            <input type="text"   id="idun" size="20">
            <input type="hidden" name="json" id="idjson" value="">
            <input type="submit" onclick="sendForm()" value="Ok">
            <!-- onclick="sendForm()" comment -->
        </form>
    </body>
</html>

