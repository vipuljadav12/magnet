@extends('layouts.admin.app')
@section('title')Program Master  | {{config('APP_NAME',env("APP_NAME"))}}  @endsection
@section('content')
    <div class="card shadow">
        <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
            <div class="page-title mt-5 mb-5">Program Master</div>
            <div class="">
                <a href="{{url('admin/Program/create')}}" class="btn btn-sm btn-secondary" title="Add">Add Program</a>
                <a href="{{url('admin/Program/trash')}}" class="btn btn-sm btn-danger" title="Trash">Trash</a>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            @include("layouts.admin.common.alerts")
            <div class="table-responsive">
                <table id="datatable" class="table table-striped mb-0">
                    <thead>
                    <tr>
                        <th class="align-middle">Program Name</th>
                        <th class="align-middle">Available Grades</th>
                        <th class="align-middle">Parent Submission Form</th>
                        <th class="align-middle">Ranking System</th>
                        <th class="align-middle">Selection Method</th>
                        <th class="align-middle">Select Priority</th>
                        <th class="align-middle text-center">Status</th>
                        <th class="align-middle text-center w-90">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($programs as $key=>$program)
                        <tr>
                            <td class="">{{$program->name}}</td>
                            <td class="">{{$program->grade_lavel}}</td>
                            <td class="">{{findFormName($program->parent_submission_form)}}</td>
                            <td class="">{!! getRankingMethod($program) !!}</td>
                            <td class="">{{str_replace(" Only", "", $program->selection_method)}} ({{str_replace(" Entry", "", $program->seat_availability_enter_by)}})</td>
                            <td class="">@if($program->priority=='none') none @else {{getPriority($program->priority)}} @endif</td>
                            <td class="text-center"><input id="{{$program->id}}" type="checkbox" class="js-switch js-switch-1 js-switch-xs status" data-size="Small" checked /></td>
                            <td class="text-center">
                                <a href="{{url('admin/Program/edit',$program->id)}}" class="font-18 ml-5 mr-5" title="Edit"><i class="far fa-edit"></i></a>
                                <a href="javascript:void(0);" onclick="deletefunction({{$program->id}})" class="font-18 ml-5 mr-5 text-danger" title="Delete" ><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").delay(2000).fadeOut(1000);
            $('#datatable').DataTable({
                'columnDefs': [ {
                    'targets': [6,7], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }]
            });
            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'colvis'],
            });
            table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        });
        $('.status').change(function() {
            var click=$(this).prop('checked')==true ? 'Y' : 'N' ;
            $.ajax({
                type: "get",
                url: '{{url('admin/Program/status')}}',
                data: {
                    id:$(this).attr('id'),
                    status:click
                },
                complete: function(data) {
                    console.log('success');
                }
            });
        });
        var deletefunction = function(id){
            swal({
                title: "Are you sure you would like to delete this Program ?",
                text: "",
                // type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }).then(function() {
                window.location.href = '{{url('/')}}/admin/Program/delete/'+id;
            });
        };
    </script>
@endsection