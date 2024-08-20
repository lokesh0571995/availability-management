<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;


class AvailabilityController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = Category::all();

        //filter parameter
        $selectedCategory = $request->input('category_id', null);

        // Date calculation
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()));
        $endDate   = $startDate->copy()->addDays(2);

        //availability based on selected category and date range
        $availabilities = Availability::whereBetween('date', [$startDate, $endDate]);

        //filter data according category
        if ($selectedCategory) {
            $availabilities->where('category_id', $selectedCategory);
        }

        $availabilities = $availabilities->orderBy('date')->orderBy('start_time')->get();

      
        return view('availabilities.index', compact('availabilities', 'categories','startDate', 'endDate', 'selectedCategory'));
    }
}

