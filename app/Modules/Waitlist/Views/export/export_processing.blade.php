@if(!empty($data))
    <table class="table table-striped mb-0 w-100" id="datatable">
       @foreach ($data as $key => $value)
                    <tr>
                        @foreach($value as $k=>$v)
                            <td>{{$v}}</td>
                        @endforeach
                    </tr>
                @endforeach
            

        
    </table>
@endif