<?php
http_response_code(404);
header('X-Robots-Tag: noindex'); // Block search indexing
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            user-select: none;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .container {
            width: 40%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            flex-direction: column;
            border: 2px solid;
            padding: 20px;
        }

        h1 {
            font-size: 60px;
            line-height: 45px;
        }

        button {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            background-color: black;
            color: white;
            border: 2px solid;
            font-size: 14px;
        }

        button:hover {
            background-color: white;
            border: 2px solid;
            color: black;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>404</h1>
        <p>Unfortunately the page you are looking for is not present!</p>
        <a href="/"><button>Go Back</button></a>
    </div>
</body>

</html>