<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Metrics - DigitalOcean Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #0f172a; color: white; }
        .navbar { padding: 20px 40px; background: #111827; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { color: #3b82f6; }
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        .metrics-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .metric-card { background: #1e293b; border-radius: 16px; padding: 20px; }
        .metric-card h3 { margin-bottom: 15px; font-size: 16px; color: #94a3b8; }
        .metric-value { font-size: 32px; font-weight: bold; margin-bottom: 10px; }
        .metric-unit { font-size: 14px; color: #94a3b8; }
        .progress-bar { background: #334155; border-radius: 10px; height: 8px; overflow: hidden; margin-top: 15px; }
        .progress-fill { background: #3b82f6; height: 100%; border-radius: 10px; transition: width 0.3s; }
        .droplet-list { margin-top: 20px; }
        .droplet-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #0f172a; border-radius: 12px; margin-bottom: 10px; }
        .status { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 10px; }
        .status-running { background: #22c55e; box-shadow: 0 0 5px #22c55e; }
        .status-stopped { background: #ef4444; }
        .status-maintenance { background: #f59e0b; }
    </style>
</head>
<body>
    <div class="navbar">
        <div style="display: flex; justify-content: space-between;">
            <div style="font-size: 22px; font-weight: bold;">📈 Real-time Metrics</div>
            <div>
                <a href="/dashboard">Dashboard</a>
                <a href="/regions">Regions</a>
                <a href="/sizes">Sizes</a>
                <a href="/droplets">Droplets</a>
                <a href="/analytics">Analytics</a>
                <a href="/metrics" style="color: #3b82f6;">Metrics</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="metrics-grid">
            <div class="metric-card">
                <h3>📊 Average CPU Usage</h3>
                <div class="metric-value">{{ round(array_sum($metrics['cpu_usage']) / count($metrics['cpu_usage'])) }}%</div>
                <div class="progress-bar"><div class="progress-fill" style="width: 55%"></div></div>
            </div>
            <div class="metric-card">
                <h3>💾 Average Memory Usage</h3>
                <div class="metric-value">{{ round(array_sum($metrics['memory_usage']) / count($metrics['memory_usage'])) }}%</div>
                <div class="progress-bar"><div class="progress-fill" style="width: 48%"></div></div>
            </div>
            <div class="metric-card">
                <h3>📡 Network In (avg)</h3>
                <div class="metric-value">{{ round(array_sum($metrics['network_in']) / count($metrics['network_in'])) }}</div>
                <div class="metric-unit">Mbps</div>
            </div>
            <div class="metric-card">
                <h3>📤 Network Out (avg)</h3>
                <div class="metric-value">{{ round(array_sum($metrics['network_out']) / count($metrics['network_out'])) }}</div>
                <div class="metric-unit">Mbps</div>
            </div>
        </div>

        <div class="metric-card" style="margin-top: 20px;">
            <h3>🖥️ All Droplets</h3>
            <div class="droplet-list">
                @foreach($metrics['droplets'] as $droplet)
                    <div class="droplet-item">
                        <div>
                            <span class="status status-{{ strtolower($droplet->status) }}"></span>
                            <strong>{{ $droplet->name }}</strong>
                            <span style="color: #94a3b8; margin-left: 10px;">{{ $droplet->ip }}</span>
                        </div>
                        <div>
                            <span style="margin-right: 15px;">{{ $droplet->region }}</span>
                            <span class="badge" style="background: {{ $droplet->status == 'Running' ? '#22c55e' : '#ef4444' }}; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                {{ $droplet->status }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>