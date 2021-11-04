<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/5.3.5/sweetalert2.min.css">
</head>
<body>
    <h1>test</h1>
    <button onclick=f1();>teste</button>
    <a href="https://dev.to/dendihandian" onclick="return confirm('Do you want to go?')">Link</a>
    <a href="#" onclick=deleteConfirm();>Delete</a>
    <form id="delete-product-form-39" action="http://myapp.test/product/39/delete" method="POST">
       aaa <input type="text">
    </form>
    
    <script src="https://cdn.jsdelivr.net/sweetalert2/5.3.5/sweetalert2.min.js"></script>

    <!-- And is where Laravel and javascript come together -->
    <!-- This include basically writes the neccessary javascript: -->
    {{-- @include('Alerts::alerts') --}}
</body>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">

</html>
