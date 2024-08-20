<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Availabilities List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .date-nav a {
            text-decoration: none;
            color: #007bff;
        }
        .date-nav a:hover {
            text-decoration: underline;
        }
        .availability-table td {
            text-align: center;
        }
        .availability-table th {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center mb-4">Availabilities List</h1>

                <!-- Date Navigation -->
                <div class="date-nav text-center mb-4">
                    <a href="{{ url('/availabilities?start_date=' . $startDate->copy()->subDays(3)->format('Y-m-d') . '&end_date=' . $startDate->copy()->subDays(1)->format('Y-m-d') . '&category_id=' . $selectedCategory) }}" class="mr-4">&#8249; Prev</a>
                    
                    <span class="font-weight-bold">
                        @foreach (range(0, 2) as $i)
                            {{ $startDate->copy()->addDays($i)->format('D M d') }}{{ $i < 2 ? ' - ' : '' }}
                        @endforeach
                    </span>
                    
                    <a href="{{ url('/availabilities?start_date=' . $endDate->copy()->addDay()->format('Y-m-d') . '&end_date=' . $endDate->copy()->addDays(2)->format('Y-m-d') . '&category_id=' . $selectedCategory) }}" class="ml-4">Next &#8250;</a>
                </div>

                <!-- Availability Grid -->
                <table class="table table-bordered availability-table">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
