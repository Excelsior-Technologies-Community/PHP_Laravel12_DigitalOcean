<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DigitalOcean Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background: #0f172a; color: white; min-height: 100vh; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background: #111827; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .logo { font-size: 22px; font-weight: bold; }
        .navbar a { color: white; text-decoration: none; margin-left: 20px; transition: 0.3s; }
        .navbar a:hover { color: #3b82f6; }
        .container { max-width: 1200px; margin: 50px auto; padding: 20px; }
        .heading { margin-bottom: 30px; }
        .heading h1 { font-size: 34px; margin-bottom: 10px; }
        .cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .card { background: #1e293b; padding: 30px; border-radius: 14px; transition: 0.3s; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .card:hover { transform: translateY(-5px); }
        .card p { color: #94a3b8; margin-bottom: 10px; }
        .card h2 { font-size: 36px; }
        .card h3 { font-size: 24px; }
        .secondary-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .quick-actions { display: flex; gap: 15px; margin-top: 30px; flex-wrap: wrap; }
        .btn { background: #3b82f6; padding: 12px 24px; border-radius: 8px; text-decoration: none; color: white; transition: 0.3s; display: inline-block; }
        .btn:hover { background: #2563eb; transform: translateY(-2px); }
        .btn-outline { background: transparent; border: 1px solid #3b82f6; }
        .btn-outline:hover { background: #3b82f6; }
        .text-muted { color: #94a3b8; font-size: 14px; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">☁ DigitalOcean Dashboard</div>
        <div>
            <a href="/dashboard">Dashboard</a>
            <a href="/regions">Regions</a>
            <a href="/sizes">Sizes</a>
            <a href="/droplets">Droplets</a>
            <a href="/analytics">Analytics</a>
            <a href="/billing">Billing</a>
            <a href="/alerts">Alerts</a>
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
                <p>Total Monthly Cost</p>
                <h2>${{ number_format((float)$stats['total_cost'], 2) }}</h2>
            </div>
        </div>

        <div class="secondary-cards">
            <div class="card">
                <p>💰 This Month Usage</p>
                <h3>{{ $stats['this_month_usage'] ?? '$0' }}</h3>
            </div>
            <div class="card">
                <p>⚠️ Active Alerts</p>
                <h3>{{ $stats['active_alerts'] ?? 0 }}</h3>
            </div>
            <div class="card">
                <p>💾 Total Backups</p>
                <h3>{{ $stats['backup_count'] ?? 0 }}</h3>
            </div>
        </div>

        <div class="quick-actions">
            <a href="/droplet/create" class="btn">+ Create New Droplet</a>
            <a href="/backups" class="btn btn-outline">Manage Backups</a>
            <a href="/ssh-keys" class="btn btn-outline">SSH Keys</a>
            <a href="/api-tokens" class="btn btn-outline">API Tokens</a>
            <a href="/activity-logs" class="btn btn-outline">Activity Logs</a>
        </div>
    </div>
</body>
</html>