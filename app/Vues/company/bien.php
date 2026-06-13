<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <a href="">open teams</a>
    <script type="module">
        import Qtix from "/js/qtix/qtix.js";
        await Qtix.init();
        // console.log(Qtix);
        import {
            helpers
        } from "/js/qtix/qtix.js";
        console.log(helpers);
        console.log(Qtix);
        console.log(Qtix.teams);
    </script>
</body>

</html>