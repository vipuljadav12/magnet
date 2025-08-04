@if(isset($data['student']))
    @php
        $grades = [ 'PreK', 'K', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12' ];
    @endphp
    <form method="post" id="frm_student_search" action="{{url($module_url)}}/data/update">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$data['student']->stateID}}">
        <div class="row">
            <div class="form-group col-6">
                <label class="control-label">First Name : </label>
                <div class=""><input type="text" class="form-control" maxlength="100" name="first_name" value="{{$data['student']->first_name}}" id="first_name"></div>
            </div>
            <div class="form-group col-6">
                <label class="control-label">Last Name : </label>
                <div class=""><input type="text" class="form-control" maxlength="100" name="last_name" id="last_name" value="{{$data['student']->last_name}}"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label class="control-label">Current Grade : </label>
                <div class="">
                    <select class="form-control" name="current_grade" id="current_grade">
                        <option value="">Select Grade</option>
                        @foreach($grades as $grade)
                            <option @if($data['student']->current_grade == $grade) selected @endif>{{$grade}}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" class="form-control" maxlength="10" name="current_grade" value="{{$data['student']->current_grade}}"> --}}
                </div>
            </div>
            <div class="form-group col-6">
                <label class="control-label">Birth Day : </label>
                <div class=""><input type="text" class="form-control" id="birthday" maxlength="20" name="birthday" value="{{getDateFormat($data['student']->birthday)}}"></div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6">
                <label class="control-label">Address : </label>
                <div class="">
                    <textarea class="form-control" maxlength="255" name="address" id="address">{{$data['student']->address}}</textarea>
                    {{-- <input type="text" class="form-control" maxlength="255" name="address" value="{{$data['student']->address}}"> --}}
                </div>
            </div>
            <div class="form-group col-6">
                <label class="control-label">City : </label>
                <div class=""><input type="text" class="form-control" maxlength="100" name="city" id="city" value="{{$data['student']->city}}"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label class="control-label">Zip : </label>
                <div class=""><input type="text" class="form-control" maxlength="20" name="zip" id="zip" value="{{$data['student']->zip}}"></div>
            </div>
            <div class="form-group col-6">
                <label class="control-label">Race : </label>
                <div class="">

                    <select name="race" class="form-control">
                        <option value="African-American - Non-Hispanic" @if($data['student']->race == "African-American - Non-Hispanic") selected @endif>African-American - Non-Hispanic</option>
                        <option value="African-American - Hispanic" @if($data['student']->race == "African-American - Hispanic") selected @endif>African-American - Hispanic</option>
                        <option value="Caucasian - Non-Hispanic" @if($data['student']->race == "Caucasian - Non-Hispanic") selected @endif>Caucasian - Non-Hispanic</option>
                        <option value="Caucasian - Hispanic" @if($data['student']->race == "Caucasian - Hispanic") selected @endif>Caucasian - Hispanic</option>
                        <option value="Hispanic - Hispanic" @if($data['student']->race == "Hispanic - Hispanic") selected @endif>Hispanic - Hispanic</option>
                        <option value="Two or More Races - Hispanic" @if($data['student']->race == "Two or More Races - Hispanic") selected @endif>Two or More Races - Hispanic</option>
                        <option value="Two or More Races - Non-Hispanic" @if($data['student']->race == "Two or More Races - Non-Hispanic") selected @endif>Two or More Races - Non-Hispanic</option>
                        <option value="American Indian - Hispanic" @if($data['student']->race == "American Indian - Hispanic") selected @endif>American Indian - Hispanic</option>
                        <option value="Asian - Hispanic" @if($data['student']->race == "Asian - Hispanic") selected @endif>Asian - Hispanic</option>
                        <option value="Asian - Non-Hispanic" @if($data['student']->race == "Asian - Non-Hispanic") selected @endif>Asian - Non-Hispanic</option>
                        <option value="American Indian - Non-Hispanic" @if($data['student']->race == "American Indian - Non-Hispanic") selected @endif>American Indian - Non-Hispanic</option>
                        <option value="Pacific Islander - Non-Hispanic" @if($data['student']->race == "Pacific Islander - Non-Hispanic") selected @endif>Pacific Islander - Non-Hispanic</option>
                        <option value="Pacific Islander - Hispanic" @if($data['student']->race == "Pacific Islander - Hispanic") selected @endif>Pacific Islander - Hispanic</option>
                        <option value="Hispanic - Non-Hispanic" @if($data['student']->race == "Hispanic - Non-Hispanic") selected @endif>Hispanic - Non-Hispanic</option>
                        <option value="Other - Non-Hispanic" @if($data['student']->race == "Other - Non-Hispanic") selected @endif>Other - Non-Hispanic</option>

                    </select>
                    
            </div>
        </div>
    </div>
    </form>
    <div class="" align="right">
        <button class="btn btn-success s_save">Save <div class="spnr spinner-border spinner-border-sm d-none"></button>
    </div>
@else
    <div class="" align="center">Data not found..</div>
@endif