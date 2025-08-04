@if(!empty($data))
    <table class="table table-striped mb-0 w-100" id="datatable">
        <thead>
            <tr>
                <th class="align-middle" rowspan="2">Program Name</th>
                <th class="align-middle" rowspan="2">Initial Availability</th>
                <th class="align-middle" colspan="3">Withdrawn</th>
                <th class="align-middle" rowspan="2">Offered</th>
                <th class="align-middle" rowspan="2">Additional Seats</th>
                <th class="align-middle" rowspan="2">Waitlisted</th>
                <th class="align-middle" rowspan="2">Total Available</th>

            </tr>
            <tr>
                    <th class="align-middle">Black</th>
                     <th class="align-middle">White</th>
                     <th class="align-middle">Other</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key=>$value)
                <tr>
                    <td class="text-left">{{$value['name'] ." - Grade ".$value['grade']}}</td>
                    <td class="align-middle">{{$value['available_seats']}}</td>
                    <td class="">{{$value['black_withdrawn']}}</td>
                    <td class="">{{$value['white_withdrawn']}}</td>
                    <td class="">{{$value['other_withdrawn']}}</td>
                    <td class="text-center">{{$value['offered']}}</td>
                    <td class="text-center">{{$value['additional_seats']}}</td>
                    <td class="text-center">{{$value['waitlist_count']}}</td>
                    <td class="text-center">{{$value['total_available']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif