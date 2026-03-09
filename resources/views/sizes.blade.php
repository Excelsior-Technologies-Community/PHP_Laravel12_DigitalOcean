<!DOCTYPE html>
<html>

<head>
    <title>Droplet Sizes</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Segoe UI, Arial;
        }

        body {
            background: linear-gradient(135deg, #020617, #0f172a);
            color: white;
            min-height: 100vh;
        }

        /* NAVBAR */

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 40px;
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }

        .navbar a:hover {
            color: #3b82f6;
        }

        /* CONTAINER */

        .container {
            max-width: 1000px;
            margin: 80px auto;
            padding: 20px;
        }

        /* CARD */

        .card {
            background: rgba(255, 255, 255, 0.07);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        /* TITLE */

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        /* TABLE */

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead {
            background: #2563eb;
        }

        th {
            padding: 14px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* COLUMN WIDTHS */

        th:nth-child(1),
        td:nth-child(1) {
            width: 60px;
            text-align: center;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 400px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 150px;
            text-align: right;
        }

        /* MEMORY COLOR */

        .memory {
            color: #22c55e;
            font-weight: 600;
        }

        /* HOVER */

        tbody tr:hover {
            background: rgba(59, 130, 246, 0.15);
        }
    </style>

</head>

<body>

    <div class="navbar">
        <div><b>DigitalOcean Dashboard</b></div>

        <div>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
        </div>
    </div>

    <div class="container">

        <div class="card">

            <div class="title">💻 Droplet Sizes</div>

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Slug</th>
                        <th>Memory</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($sizes as $index => $size)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $size->slug }}</td>
                            <td class="memory">{{ $size->memory }}</td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>