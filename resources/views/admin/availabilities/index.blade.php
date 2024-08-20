@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="text-center mb-4">Availabilities List</h1>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

           

            <div class="mb-4 text-center">
                <a href="{{ url('/admin/availabilities/create') }}" class="btn btn-primary">Add New Availability</a>
            </div>

            <!-- Category Filter -->
            <form method="GET" action="{{ url('/admin/availabilities') }}">
                <select name="category_id" onchange="this.form.submit()">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Date Navigation -->
            <div style="text-align: center; margin: 20px;">
                <a href="{{ url('/admin/availabilities?start_date=' . $startDate->copy()->subDays(3)->format('Y-m-d') . '&end_date=' . $startDate->copy()->subDays(1)->format('Y-m-d') . '&category_id=' . $selectedCategory) }}" style="text-decoration: none; color: #007bff;">&#8249; Prev</a>
                
                <span style="margin: 0 20px; font-weight: bold;">
                    @foreach (range(0, 2) as $i)
                        {{ $startDate->copy()->addDays($i)->format('D M d') }}{{ $i < 2 ? ' - ' : '' }}
                    @endforeach
                </span>
                
                <a href="{{ url('/admin/availabilities?start_date=' . $endDate->copy()->addDay()->format('Y-m-d') . '&end_date=' . $endDate->copy()->addDays(2)->format('Y-m-d') . '&category_id=' . $selectedCategory) }}" style="text-decoration: none; color: #007bff;">Next &#8250;</a>
            </div>

            <!-- Availability Grid -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>{{ $startDate->format('D M d') }}</th>
                        <th>{{ $startDate->copy()->addDay()->format('D M d') }}</th>
                        <th>{{ $startDate->copy()->addDays(2)->format('D M d') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $timeSlots = [];
                        foreach($availabilities as $availability) {
                            $timeSlots[$availability->start_time][] = $availability;
                        }
                    @endphp
                   
                    @if($timeSlots)
                    @foreach($timeSlots as $time => $slots)
                        @php
                            $slots = collect($slots);
                        @endphp
                        <tr>
                            @for($i = 0; $i < 3; $i++)
                                @php
                                    $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                                    $slot = $slots->firstWhere('date', $date);
                                @endphp
                                <td>{{ $slot ? $slot->start_time . ' - ' . $slot->end_time : '--' }}</td>
                            @endfor
                        </tr>
                   
                    @endforeach
                    @else
                    <tr><td class="text-center" colspan="3">No Data Available</td></tr>
                    @endif   

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
