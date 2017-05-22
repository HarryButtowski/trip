<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User interface</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="js/jquery.loadTemplate.min.js"></script>
    <script type="text/html" id="template">
        <div class="post-container">
            <div data-content="author"></div>
            <div data-content="date"></div>
        </div>
    </script>
    <script type="text/html" id="template2">
        <!--        <img data-src="authorPicture" data-alt="author"/>-->
        <div class="post-container">
            <div data-content="author"></div>
            <div data-content="date"></div>
            <input type="text" data-value="author"/>
            <select data-value="selectedItem" data-template-bind='{"attribute": "options", "value": {"data": "options", "value":"value", "content":"content"}}'></select>
            <select data-options='{"data": "options", "value":"value", "content":"content"}'></select>
            <div data-template-bind='[
        {"attribute": "innerHTML", "value": "post"},
        {"attribute": "data-date", "value": "date"},
        {"attribute": "data-author", "value": "author", "formatter": "sameCaseFormatter", "formatOptions": "upper"}]'>
            </div>
        </div>
    </script>
    <script type="text/javascript">
        $(function () {
            // Set our data for the post
            var post = {
                author       : 'Joe Bloggs',
                date         : '25th May 2013',
                authorPicture: 'SimpleExample/img/joeBloggs.gif',
                post         : 'This is the contents of my post'
            };

            var posts = [
                post,
                {
                    author       : 'Joe Bloggs 2',
                    date         : '28th May 2013',
                    authorPicture: 'SimpleExample/img/joeBloggs.gif',
                    post         : 'This is the contents of my other post'
                }
            ];

            $.addTemplateFormatter({
                upperCaseFormatter: function (value, template) {
                    return value.toUpperCase();
                },
                lowerCaseFormatter: function (value, template) {
                    return value.toLowerCase();
                },
                sameCaseFormatter : function (value, template) {
                    if (template === "upper") {
                        return value.toUpperCase();
                    } else {
                        return value.toLowerCase();
                    }
                }
            });

            // Load template from our templates folder,
            // and populate the data from the post object.
//            $(".simple-template-container").loadTemplate("SimpleExample/Templates/simple.html", posts);
            $(".simple-template-container").loadTemplate("#template2", posts);

            // Load template from our templates folder,
            // and populate the data from the post object.
//            $(".simple-template-container-single").loadTemplate("SimpleExample/Templates/simple.html", post);
            $(".simple-template-container-single").loadTemplate("#template2", post);

            // Load template from element on same page,
            // and populate the data from the post object.
//            $(".script-template-container").loadTemplate("#template", post);
        });
    </script>
</head>
<body>
    <div class="simple-template-container"></div>
    <div class="simple-template-container-single"></div>
    <div class="script-template-container"></div>
</body>
</html>