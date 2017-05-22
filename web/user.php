<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/user.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/react@15/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@15/dist/react-dom.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
    <script type="text/babel" src="js/user.js"></script>
    <script>
        function getAuchKey() {
            return 'TkzGKwHPgC_1hemIIvWtLhSkpuSmmm0s';
        }

        function setActiveItemMenu($this) {
            $($this).parents('ul').children('li').each(function (i, e) {
                $('a', e). removeClass('active');
            });

            $($this).addClass('active');
        }
    </script>
</head>
<body>
    <div class="top-menu">
        <ul>
<!--            <li><a href="" onclick="renderLogin(); setActiveItemMenu(this); return false;">Login</a></li>-->
            <li><a href="" onclick="renderTrips(); setActiveItemMenu(this); return false;">Trip</a></li>
            <li><a href="" onclick="renderLogin(); setActiveItemMenu(this); return false;">Contact</a></li>
            <li><a href="" onclick="renderLogin(); setActiveItemMenu(this); return false;">About</a></li>
        </ul>
    </div>

    <div id="content"></div>




    <script type="text/babel">
//        ReactDOM.render(
//            <Login />,
//            document.getElementById('root')
//        );
    </script>
</body>
</html>