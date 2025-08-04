@if(!empty($data))
    <table class="table table-striped mb-0 w-100" id="datatable">
        <thead>
            <tr>
                <th class="align-middle" rowspan="2">Submission ID</th>
                <th class="align-middle" rowspan="2">Name</th>
                <th class="align-middle" rowspan="2">Race</th>
                <th class="align-middle" colspan="3">First Program</th>
                <th class="align-middle" colspan="3">Second Program</th>
                <th class="align-middle">Lottery Number</th>

            </tr>
            <tr>
                <th class="align-middle">Name</th>
                <th class="align-middle">Commitee Score</th>
                <th class="align-middle">Priority</th>
                <th class="align-middle">Name</th>
                <th class="align-middle">Commitee Score</th>
                <th class="align-middle">Priority</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key=>$value)
                <tr>
                    <td class="text-left">{{$value['id']}}</td>
                    <td class="align-middle">{{$value['name']}}</td>
                    <td class="">{{$value['race']}}</td>
                    <td class="">{{$value['first_program']}}</td>
                    <td class="text-center">{{$value['first_commitee']}}</td>
                    <td class="">{{$value['first_priority']}}</td>
                    <td class="">{{$value['second_program']}}</td>
                    <td class="text-center">{{$value['second_commitee']}}</td>
                    <td class="">{{$value['second_priority']}}</td>
                    <td class="text-center">{{$value['lottery_number']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif