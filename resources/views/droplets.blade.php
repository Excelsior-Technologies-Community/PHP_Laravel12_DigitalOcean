<!DOCTYPE html>
<html>

<head>
    <title>Droplet Monitoring</title>

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

        .navbar a:hover{
            color:#3b82f6;
        }

        .container{
            max-width:1200px;
            margin:50px auto;
        }

        .card{
            background:#1e293b;
            padding:30px;
            border-radius:12px;
        }

        h2{
            margin-bottom:25px;
        }

        /* FILTERS */

        .filters{
            display:flex;
            gap:15px;
            margin-bottom:25px;
            flex-wrap:wrap;
        }

        .filters input,
        .filters select{
            padding:12px;
            border:none;
            border-radius:8px;
            background:#0f172a;
            color:white;
            min-width:200px;
        }

        .filters button{
            padding:12px 20px;
            border:none;
            border-radius:8px;
            background:#2563eb;
            color:white;
            cursor:pointer;
        }

        .filters button:hover{
            background:#1d4ed8;
        }

        table{
            width:100%;
            border-collapse:collapse;
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

        tr:hover{
            background:rgba(37,99,235,0.15);
        }

        .running{
            background:#22c55e;
            padding:6px 12px;
            border-radius:6px;
        }

        .stopped{
            background:#ef4444;
            padding:6px 12px;
            border-radius:6px;
        }

        .maintenance{
            background:#f59e0b;
            padding:6px 12px;
            border-radius:6px;
        }

        .empty{
            text-align:center;
            padding:30px;
            color:#94a3b8;
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

        <h2>☁️ Droplet Monitoring</h2>

        <!-- SEARCH + FILTER -->

        <form method="GET" action="/droplets">

            <div class="filters">

                <!-- SEARCH -->

                <input
                    type="text"
                    name="search"
                    placeholder="Search server name..."
                    value="{{ request('search') }}"
                >

                <!-- REGION FILTER -->

                <select name="region">

                    <option value="">All Regions</option>

                    <option value="New York"
                        {{ request('region') == 'New York' ? 'selected' : '' }}>
                        New York
                    </option>

                    <option value="London"
                        {{ request('region') == 'London' ? 'selected' : '' }}>
                        London
                    </option>

                    <option value="Singapore"
                        {{ request('region') == 'Singapore' ? 'selected' : '' }}>
                        Singapore
                    </option>

                    <option value="Frankfurt"
                        {{ request('region') == 'Frankfurt' ? 'selected' : '' }}>
                        Frankfurt
                    </option>

                </select>

                <!-- STATUS FILTER -->

                <select name="status">

                    <option value="">All Status</option>

                    <option value="Running"
                        {{ request('status') == 'Running' ? 'selected' : '' }}>
                        Running
                    </option>

                    <option value="Stopped"
                        {{ request('status') == 'Stopped' ? 'selected' : '' }}>
                        Stopped
                    </option>

                    <option value="Maintenance"
                        {{ request('status') == 'Maintenance' ? 'selected' : '' }}>
                        Maintenance
                    </option>

                </select>

                <button type="submit">
                    Apply Filters
                </button>

            </div>

        </form>

        <!-- TABLE -->

        <table>

            <tr>
                <th>#</th>
                <th>Server Name</th>
                <th>Region</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Created</th>
            </tr>

            @forelse($droplets as $index => $droplet)

            <tr>

                <td>{{ $index + 1 }}</td>

                <td>{{ $droplet->name }}</td>

                <td>{{ $droplet->region }}</td>

                <td>{{ $droplet->ip }}</td>

                <td>

                    @if($droplet->status == 'Running')

                        <span class="running">
                            {{ $droplet->status }}
                        </span>

                    @elseif($droplet->status == 'Stopped')

                        <span class="stopped">
                            {{ $droplet->status }}
                        </span>

                    @else

                        <span class="maintenance">
                            {{ $droplet->status }}
                        </span>

                    @endif

                </td>

                <td>{{ $droplet->created }}</td>

            </tr>

            @empty

            <tr>

                <td colspan="6" class="empty">
                    No droplets found.
                </td>

            </tr>

            @endforelse

        </table>

    </div>

</div>

</body>

</html>