<?php

// app/Http/Controllers/DailyQuotesController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DailyQuotesController extends Controller
{
    public function index()
    {
        return inertia('DailyQuotes');
    }
}
