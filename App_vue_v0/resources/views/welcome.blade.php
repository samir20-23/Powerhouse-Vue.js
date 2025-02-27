<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Vue.js</title>
</head>
<body>
    <div id="app">
        <hello-world></hello-world> <!-- This will render the Vue component -->
    </div>
    <script src="{{ mix('/js/app.js') }}"></script> <!-- Make sure this is the correct path -->
</body>
</html>
