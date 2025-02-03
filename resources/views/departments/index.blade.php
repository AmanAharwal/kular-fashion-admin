@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Departments</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create departments'))
                            <a href="{{ route('departments.create') }}" class="btn btn-primary">Add New Department</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        @canany(['edit departments', 'delete departments'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($departments as $key => $department)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $department->name }}</td>
                                            <td><img src="{{ asset($department->image) }}" width="50" height="30" 
                                                onerror="this.onerror=null; this.src='{{ asset(setting('default_department_image')) }}';" >
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{ $department->id }}"  class="update-status" data-id="{{ $department->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $department->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('department-status')}}"/>
                                                <label for="{{ $department->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit departments', 'delete departments'])
                                            <td>
                                                 @if(Auth::user()->can('edit departments'))
                                                <a href="{{ route('departments.edit', $department->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete departments'))
                                                <button data-source="Department" data-endpoint="{{ route('departments.destroy', $department->id)}}"
                                                    class="delete-btn btn btn-danger btn-sm edit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @endif
                                            </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-include-plugins :plugins="['dataTable', 'update-status' ]"></x-include-plugins>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                columnDefs: [
                    { type: 'string', targets: 1 } 
                ],
                order: [[1, 'asc']],
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-1');
                }
            });
        });
    </script>
@endsection