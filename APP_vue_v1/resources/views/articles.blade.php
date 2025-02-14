<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articles</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <articles></articles> <!-- Your Vue component for displaying articles -->
    </div>
    
    <script src="{{ mix('js/app.js') }}"></script> <!-- Ensure you're loading the compiled Vue app -->
</body>
</html>
