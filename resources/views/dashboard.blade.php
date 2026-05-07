<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DigitalOcean Dashboard</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Segoe UI;
        }

        body{
            background:#0f172a;
            color:white;
            min-height:100vh;
        }

        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 40px;
            background:#111827;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }

        .logo{
            font-size:22px;
            font-weight:bold;
        }

        .navbar a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            transition:0.3s;
        }

        .navbar a:hover{
            color:#3b82f6;
        }

        .container{
            max-width:1200px;
            margin:50px auto;
            padding:20px;
        }

        .heading{
            margin-bottom:30px;
        }

        .heading h1{
            font-size:34px;
            margin-bottom:10px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:20px;
        }

        .card{
            background:#1e293b;
            padding:30px;
            border-radius:14px;
            transition:0.3s;
            box-shadow:0 10px 25px rgba(0,0,0,0.3);
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .card p{
            color:#94a3b8;
            margin-bottom:10px;
        }

        .card h2{
            font-size:36px;
        }

    </style>

</head>

<body>

    <div class="navbar">

        <div class="logo">
            ☁ DigitalOcean Dashboard
        </div>

        <div>
            <a href="/dashboard">Dashboard</a>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>

    </div>

    <div class="container">

        <div class="heading">
            <h1>Cloud Infrastructure Overview</h1>
            <p>Monitor your servers and infrastructure resources.</p>
        </div>

        <div class="cards">

            <div class="card">
                <p>Total Regions</p>
                <h2>{{ $stats['regions'] }}</h2>
            </div>

            <div class="card">
                <p>Total Droplets</p>
                <h2>{{ $stats['droplets'] }}</h2>
            </div>

            <div class="card">
                <p>Running Servers</p>
                <h2>{{ $stats['running'] }}</h2>
            </div>

            <div class="card">
                <p>Total Memory</p>
                <h2>{{ $stats['memory'] }}</h2>
            </div>

        </div>

    </div>

</body>

</html>