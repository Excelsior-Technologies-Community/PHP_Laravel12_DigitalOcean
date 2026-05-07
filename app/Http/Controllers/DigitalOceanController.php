<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DigitalOceanController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'regions' => 4,
            'droplets' => 4,
            'running' => 2,
            'memory' => '8GB',
        ];

        return view('dashboard', compact('stats'));
    }

    public function regions()
    {
        $regions = [
            (object) ['name' => 'New York'],
            (object) ['name' => 'London'],
            (object) ['name' => 'Singapore'],
            (object) ['name' => 'Frankfurt'],
        ];

        return view('regions', compact('regions'));
    }

    public function sizes()
    {
        $sizes = [
            (object) ['slug' => 's-1vcpu-1gb', 'memory' => '1024MB'],
            (object) ['slug' => 's-1vcpu-2gb', 'memory' => '2048MB'],
            (object) ['slug' => 's-2vcpu-2gb', 'memory' => '4096MB'],
        ];

        return view('sizes', compact('sizes'));
    }

    public function droplets(Request $request)
    {
        $droplets = collect([

            (object)[
                'name' => 'server-1',
                'region' => 'New York',
                'ip' => '192.168.1.1',
                'status' => 'Running',
                'created' => '2026-05-01'
            ],

            (object)[
                'name' => 'server-2',
                'region' => 'London',
                'ip' => '192.168.1.2',
                'status' => 'Stopped',
                'created' => '2026-05-03'
            ],

            (object)[
                'name' => 'server-3',
                'region' => 'Singapore',
                'ip' => '192.168.1.3',
                'status' => 'Maintenance',
                'created' => '2026-05-06'
            ],

            (object)[
                'name' => 'server-4',
                'region' => 'Frankfurt',
                'ip' => '192.168.1.4',
                'status' => 'Running',
                'created' => '2026-05-07'
            ],

        ]);

        // SEARCH BY NAME

        if ($request->search) {

            $droplets = $droplets->filter(function ($droplet) use ($request) {

                return str_contains(
                    strtolower($droplet->name),
                    strtolower($request->search)
                );

            });

        }

        // FILTER REGION

        if ($request->region) {

            $droplets = $droplets->where('region', $request->region);

        }

        // FILTER STATUS

        if ($request->status) {

            $droplets = $droplets->where('status', $request->status);

        }

        return view('droplets', compact('droplets'));
    }
}