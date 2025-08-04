<div class="card shadow">
    <div class="card-header">{{$program->name}} for Current Enrollment</div>
    <input type="hidden" name="year" value="{{$enrollment->school_year ?? (date("Y")-1)."-".date("Y")}}">
	@php
		$grades = isset($program->grade_lavel) && !empty($program->grade_lavel) ? explode(',', $program->grade_lavel) : array();
	@endphp
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th class="align-middle w-10"></th>
                        <th class="align-middle w-20">Black</th>
                        <th class="align-middle w-20">White</th>
                        <th class="align-middle w-20">Other</th>
                        {{-- <th class="align-middle w-20">Not Specified</th> --}}
                    </tr>
                </thead>
                <tbody>
                	@forelse($grades as $g=>$grade)
	                    <tr>
	                        <td class="w-10">
                                Rising {{$grade}}
                                <label class="error text-danger d-none">Rising enrollment can not exceed total capacity.</label>
                            </td>
                            <td class="w-20">
                                <input type="text" class="form-control numbersOnly blackSeat" data-id="{{$grade}}"  name="grades[{{$grade}}][black_seats]" value="{{$availabilities[$grade]->black_seats ?? ""}}" @if($display_outcome > 0) disabled @endif>
                            </td>
                            <td class="w-20">
                                <input type="text" class="form-control numbersOnly whiteSeat" data-id="{{$grade}}"  name="grades[{{$grade}}][white_seats]" value="{{$availabilities[$grade]->white_seats ?? ""}}" @if($display_outcome > 0) disabled @endif>
                                {{-- <input type="text" class="form-control numbersOnly availableSeat" data-id="{{$grade}}"  name="grades[{{$grade}}][available_seats]" value="{{$availabilities[$grade]->available_seats ?? ""}}"  @if($display_outcome > 0) disabled @endif> --}}
                                
                            </td>
	                        <td class="w-20">
                                <input type="text" class="form-control numbersOnly otherSeat" data-id="{{$grade}}"  name="grades[{{$grade}}][other_seats]" value="{{$availabilities[$grade]->other_seats ?? ""}}" @if($display_outcome > 0) disabled @endif>   
                            </td>
	                        {{-- <td class="w-20">
                                <input type="text" class="form-control numbersOnly notSpecifiedSeat" data-id="{{$grade}}"  name="grades[{{$grade}}][not_specified_seats]" value="{{$availabilities[$grade]->not_specified_seats ?? ""}}">   
                            </td> --}}
	                    </tr>
	                @empty
	                    <tr>
	                     	<td class="text-center">No Grades</td>
	                    </tr>
	                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">{{$program->name}} - Total Capacity for {{$enrollment->school_year ?? (date("Y")-1)."-".date("Y")}}</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <tbody>
                	@forelse($grades as $g=>$grade)
	                    <tr>
	                        <td class="w-10">{{$grade}}</td>
	                        <td class="w-30">
	                        	<input type="text" class="form-control numbersOnly totalSeat"  name="grades[{{$grade}}][total_seats]" value="{{$availabilities[$grade]->total_seats ?? ""}}" data-id="{{$grade}}" {{-- @if($display_outcome > 0) disabled @endif --}}>
	                        </td>
	                        <td class="w-30"></td>
	                        <td class="w-30"></td>
	                    </tr>
	                @empty
	                    <tr>
	                     	<td class="text-center">No Grades</td>
	                    </tr>
	                @endforelse
                    
                </tbody>
            </table>
        </div>
        <div class="text-right"> 
            <div class="box content-header-floating" id="listFoot">
                <div class="row">
                    <div class="col-lg-12 text-right hidden-xs float-right">
                        <button type="submit" class="btn btn-warning btn-xs" title="Save" id="optionSubmit"><i class="fa fa-save"></i> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>