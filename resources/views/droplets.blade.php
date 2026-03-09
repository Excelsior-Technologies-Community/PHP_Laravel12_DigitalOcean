<!DOCTYPE html>
<html>

<head>
    <title>Droplets</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI
        }

        body {
            background: linear-gradient(135deg, #020617, #0f172a);
            color: white;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            padding: 15px 40px;
            background: rgba(255, 255, 255, 0.05);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            max-width: 900px;
            margin: 60px auto;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        h2 {
            margin-bottom: 20px;
        }

        .server {
            padding: 14px;
            margin-bottom: 12px;
            border-radius: 8px;
            background: rgba(59, 130, 246, 0.3);
            transition: 0.3s;
        }

        .server:hover {
            transform: scale(1.03);
            background: #2563eb;
        }
    </style>

</head>

<body>

    <div class="navbar">
        <div>DigitalOcean Dashboard</div>
        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <h2>☁️ Droplet Servers</h2>

            @foreach($droplets as $droplet)
                <div class="server">
                    {{ $droplet->name }}
                </div>
            @endforeach

        </div>

    </div>

</body>

</html>