<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DigitalOceanController extends Controller
{
    // Store sessions data (simulated database)
    private $dropletsData = [];
    private $sshKeysData = [];
    private $backupsData = [];
    private $apiTokensData = [];
    private $activityLogs = [];
    private $floatingIpsData = [];
    private $loadBalancersData = [];
    private $firewallsData = [];
    private $alertsData = [];
    private $containerRegistry = [];
    private $kubernetesData = [];
    private $databasesData = [];
    private $spacesData = [];
    private $cdnData = [];
    private $projectsData = [];
    private $teamMembers = [];
    private $supportTickets = [];

   public function __construct()
{
    // Initialize data in session if not exists
    if (!session()->has('droplets')) {
        session()->put('droplets', collect([
            (object)[
                'id' => 1,
                'name' => 'web-server-01',
                'region' => 'New York',
                'ip' => '192.168.1.1',
                'status' => 'Running',
                'created' => '2026-05-01',
                'vcpu' => 2,
                'memory' => '4GB',
                'disk' => '80GB',
                'cost' => 15.00  // Store as float, not string
            ],
            (object)[
                'id' => 2,
                'name' => 'db-server-01',
                'region' => 'London',
                'ip' => '192.168.1.2',
                'status' => 'Stopped',
                'created' => '2026-05-03',
                'vcpu' => 4,
                'memory' => '8GB',
                'disk' => '160GB',
                'cost' => 30.00  // Store as float
            ],
            (object)[
                'id' => 3,
                'name' => 'cache-server',
                'region' => 'Singapore',
                'ip' => '192.168.1.3',
                'status' => 'Maintenance',
                'created' => '2026-05-06',
                'vcpu' => 1,
                'memory' => '2GB',
                'disk' => '40GB',
                'cost' => 10.00  // Store as float
            ],
            (object)[
                'id' => 4,
                'name' => 'app-server-01',
                'region' => 'Frankfurt',
                'ip' => '192.168.1.4',
                'status' => 'Running',
                'created' => '2026-05-07',
                'vcpu' => 8,
                'memory' => '16GB',
                'disk' => '320GB',
                'cost' => 80.00  // Store as float
            ],
        ]));
    }
        if (!session()->has('ssh_keys')) {
            session()->put('ssh_keys', collect([]));
        }

        if (!session()->has('backups')) {
            session()->put('backups', collect([]));
        }

        if (!session()->has('api_tokens')) {
            session()->put('api_tokens', collect([
                (object)[
                    'id' => 1,
                    'name' => 'Production API Key',
                    'created' => '2026-05-01',
                    'last_used' => '2026-05-15',
                    'scopes' => ['read', 'write']
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Development Token',
                    'created' => '2026-05-10',
                    'last_used' => '2026-05-14',
                    'scopes' => ['read']
                ],
            ]));
        }

        if (!session()->has('activity_logs')) {
            session()->put('activity_logs', collect([
                (object)['action' => 'Droplet Created', 'resource' => 'web-server-01', 'user' => 'admin@example.com', 'time' => '2026-05-15 10:30:00'],
                (object)['action' => 'Droplet Stopped', 'resource' => 'db-server-01', 'user' => 'admin@example.com', 'time' => '2026-05-14 15:20:00'],
                (object)['action' => 'SSH Key Added', 'resource' => 'my-key', 'user' => 'admin@example.com', 'time' => '2026-05-13 09:15:00'],
                (object)['action' => 'Backup Created', 'resource' => 'app-server-01', 'user' => 'system', 'time' => '2026-05-12 23:00:00'],
            ]));
        }

        if (!session()->has('floating_ips')) {
            session()->put('floating_ips', collect([
                (object)['ip' => '159.89.100.1', 'droplet_id' => 1, 'region' => 'New York', 'status' => 'Active'],
                (object)['ip' => '159.89.100.2', 'droplet_id' => null, 'region' => 'London', 'status' => 'Unassigned'],
            ]));
        }

        if (!session()->has('load_balancers')) {
            session()->put('load_balancers', collect([
                (object)['id' => 1, 'name' => 'web-lb', 'region' => 'New York', 'droplets' => [1, 4], 'status' => 'Active', 'ip' => '159.89.100.10'],
            ]));
        }

        if (!session()->has('firewalls')) {
            session()->put('firewalls', collect([
                (object)['id' => 1, 'name' => 'web-firewall', 'inbound_rules' => 'HTTP, HTTPS, SSH', 'outbound_rules' => 'All', 'droplets' => 2, 'status' => 'Active'],
            ]));
        }

        if (!session()->has('alerts')) {
            session()->put('alerts', collect([
                (object)['id' => 1, 'name' => 'CPU Alert', 'condition' => 'CPU > 80%', 'action' => 'Email', 'status' => 'Enabled'],
                (object)['id' => 2, 'name' => 'Memory Alert', 'condition' => 'Memory > 85%', 'action' => 'Slack', 'status' => 'Enabled'],
            ]));
        }
    }

    // ========== EXISTING METHODS ==========

   public function dashboard()
{
    $droplets = session('droplets');
    
    // Calculate total cost as float
    $totalCost = $droplets->sum(function($d) {
        // Remove $ sign and convert to float
        return (float) filter_var($d->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    });
    
    $stats = [
        'regions' => 4,
        'droplets' => $droplets->count(),
        'running' => $droplets->where('status', 'Running')->count(),
        'memory' => '8GB',
        'total_cost' => $totalCost,  // Now this is a float
        'this_month_usage' => '$85.50',
        'active_alerts' => 2,
        'backup_count' => session('backups')->count(),
    ];

    return view('dashboard', compact('stats'));
}

    public function regions()
    {
        $regions = [
            (object) ['name' => 'New York', 'slug' => 'nyc1', 'available' => true],
            (object) ['name' => 'London', 'slug' => 'lon1', 'available' => true],
            (object) ['name' => 'Singapore', 'slug' => 'sgp1', 'available' => true],
            (object) ['name' => 'Frankfurt', 'slug' => 'fra1', 'available' => true],
            (object) ['name' => 'Bangalore', 'slug' => 'blr1', 'available' => false],
            (object) ['name' => 'Toronto', 'slug' => 'tor1', 'available' => true],
        ];

        return view('regions', compact('regions'));
    }

    public function sizes()
    {
        $sizes = [
            (object) ['slug' => 's-1vcpu-1gb', 'memory' => '1024MB', 'vcpu' => 1, 'disk' => '25GB', 'price' => '$6'],
            (object) ['slug' => 's-1vcpu-2gb', 'memory' => '2048MB', 'vcpu' => 1, 'disk' => '50GB', 'price' => '$12'],
            (object) ['slug' => 's-2vcpu-2gb', 'memory' => '4096MB', 'vcpu' => 2, 'disk' => '80GB', 'price' => '$18'],
            (object) ['slug' => 's-2vcpu-4gb', 'memory' => '8192MB', 'vcpu' => 2, 'disk' => '160GB', 'price' => '$30'],
            (object) ['slug' => 's-4vcpu-8gb', 'memory' => '16384MB', 'vcpu' => 4, 'disk' => '320GB', 'price' => '$60'],
        ];

        return view('sizes', compact('sizes'));
    }

    public function droplets(Request $request)
    {
        $droplets = session('droplets');

        if ($request->search) {
            $droplets = $droplets->filter(function ($droplet) use ($request) {
                return str_contains(strtolower($droplet->name), strtolower($request->search));
            });
        }

        if ($request->region) {
            $droplets = $droplets->where('region', $request->region);
        }

        if ($request->status) {
            $droplets = $droplets->where('status', $request->status);
        }

        return view('droplets', compact('droplets'));
    }

    // ========== NEW FUNCTIONALITY ==========

    // ANALYTICS & METRICS
    public function analytics()
    {
        $droplets = session('droplets');
        
        $data = [
            'total_droplets' => $droplets->count(),
            'running_droplets' => $droplets->where('status', 'Running')->count(),
            'stopped_droplets' => $droplets->where('status', 'Stopped')->count(),
            'maintenance_droplets' => $droplets->where('status', 'Maintenance')->count(),
            'regions_distribution' => $droplets->groupBy('region')->map->count(),
            'cost_distribution' => $droplets->groupBy('cost')->map->count(),
            'status_distribution' => $droplets->groupBy('status')->map->count(),
            'total_cost' => $droplets->sum(function($d) { 
                return (float) filter_var($d->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            }),
        ];
        
        return view('analytics', compact('data'));
    }

    public function metrics()
    {
        $droplets = session('droplets');
        
        // Simulated metrics data
        $metrics = [
            'cpu_usage' => [45, 62, 38, 71, 55, 48, 52, 67, 43, 58, 61, 44, 39, 72, 68, 54, 47, 63, 59, 42],
            'memory_usage' => [38, 45, 52, 48, 61, 55, 49, 44, 58, 62, 47, 53, 59, 64, 51, 46, 60, 57, 43, 50],
            'network_in' => [120, 145, 98, 167, 134, 156, 143, 129, 138, 152, 147, 135, 141, 149, 128, 136, 144, 155, 132, 140],
            'network_out' => [85, 92, 78, 112, 95, 88, 104, 97, 91, 86, 103, 94, 89, 108, 96, 93, 101, 99, 87, 100],
            'droplets' => $droplets,
        ];
        
        return view('metrics', compact('metrics'));
    }

    // DROPLET MANAGEMENT
    public function dropletDetails($id)
    {
        $droplet = session('droplets')->firstWhere('id', $id);
        
        if (!$droplet) {
            return redirect('/droplets')->with('error', 'Droplet not found');
        }
        
        // Simulated metrics for this droplet
        $metrics = [
            'cpu' => rand(20, 90),
            'memory' => rand(30, 85),
            'disk' => rand(25, 70),
            'network_in' => rand(50, 500),
            'network_out' => rand(30, 400),
            'uptime' => rand(1, 365) . ' days',
        ];
        
        return view('droplet-details', compact('droplet', 'metrics'));
    }

    public function updateStatus(Request $request, $id)
    {
        $droplets = session('droplets');
        $droplet = $droplets->firstWhere('id', $id);
        
        if ($droplet) {
            $oldStatus = $droplet->status;
            $droplet->status = $request->status;
            session()->put('droplets', $droplets);
            
            // Log activity
            $this->logActivity('Status Changed', $droplet->name, "{$oldStatus} → {$request->status}");
            
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Droplet not found'], 404);
    }

    public function createDropletForm()
    {
        $regions = ['New York', 'London', 'Singapore', 'Frankfurt'];
        $sizes = [
            ['slug' => 's-1vcpu-1gb', 'memory' => '1GB', 'cost' => '$6'],
            ['slug' => 's-1vcpu-2gb', 'memory' => '2GB', 'cost' => '$12'],
            ['slug' => 's-2vcpu-2gb', 'memory' => '4GB', 'cost' => '$18'],
            ['slug' => 's-2vcpu-4gb', 'memory' => '8GB', 'cost' => '$30'],
        ];
        
        return view('create-droplet', compact('regions', 'sizes'));
    }

   public function storeDroplet(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'region' => 'required|string',
        'size' => 'required|string',
        'memory' => 'required|string',
        'cost' => 'required|string',
    ]);
    
    $droplets = session('droplets');
    $newId = $droplets->max('id') + 1;
    
    // Convert cost to float (remove $ sign if present)
    $costValue = (float) filter_var($request->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
    $newDroplet = (object)[
        'id' => $newId,
        'name' => $request->name,
        'region' => $request->region,
        'ip' => '192.168.' . rand(1, 255) . '.' . rand(1, 255),
        'status' => 'Running',
        'created' => date('Y-m-d'),
        'vcpu' => (int) explode('-', $request->size)[1] ?? 1,
        'memory' => $request->memory,
        'disk' => '80GB',
        'cost' => $costValue,  // Store as float
    ];
    
    $droplets->push($newDroplet);
    session()->put('droplets', $droplets);
    
    $this->logActivity('Droplet Created', $request->name, 'New droplet instance');
    
    return redirect('/droplets')->with('success', 'Droplet created successfully!');
}

    public function deleteDroplet($id)
    {
        $droplets = session('droplets');
        $droplet = $droplets->firstWhere('id', $id);
        
        if ($droplet) {
            $this->logActivity('Droplet Deleted', $droplet->name, 'Instance removed');
            $droplets = $droplets->reject(function($d) use ($id) {
                return $d->id == $id;
            });
            session()->put('droplets', $droplets);
            return redirect('/droplets')->with('success', 'Droplet deleted successfully');
        }
        
        return redirect('/droplets')->with('error', 'Droplet not found');
    }

    // BILLING & USAGE
    public function billing()
    {
        $droplets = session('droplets');
        
        $billingData = [
            'current_balance' => '$45.50',
            'last_payment' => '$135.00',
            'last_payment_date' => '2026-05-01',
            'next_payment_due' => '2026-06-01',
            'payment_method' => 'VISA ending in 4242',
            'invoices' => [
                (object)['date' => '2026-05-01', 'amount' => '$135.00', 'status' => 'Paid'],
                (object)['date' => '2026-04-01', 'amount' => '$120.00', 'status' => 'Paid'],
                (object)['date' => '2026-03-01', 'amount' => '$115.00', 'status' => 'Paid'],
            ],
            'droplets_cost' => $droplets->sum(function($d) {
                return (float) filter_var($d->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            }),
        ];
        
        return view('billing', compact('billingData'));
    }

    public function usage()
    {
        $droplets = session('droplets');
        
        $usageData = [
            'total_hours' => 720,
            'total_cost' => $droplets->sum(function($d) {
                return (float) filter_var($d->cost, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            }),
            'bandwidth_used' => '1.2 TB',
            'bandwidth_limit' => '5 TB',
            'storage_used' => '320 GB',
            'storage_limit' => '1 TB',
            'droplet_usage' => $droplets->map(function($d) {
                return (object)[
                    'name' => $d->name,
                    'hours' => rand(600, 720),
                    'cost' => $d->cost,
                ];
            }),
        ];
        
        return view('usage', compact('usageData'));
    }

    // SSH KEYS MANAGEMENT
    public function sshKeys()
    {
        $sshKeys = session('ssh_keys');
        return view('ssh-keys', compact('sshKeys'));
    }

    public function addSshKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'public_key' => 'required|string',
        ]);
        
        $sshKeys = session('ssh_keys');
        $newKey = (object)[
            'id' => $sshKeys->count() + 1,
            'name' => $request->name,
            'fingerprint' => substr(md5($request->public_key), 0, 16),
            'created' => date('Y-m-d H:i:s'),
        ];
        
        $sshKeys->push($newKey);
        session()->put('ssh_keys', $sshKeys);
        
        $this->logActivity('SSH Key Added', $request->name, 'New SSH key registered');
        
        return redirect('/ssh-keys')->with('success', 'SSH Key added successfully');
    }

    public function deleteSshKey($id)
    {
        $sshKeys = session('ssh_keys');
        $key = $sshKeys->firstWhere('id', $id);
        
        if ($key) {
            $this->logActivity('SSH Key Deleted', $key->name, 'SSH key removed');
            $sshKeys = $sshKeys->reject(function($k) use ($id) {
                return $k->id == $id;
            });
            session()->put('ssh_keys', $sshKeys);
            return redirect('/ssh-keys')->with('success', 'SSH Key deleted successfully');
        }
        
        return redirect('/ssh-keys')->with('error', 'SSH Key not found');
    }

    // BACKUPS & SNAPSHOTS
    public function backups()
    {
        $backups = session('backups');
        $droplets = session('droplets');
        return view('backups', compact('backups', 'droplets'));
    }

    public function createBackup($id)
    {
        $droplet = session('droplets')->firstWhere('id', $id);
        
        if ($droplet) {
            $backups = session('backups');
            $newBackup = (object)[
                'id' => $backups->count() + 1,
                'name' => $droplet->name . '-backup-' . date('YmdHis'),
                'droplet_id' => $id,
                'size' => rand(2, 50) . 'GB',
                'created' => date('Y-m-d H:i:s'),
                'type' => 'Snapshot',
            ];
            
            $backups->push($newBackup);
            session()->put('backups', $backups);
            
            $this->logActivity('Backup Created', $droplet->name, 'New backup created');
            
            return redirect('/backups')->with('success', 'Backup created successfully');
        }
        
        return redirect('/backups')->with('error', 'Droplet not found');
    }

    public function deleteBackup($id)
    {
        $backups = session('backups');
        $backup = $backups->firstWhere('id', $id);
        
        if ($backup) {
            $this->logActivity('Backup Deleted', $backup->name, 'Backup removed');
            $backups = $backups->reject(function($b) use ($id) {
                return $b->id == $id;
            });
            session()->put('backups', $backups);
            return redirect('/backups')->with('success', 'Backup deleted successfully');
        }
        
        return redirect('/backups')->with('error', 'Backup not found');
    }

    // API TOKENS MANAGEMENT
    public function apiTokens()
    {
        $tokens = session('api_tokens');
        return view('api-tokens', compact('tokens'));
    }

    public function createApiToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'scopes' => 'required|array',
        ]);
        
        $tokens = session('api_tokens');
        $newToken = (object)[
            'id' => $tokens->count() + 1,
            'name' => $request->name,
            'token' => 'do_api_' . bin2hex(random_bytes(20)),
            'created' => date('Y-m-d H:i:s'),
            'last_used' => 'Never',
            'scopes' => $request->scopes,
        ];
        
        $tokens->push($newToken);
        session()->put('api_tokens', $tokens);
        
        $this->logActivity('API Token Created', $request->name, 'New API token generated');
        
        return redirect('/api-tokens')->with('success', 'API Token created successfully');
    }

    public function deleteApiToken($id)
    {
        $tokens = session('api_tokens');
        $token = $tokens->firstWhere('id', $id);
        
        if ($token) {
            $this->logActivity('API Token Deleted', $token->name, 'API token revoked');
            $tokens = $tokens->reject(function($t) use ($id) {
                return $t->id == $id;
            });
            session()->put('api_tokens', $tokens);
            return redirect('/api-tokens')->with('success', 'API Token deleted successfully');
        }
        
        return redirect('/api-tokens')->with('error', 'API Token not found');
    }

    // ACTIVITY LOGS
    public function activityLogs()
    {
        $logs = session('activity_logs');
        return view('activity-logs', compact('logs'));
    }

    // FLOATING IPS
    public function floatingIps()
    {
        $floatingIps = session('floating_ips');
        $droplets = session('droplets');
        return view('floating-ips', compact('floatingIps', 'droplets'));
    }

    public function assignFloatingIp(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
            'droplet_id' => 'required|integer',
        ]);
        
        $floatingIps = session('floating_ips');
        $floatingIp = $floatingIps->firstWhere('ip', $request->ip);
        
        if ($floatingIp) {
            $floatingIp->droplet_id = $request->droplet_id;
            $floatingIp->status = 'Active';
            session()->put('floating_ips', $floatingIps);
            
            $droplet = session('droplets')->firstWhere('id', $request->droplet_id);
            $this->logActivity('Floating IP Assigned', $request->ip, "Assigned to {$droplet->name}");
            
            return redirect('/floating-ips')->with('success', 'Floating IP assigned successfully');
        }
        
        return redirect('/floating-ips')->with('error', 'Floating IP not found');
    }

    public function releaseFloatingIp($ip)
    {
        $floatingIps = session('floating_ips');
        $floatingIp = $floatingIps->firstWhere('ip', $ip);
        
        if ($floatingIp) {
            $floatingIp->droplet_id = null;
            $floatingIp->status = 'Unassigned';
            session()->put('floating_ips', $floatingIps);
            
            $this->logActivity('Floating IP Released', $ip, 'IP address released');
            
            return redirect('/floating-ips')->with('success', 'Floating IP released successfully');
        }
        
        return redirect('/floating-ips')->with('error', 'Floating IP not found');
    }

    // LOAD BALANCERS
    public function loadBalancers()
    {
        $loadBalancers = session('load_balancers');
        $droplets = session('droplets');
        return view('load-balancers', compact('loadBalancers', 'droplets'));
    }

    public function createLoadBalancer(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'region' => 'required|string',
            'droplets' => 'required|array',
        ]);
        
        $loadBalancers = session('load_balancers');
        $newLb = (object)[
            'id' => $loadBalancers->count() + 1,
            'name' => $request->name,
            'region' => $request->region,
            'droplets' => $request->droplets,
            'status' => 'Active',
            'ip' => '159.89.' . rand(1, 255) . '.' . rand(1, 255),
        ];
        
        $loadBalancers->push($newLb);
        session()->put('load_balancers', $loadBalancers);
        
        $this->logActivity('Load Balancer Created', $request->name, 'New load balancer instance');
        
        return redirect('/load-balancers')->with('success', 'Load Balancer created successfully');
    }

    // FIREWALL RULES
    public function firewalls()
    {
        $firewalls = session('firewalls');
        $droplets = session('droplets');
        return view('firewalls', compact('firewalls', 'droplets'));
    }

    public function createFirewall(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'inbound_rules' => 'required|string',
            'outbound_rules' => 'required|string',
            'droplet_ids' => 'required|array',
        ]);
        
        $firewalls = session('firewalls');
        $newFirewall = (object)[
            'id' => $firewalls->count() + 1,
            'name' => $request->name,
            'inbound_rules' => $request->inbound_rules,
            'outbound_rules' => $request->outbound_rules,
            'droplets' => count($request->droplet_ids),
            'droplet_ids' => $request->droplet_ids,
            'status' => 'Active',
        ];
        
        $firewalls->push($newFirewall);
        session()->put('firewalls', $firewalls);
        
        $this->logActivity('Firewall Created', $request->name, 'New firewall rules applied');
        
        return redirect('/firewalls')->with('success', 'Firewall created successfully');
    }

    public function deleteFirewall($id)
    {
        $firewalls = session('firewalls');
        $firewall = $firewalls->firstWhere('id', $id);
        
        if ($firewall) {
            $this->logActivity('Firewall Deleted', $firewall->name, 'Firewall removed');
            $firewalls = $firewalls->reject(function($f) use ($id) {
                return $f->id == $id;
            });
            session()->put('firewalls', $firewalls);
            return redirect('/firewalls')->with('success', 'Firewall deleted successfully');
        }
        
        return redirect('/firewalls')->with('error', 'Firewall not found');
    }

    // MONITORING ALERTS
    public function alerts()
    {
        $alerts = session('alerts');
        return view('alerts', compact('alerts'));
    }

    public function createAlert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'condition' => 'required|string',
            'action' => 'required|string',
        ]);
        
        $alerts = session('alerts');
        $newAlert = (object)[
            'id' => $alerts->count() + 1,
            'name' => $request->name,
            'condition' => $request->condition,
            'action' => $request->action,
            'status' => 'Enabled',
        ];
        
        $alerts->push($newAlert);
        session()->put('alerts', $alerts);
        
        $this->logActivity('Alert Created', $request->name, 'New monitoring alert');
        
        return redirect('/alerts')->with('success', 'Alert created successfully');
    }

    public function deleteAlert($id)
    {
        $alerts = session('alerts');
        $alert = $alerts->firstWhere('id', $id);
        
        if ($alert) {
            $this->logActivity('Alert Deleted', $alert->name, 'Monitoring alert removed');
            $alerts = $alerts->reject(function($a) use ($id) {
                return $a->id == $id;
            });
            session()->put('alerts', $alerts);
            return redirect('/alerts')->with('success', 'Alert deleted successfully');
        }
        
        return redirect('/alerts')->with('error', 'Alert not found');
    }

    // CONTAINER REGISTRY
    public function containerRegistry()
    {
        $repositories = session('container_registry', collect());
        return view('container-registry', compact('repositories'));
    }

    public function createRepository(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'visibility' => 'required|string',
        ]);
        
        $repositories = session('container_registry', collect());
        $newRepo = (object)[
            'id' => $repositories->count() + 1,
            'name' => $request->name,
            'visibility' => $request->visibility,
            'created' => date('Y-m-d H:i:s'),
            'tags' => 0,
        ];
        
        $repositories->push($newRepo);
        session()->put('container_registry', $repositories);
        
        $this->logActivity('Repository Created', $request->name, 'Container registry repository');
        
        return redirect('/container-registry')->with('success', 'Repository created successfully');
    }

    // KUBERNETES CLUSTERS
    public function kubernetesClusters()
    {
        $clusters = session('kubernetes_data', collect([
            (object)[
                'id' => 1,
                'name' => 'prod-k8s',
                'region' => 'New York',
                'version' => '1.28',
                'node_count' => 3,
                'status' => 'Running',
                'created' => '2026-04-01',
            ]
        ]));
        return view('kubernetes', compact('clusters'));
    }

    public function createKubernetesCluster(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'region' => 'required|string',
            'version' => 'required|string',
            'node_count' => 'required|integer|min=1|max=10',
        ]);
        
        $clusters = session('kubernetes_data', collect());
        $newCluster = (object)[
            'id' => $clusters->count() + 1,
            'name' => $request->name,
            'region' => $request->region,
            'version' => $request->version,
            'node_count' => $request->node_count,
            'status' => 'Provisioning',
            'created' => date('Y-m-d H:i:s'),
        ];
        
        $clusters->push($newCluster);
        session()->put('kubernetes_data', $clusters);
        
        $this->logActivity('K8s Cluster Created', $request->name, 'New Kubernetes cluster');
        
        return redirect('/kubernetes')->with('success', 'Kubernetes cluster created successfully');
    }

    public function deleteKubernetesCluster($id)
    {
        $clusters = session('kubernetes_data', collect());
        $cluster = $clusters->firstWhere('id', $id);
        
        if ($cluster) {
            $this->logActivity('K8s Cluster Deleted', $cluster->name, 'Kubernetes cluster removed');
            $clusters = $clusters->reject(function($c) use ($id) {
                return $c->id == $id;
            });
            session()->put('kubernetes_data', $clusters);
            return redirect('/kubernetes')->with('success', 'Kubernetes cluster deleted successfully');
        }
        
        return redirect('/kubernetes')->with('error', 'Cluster not found');
    }

    // DATABASES
    public function databases()
    {
        $databases = session('databases_data', collect([
            (object)[
                'id' => 1,
                'name' => 'prod-postgres',
                'engine' => 'PostgreSQL',
                'version' => '15',
                'region' => 'New York',
                'size' => 'db-s-1vcpu-1gb',
                'status' => 'Running',
                'created' => '2026-03-15',
            ]
        ]));
        return view('databases', compact('databases'));
    }

    public function createDatabase(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'engine' => 'required|string',
            'version' => 'required|string',
            'region' => 'required|string',
            'size' => 'required|string',
        ]);
        
        $databases = session('databases_data', collect());
        $newDb = (object)[
            'id' => $databases->count() + 1,
            'name' => $request->name,
            'engine' => $request->engine,
            'version' => $request->version,
            'region' => $request->region,
            'size' => $request->size,
            'status' => 'Creating',
            'created' => date('Y-m-d H:i:s'),
        ];
        
        $databases->push($newDb);
        session()->put('databases_data', $databases);
        
        $this->logActivity('Database Created', $request->name, 'New database cluster');
        
        return redirect('/databases')->with('success', 'Database created successfully');
    }

    public function deleteDatabase($id)
    {
        $databases = session('databases_data', collect());
        $database = $databases->firstWhere('id', $id);
        
        if ($database) {
            $this->logActivity('Database Deleted', $database->name, 'Database cluster removed');
            $databases = $databases->reject(function($d) use ($id) {
                return $d->id == $id;
            });
            session()->put('databases_data', $databases);
            return redirect('/databases')->with('success', 'Database deleted successfully');
        }
        
        return redirect('/databases')->with('error', 'Database not found');
    }

    // SPACES (Object Storage)
    public function spaces()
    {
        $spaces = session('spaces_data', collect([
            (object)[
                'name' => 'my-app-assets',
                'region' => 'New York',
                'created' => '2026-04-10',
                'objects' => 1250,
                'size' => '45 GB',
                'status' => 'Active',
            ]
        ]));
        return view('spaces', compact('spaces'));
    }

    public function createSpace(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:spaces',
            'region' => 'required|string',
        ]);
        
        $spaces = session('spaces_data', collect());
        $newSpace = (object)[
            'name' => $request->name,
            'region' => $request->region,
            'created' => date('Y-m-d H:i:s'),
            'objects' => 0,
            'size' => '0 GB',
            'status' => 'Active',
        ];
        
        $spaces->push($newSpace);
        session()->put('spaces_data', $spaces);
        
        $this->logActivity('Space Created', $request->name, 'Object storage space');
        
        return redirect('/spaces')->with('success', 'Space created successfully');
    }

    public function deleteSpace($name)
    {
        $spaces = session('spaces_data', collect());
        $space = $spaces->firstWhere('name', $name);
        
        if ($space) {
            $this->logActivity('Space Deleted', $name, 'Object storage space removed');
            $spaces = $spaces->reject(function($s) use ($name) {
                return $s->name == $name;
            });
            session()->put('spaces_data', $spaces);
            return redirect('/spaces')->with('success', 'Space deleted successfully');
        }
        
        return redirect('/spaces')->with('error', 'Space not found');
    }

    // CDN
    public function cdn()
    {
        $cdnEndpoints = session('cdn_data', collect([
            (object)[
                'id' => 1,
                'origin' => 'my-app-assets.nyc3.digitaloceanspaces.com',
                'endpoint' => 'cdn.myapp.com',
                'created' => '2026-04-15',
                'status' => 'Enabled',
            ]
        ]));
        return view('cdn', compact('cdnEndpoints'));
    }

    public function createCDNEndpoint(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'endpoint' => 'required|string',
        ]);
        
        $cdnEndpoints = session('cdn_data', collect());
        $newEndpoint = (object)[
            'id' => $cdnEndpoints->count() + 1,
            'origin' => $request->origin,
            'endpoint' => $request->endpoint,
            'created' => date('Y-m-d H:i:s'),
            'status' => 'Provisioning',
        ];
        
        $cdnEndpoints->push($newEndpoint);
        session()->put('cdn_data', $cdnEndpoints);
        
        $this->logActivity('CDN Endpoint Created', $request->endpoint, 'New CDN endpoint');
        
        return redirect('/cdn')->with('success', 'CDN endpoint created successfully');
    }

    public function deleteCDNEndpoint($id)
    {
        $cdnEndpoints = session('cdn_data', collect());
        $endpoint = $cdnEndpoints->firstWhere('id', $id);
        
        if ($endpoint) {
            $this->logActivity('CDN Endpoint Deleted', $endpoint->endpoint, 'CDN endpoint removed');
            $cdnEndpoints = $cdnEndpoints->reject(function($c) use ($id) {
                return $c->id == $id;
            });
            session()->put('cdn_data', $cdnEndpoints);
            return redirect('/cdn')->with('success', 'CDN endpoint deleted successfully');
        }
        
        return redirect('/cdn')->with('error', 'CDN endpoint not found');
    }

    // PROJECTS
    public function projects()
    {
        $projects = session('projects_data', collect([
            (object)[
                'id' => 1,
                'name' => 'Production',
                'description' => 'Main production environment',
                'resources' => 4,
                'created' => '2026-01-01',
            ],
            (object)[
                'id' => 2,
                'name' => 'Development',
                'description' => 'Development and testing',
                'resources' => 2,
                'created' => '2026-01-01',
            ]
        ]));
        return view('projects', compact('projects'));
    }

    public function createProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        
        $projects = session('projects_data', collect());
        $newProject = (object)[
            'id' => $projects->count() + 1,
            'name' => $request->name,
            'description' => $request->description,
            'resources' => 0,
            'created' => date('Y-m-d H:i:s'),
        ];
        
        $projects->push($newProject);
        session()->put('projects_data', $projects);
        
        $this->logActivity('Project Created', $request->name, 'New project');
        
        return redirect('/projects')->with('success', 'Project created successfully');
    }

    public function updateProject(Request $request, $id)
    {
        $projects = session('projects_data', collect());
        $project = $projects->firstWhere('id', $id);
        
        if ($project) {
            $project->name = $request->name;
            $project->description = $request->description;
            session()->put('projects_data', $projects);
            
            $this->logActivity('Project Updated', $request->name, 'Project details updated');
            
            return redirect('/projects')->with('success', 'Project updated successfully');
        }
        
        return redirect('/projects')->with('error', 'Project not found');
    }

    public function deleteProject($id)
    {
        $projects = session('projects_data', collect());
        $project = $projects->firstWhere('id', $id);
        
        if ($project) {
            $this->logActivity('Project Deleted', $project->name, 'Project removed');
            $projects = $projects->reject(function($p) use ($id) {
                return $p->id == $id;
            });
            session()->put('projects_data', $projects);
            return redirect('/projects')->with('success', 'Project deleted successfully');
        }
        
        return redirect('/projects')->with('error', 'Project not found');
    }

    // TEAM MANAGEMENT
    public function teamMembers()
    {
        $teamMembers = session('team_members', collect([
            (object)[
                'id' => 1,
                'email' => 'admin@example.com',
                'role' => 'Owner',
                'status' => 'Active',
                'joined' => '2026-01-01',
            ]
        ]));
        return view('team', compact('teamMembers'));
    }

    public function inviteTeamMember(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
        ]);
        
        $teamMembers = session('team_members', collect());
        $newMember = (object)[
            'id' => $teamMembers->count() + 1,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'Pending',
            'joined' => date('Y-m-d H:i:s'),
        ];
        
        $teamMembers->push($newMember);
        session()->put('team_members', $teamMembers);
        
        $this->logActivity('Team Member Invited', $request->email, 'Invitation sent');
        
        return redirect('/team')->with('success', 'Invitation sent successfully');
    }

    public function removeTeamMember($id)
    {
        $teamMembers = session('team_members', collect());
        $member = $teamMembers->firstWhere('id', $id);
        
        if ($member) {
            $this->logActivity('Team Member Removed', $member->email, 'Member removed from team');
            $teamMembers = $teamMembers->reject(function($m) use ($id) {
                return $m->id == $id;
            });
            session()->put('team_members', $teamMembers);
            return redirect('/team')->with('success', 'Team member removed successfully');
        }
        
        return redirect('/team')->with('error', 'Team member not found');
    }

    // SUPPORT TICKETS
    public function supportTickets()
    {
        $tickets = session('support_tickets', collect([
            (object)[
                'id' => 1,
                'subject' => 'Unable to connect to droplet',
                'status' => 'Resolved',
                'priority' => 'High',
                'created' => '2026-05-10',
                'updated' => '2026-05-11',
            ]
        ]));
        return view('support', compact('tickets'));
    }

    public function createSupportTicket(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|string',
        ]);
        
        $tickets = session('support_tickets', collect());
        $newTicket = (object)[
            'id' => $tickets->count() + 1,
            'subject' => $request->subject,
            'status' => 'Open',
            'priority' => $request->priority,
            'created' => date('Y-m-d H:i:s'),
            'updated' => date('Y-m-d H:i:s'),
        ];
        
        $tickets->push($newTicket);
        session()->put('support_tickets', $tickets);
        
        $this->logActivity('Support Ticket Created', $request->subject, 'New support request');
        
        return redirect('/support')->with('success', 'Support ticket created successfully');
    }

    // Helper method to log activities
    private function logActivity($action, $resource, $details = '')
    {
        $logs = session('activity_logs');
        $newLog = (object)[
            'action' => $action,
            'resource' => $resource,
            'user' => auth()->user()->email ?? 'admin@example.com',
            'time' => date('Y-m-d H:i:s'),
            'details' => $details,
        ];
        
        $logs->prepend($newLog);
        session()->put('activity_logs', $logs);
    }
}