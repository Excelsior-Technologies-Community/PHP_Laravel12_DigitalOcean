<!DOCTYPE html>
<html>

<head>
    <title>Regions</title>

    <style>

        body{
            font-family:Segoe UI;
            background:#0f172a;
            color:white;
            margin:0;
        }

        .navbar{
            padding:20px 40px;
            background:#111827;
        }

        .navbar a{
            color:white;
            text-decoration:none;
            margin-right:20px;
        }

        .container{
            max-width:1000px;
            margin:50px auto;
        }

        .card{
            background:#1e293b;
            padding:30px;
            border-radius:12px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th,td{
            padding:15px;
            text-align:left;
        }

        th{
            background:#2563eb;
        }

        tr:nth-child(even){
            background:rgba(255,255,255,0.05);
        }

    </style>

</head>

<body>

<div class="navbar">

    <a href="/dashboard">Dashboard</a>
    <a href="/regions">Regions</a>
    <a href="/sizes">Sizes</a>
    <a href="/droplets">Droplets</a>

</div>

<div class="container">

    <div class="card">

        <h2>🌍 Available Regions</h2>

        <table>

            <tr>
                <th>#</th>
                <th>Region</th>
                <th>Status</th>
            </tr>

            @foreach($regions as $index => $region)

            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $region->name }}</td>
                <td>Active</td>
            </tr>

            @endforeach

        </table>

    </div>

</div>

</body>

</html>