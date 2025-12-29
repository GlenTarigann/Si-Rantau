<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\MealPlan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $prayerSchedule = [
            'Subuh' => '04:45',
            'Dzuhur' => '11:58',
            'Ashar' => '15:20',
            'Maghrib' => '17:55',
            'Isya' => '19:10',
        ];

        $agendas = [
            ['title' => 'Rapat Divisi', 'time' => '2025-12-28 10:00'],
            ['title' => 'Jogging Pagi', 'time' => '2025-12-29 06:00'],
        ];

        return view('dashboard', compact( 'prayerSchedule', 'agendas'));
    }
}