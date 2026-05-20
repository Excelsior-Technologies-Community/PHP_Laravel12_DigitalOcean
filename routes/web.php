<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DigitalOceanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DigitalOceanController::class, 'dashboard']);
Route::get('/regions', [DigitalOceanController::class, 'regions']);
Route::get('/sizes', [DigitalOceanController::class, 'sizes']);
Route::get('/droplets', [DigitalOceanController::class, 'droplets']);

// ========== NEW FUNCTIONALITY ROUTES ==========

// Analytics & Monitoring
Route::get('/analytics', [DigitalOceanController::class, 'analytics']);
Route::get('/metrics', [DigitalOceanController::class, 'metrics']);

// Droplet Management
Route::get('/droplet/{id}', [DigitalOceanController::class, 'dropletDetails']);
Route::post('/droplet/{id}/status', [DigitalOceanController::class, 'updateStatus']);
Route::get('/droplet/create', [DigitalOceanController::class, 'createDropletForm']);
Route::post('/droplet/store', [DigitalOceanController::class, 'storeDroplet']);
Route::delete('/droplet/{id}', [DigitalOceanController::class, 'deleteDroplet']);

// Billing & Usage
Route::get('/billing', [DigitalOceanController::class, 'billing']);
Route::get('/usage', [DigitalOceanController::class, 'usage']);

// SSH Keys Management
Route::get('/ssh-keys', [DigitalOceanController::class, 'sshKeys']);
Route::post('/ssh-keys', [DigitalOceanController::class, 'addSshKey']);
Route::delete('/ssh-keys/{id}', [DigitalOceanController::class, 'deleteSshKey']);

// Backups & Snapshots
Route::get('/backups', [DigitalOceanController::class, 'backups']);
Route::post('/backup/create/{id}', [DigitalOceanController::class, 'createBackup']);
Route::delete('/backup/{id}', [DigitalOceanController::class, 'deleteBackup']);

// API Tokens Management
Route::get('/api-tokens', [DigitalOceanController::class, 'apiTokens']);
Route::post('/api-tokens', [DigitalOceanController::class, 'createApiToken']);
Route::delete('/api-tokens/{id}', [DigitalOceanController::class, 'deleteApiToken']);

// Activity Logs
Route::get('/activity-logs', [DigitalOceanController::class, 'activityLogs']);

// Floating IPs
Route::get('/floating-ips', [DigitalOceanController::class, 'floatingIps']);
Route::post('/floating-ip/assign', [DigitalOceanController::class, 'assignFloatingIp']);
Route::delete('/floating-ip/{ip}', [DigitalOceanController::class, 'releaseFloatingIp']);

// Load Balancers
Route::get('/load-balancers', [DigitalOceanController::class, 'loadBalancers']);
Route::post('/load-balancer/create', [DigitalOceanController::class, 'createLoadBalancer']);

// Firewall Rules
Route::get('/firewalls', [DigitalOceanController::class, 'firewalls']);
Route::post('/firewall/create', [DigitalOceanController::class, 'createFirewall']);
Route::delete('/firewall/{id}', [DigitalOceanController::class, 'deleteFirewall']);

// Monitoring Alerts
Route::get('/alerts', [DigitalOceanController::class, 'alerts']);
Route::post('/alert/create', [DigitalOceanController::class, 'createAlert']);
Route::delete('/alert/{id}', [DigitalOceanController::class, 'deleteAlert']);

// Container Registry
Route::get('/container-registry', [DigitalOceanController::class, 'containerRegistry']);
Route::post('/container-registry/repository', [DigitalOceanController::class, 'createRepository']);

// Kubernetes Clusters
Route::get('/kubernetes', [DigitalOceanController::class, 'kubernetesClusters']);
Route::post('/kubernetes/create', [DigitalOceanController::class, 'createKubernetesCluster']);
Route::delete('/kubernetes/{id}', [DigitalOceanController::class, 'deleteKubernetesCluster']);

// Databases
Route::get('/databases', [DigitalOceanController::class, 'databases']);
Route::post('/database/create', [DigitalOceanController::class, 'createDatabase']);
Route::delete('/database/{id}', [DigitalOceanController::class, 'deleteDatabase']);

// Spaces (Object Storage)
Route::get('/spaces', [DigitalOceanController::class, 'spaces']);
Route::post('/space/create', [DigitalOceanController::class, 'createSpace']);
Route::delete('/space/{name}', [DigitalOceanController::class, 'deleteSpace']);

// CDN
Route::get('/cdn', [DigitalOceanController::class, 'cdn']);
Route::post('/cdn/create', [DigitalOceanController::class, 'createCDNEndpoint']);
Route::delete('/cdn/{id}', [DigitalOceanController::class, 'deleteCDNEndpoint']);

// Projects
Route::get('/projects', [DigitalOceanController::class, 'projects']);
Route::post('/project/create', [DigitalOceanController::class, 'createProject']);
Route::put('/project/{id}', [DigitalOceanController::class, 'updateProject']);
Route::delete('/project/{id}', [DigitalOceanController::class, 'deleteProject']);

// Team Management
Route::get('/team', [DigitalOceanController::class, 'teamMembers']);
Route::post('/team/invite', [DigitalOceanController::class, 'inviteTeamMember']);
Route::delete('/team/{id}', [DigitalOceanController::class, 'removeTeamMember']);

// Support Tickets
Route::get('/support', [DigitalOceanController::class, 'supportTickets']);
Route::post('/support/create', [DigitalOceanController::class, 'createSupportTicket']);