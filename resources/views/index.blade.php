<html>
<head>
    <title>STModule03</title>
</head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<body>
    <h1>Cron page</h1>
    <h3>Running......</h3>
    <script type="text/javascript">
        setInterval(function(){
            $.get('{{url('export')}}', function(data) {
                console.log(data);
            });
        }, 120000);
    </script>
</body>
</html>