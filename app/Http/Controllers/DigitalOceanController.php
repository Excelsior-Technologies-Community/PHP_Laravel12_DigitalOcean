<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;

class DigitalOceanController extends Controller
{

    public function regions()
    {
        // Mock data (since API requires payment)
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

    public function droplets()
    {
        $droplets = [
            (object) ['name' => 'server-1'],
            (object) ['name' => 'server-2'],
        ];

        return view('droplets', compact('droplets'));
    }

}