<div class="card-body">
    <div class=" mb-10">  
    @if(!empty($data['submissions']))
    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100" id="datatable">
            <thead>
                <tr>
                    <th class="align-middle">Submission ID</th>
                    <th class="align-middle">Student ID</th>
                    <th class="align-middle">Application Name</th>
                    <th class="align-middle">Student First Name</th>
                    <th class="align-middle">Student Last Name</th>
                    <th class="align-middle">Race</th>
                    <th class="align-middle">Birthday</th>
                    <th class="align-middle">Address</th>
                    <th class="align-middle">City</th>
                    <th class="align-middle">Zip Code</th>
                    <th class="align-middle">Current School</th>
                    <th class="align-middle">Current Grade</th>
                    <th class="align-middle">Next Grade</th>
                    <th class="align-middle">Special Accommodations</th>
                    <th class="align-middle">Parent First Name</th>
                    <th class="align-middle">Parent Last Name</th>
                    <th class="align-middle">Parent Email</th>
                    <th class="align-middle">Phone Number</th>
                    <th class="align-middle">Zoned School</th>
                    <th class="align-middle">Awarded School</th>
                    <th class="align-middle">First Sibling</th>
                    <th class="align-middle">Second Sibling</th>
                    <th class="align-middle">Confirmation Number</th>
                    <th class="align-middle">First Choice Program</th>
                    <th class="align-middle">Second Choice Program</th>
                    {{-- <th class="align-middle">Submission Status</th> --}}
                    <th class="align-middle">Created At</th>
            </thead>
            <tbody>
                @foreach($data['submissions'] as $key=>$value)
                    <tr id="row{{$value['submission_id']}}">
                        <td class="text-center">{{$value['id']}}</td>
                        <td>{{$value->student_id}}</td>
                        <td>{{getApplicationName($value->application_id)}}</td>
                        <td>{{$value->first_name}}</td>
                        <td>{{$value->last_name}}</td>
                        <td>{{$value->calculated_race}}</td>
                        <td>{{$value->birthday}}</td>
                        <td>{{$value->address}}</td>
                        <td>{{$value->city}}</td>
                        <td>{{$value->zipcode}}</td>
                        <td>{{$value->current_school}}</td>
                        <td>{{$value->current_grade}}</td>
                        <td>{{$value->next_grade}}</td>
                        <td>{{$value->special_accommodations}}</td>
                        <td>{{$value->parent_first_name}}</td>
                        <td>{{$value->parent_last_name}}</td>
                        <td>{{$value->parent_email}}</td>
                        <td>{{$value->phone_number}}</td>
                        <td>{{$value->zoned_school}}</td>
                        <td>{{$value->awarded_school}}</td>
                        <td>{{$value->first_sibling}}</td>
                        <td>{{$value->second_sibling}}</td>
                        <td>{{$value->confirmation_no}}</td>
                        <td>{{getProgramName($value->first_choice_program_id)}}</td>
                        <td>{{getProgramName($value->second_choice_program_id)}}</td>
                        {{-- <td>{{$value->submission_status}}</td> --}}
                        <td>{{getDateTimeFormat($value->created_at)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="table-responsive text-center"><p>No records found.</div>
    @endif
</div>