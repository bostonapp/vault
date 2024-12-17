<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .homepage {
            background: linear-gradient(135deg, #4caf50, #2196f3);
            color: #fff;
            font-family: Arial, sans-serif;
        }

        .hero-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: bold;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 25px;
            margin: 0 10px;
        }

        .btn-login {
            background-color: #2196f3;
            color: #fff;
            border: none;
        }

        .btn-login:hover {
            background-color: #1976d2;
        }

        .btn-register {
            background-color: #4caf50;
            color: #fff;
            border: none;
        }

        

        .btn-register:hover {
            background-color: #388e3c;
        }

        .btn-browse {
            background-color: #cc9724;
            color: #fff;
            border: none;
        }

        .btn-browse:hover {
            background-color: #ac7c17;
        }

        a{
            text-decoration: none;
        }

        p{
            color: black;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
        }
    </style>
</head>

<body>

    @yield('content')

    <!-- Bootstrap JS (Optional for interactive features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
