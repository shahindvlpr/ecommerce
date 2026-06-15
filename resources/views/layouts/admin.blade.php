<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title','Admin Dashboard')
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          rel="stylesheet">

    <style>

        body{
            background:#f4f6f9;
        }

        .sidebar{
            width:260px;
            min-height:100vh;
            background:#212529;
        }

        .sidebar a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px;
        }

        .sidebar a:hover{
            background:#343a40;
        }

        .content{
            width:100%;
            padding:20px;
        }

    </style>

</head>

<body>

<div class="d-flex">

    @include('admin.layouts.sidebar')

    <div class="content">

        @include('admin.layouts.navbar')

        @yield('content')

        @include('admin.layouts.footer')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>