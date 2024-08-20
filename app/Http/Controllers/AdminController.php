<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Availability;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = Category::all();

        //category filter parameter
        $selectedCategory = $request->input('category_id', null);

        // Date calculation
        $startDate = Carbon::parse($request->input('start_date', Carbon::today()));
        $endDate = $startDate->copy()->addDays(2);

        //availability based on selected category and date range
        $availabilities = Availability::whereBetween('date', [$startDate, $endDate]);

        //filter data according category
        if ($selectedCategory) {
            $availabilities->where('category_id', $selectedCategory);
        }

        $availabilities = $availabilities->orderBy('date')->orderBy('start_time')->get();

      
        return view('admin.availabilities.index', compact('availabilities', 'categories','startDate', 'endDate', 'selectedCategory'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.availabilities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'date'        => 'required|date',
            'start_time'  => 'required|date_format:H:i',
            'end_time'    => 'required|date_format:H:i|after:start_time',
            'interval'    => 'required|integer',
        ]);

        //check date time double booked time slot condition
        $checkSameTime = Availability::where('category_id', $request->category_id)
                                ->where('date', $request->date)
                                ->where(function ($query) use ($request) {
                                    $query->where(function ($query) use ($request) {
                                        $query->where('start_time', '<=', $request->start_time)
                                            ->where('end_time', '>', $request->start_time);
                                    })
                                    ->orWhere(function ($query) use ($request) {
                                        $query->where('start_time', '<', $request->end_time)
                                            ->where('end_time', '>=', $request->end_time);
                                    })
                                    ->orWhere(function ($query) use ($request) {
                                        $query->where('start_time', '>=', $request->start_time)
                                            ->where('end_time', '<=', $request->end_time);
                                    });
                                })
                                ->exists();

        if ($checkSameTime) {
            return redirect()->back()->with('message' ,'The selected time slot is already booked for this category.');
        }

        // Create availability if no conflict
        Availability::create($request->all());

        return redirect()->route('admin.availabilities')->with('success', 'Availability added successfully!');
    }
}

