<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analytics - DigitalOcean Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #0f172a; color: white; }
        .navbar { padding: 20px 40px; background: #111827; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; transition: 0.3s; }
        .navbar a:hover { color: #3b82f6; }
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #1e293b; border-radius: 16px; padding: 24px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-3px); background: #2d3a4e; }
        .stat-card h3 { font-size: 14px; color: #94a3b8; margin-bottom: 12px; letter-spacing: 1px; text-transform: uppercase; }
        .stat-card .value { font-size: 36px; font-weight: bold; }
        .stat-card .trend { font-size: 14px; margin-top: 8px; color: #22c55e; }
        .chart-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .chart-card { background: #1e293b; border-radius: 16px; padding: 24px; }
        .chart-card h3 { margin-bottom: 20px; font-size: 18px; }
        .distribution-list { list-style: none; }
        .distribution-list li { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .badge { background: #3b82f6; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="navbar">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="font-size: 22px; font-weight: bold;">📊 Cloud Analytics</div>
            <div>
                <a href="/dashboard">Dashboard</a>
                <a href="/regions">Regions</a>
                <a href="/sizes">Sizes</a>
                <a href="/droplets">Droplets</a>
                <a href="/analytics" style="color: #3b82f6;">Analytics</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Droplets</h3>
                <div class="value">{{ $data['total_droplets'] }}</div>
            </div>
            <div class="stat-card">
                <h3>Running Servers</h3>
                <div class="value">{{ $data['running_droplets'] }}</div>
                <div class="trend">↑ {{ round(($data['running_droplets'] / max($data['total_droplets'], 1)) * 100) }}% of total</div>
            </div>
            <div class="stat-card">
                <h3>Stopped Servers</h3>
                <div class="value">{{ $data['stopped_droplets'] }}</div>
            </div>
            <div class="stat-card">
                <h3>Total Monthly Cost</h3>
                <div class="value">${{ number_format($data['total_cost'], 2) }}</div>
            </div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <h3>🌍 Distribution by Region</h3>
                <ul class="distribution-list">
                    @foreach($data['regions_distribution'] as $region => $count)
                        <li><span>{{ $region }}</span><span class="badge">{{ $count }} servers</span></li>
                    @endforeach
                </ul>
            </div>
            <div class="chart-card">
                <h3>⚡ Server Status</h3>
                <ul class="distribution-list">
                    @foreach($data['status_distribution'] as $status => $count)
                        <li>
                            <span style="color: {{ $status == 'Running' ? '#22c55e' : ($status == 'Stopped' ? '#ef4444' : '#f59e0b') }}">
                                ● {{ $status }}
                            </span>
                            <span class="badge">{{ $count }} servers</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</body>
</html>