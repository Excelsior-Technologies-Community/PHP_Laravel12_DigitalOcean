<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DigitalOcean Regions</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Arial
        }

        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            min-height: 100vh;
            color: #fff;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            padding: 6px 14px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .navbar a:hover {
            background: #2563eb;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            backdrop-filter: blur(12px);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .title {
            font-size: 26px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
        }

        th {
            background: #1e40af;
        }

        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background: rgba(37, 99, 235, 0.3);
        }

        .badge {
            background: #22c55e;
            padding: 4px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <div class="logo">DigitalOcean Dashboard</div>
        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <div class="title">🌍 Available Regions</div>

            <table>
                <tr>
                    <th>#</th>
                    <th>Region Name</th>
                    <th>Status</th>
                </tr>

                @foreach($regions as $index => $region)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $region->name }}</td>
                        <td><span class="badge">Active</span></td>
                    </tr>
                @endforeach

            </table>

        </div>

    </div>

</body>

</html>