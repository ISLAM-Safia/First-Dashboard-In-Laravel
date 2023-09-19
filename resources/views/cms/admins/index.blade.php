@extends('cms.parent')

@section('page-title','Dashboard')

@section('lg-title','Larage')
@section('main-title','Main')
@section('sm-title','Small')

@section('styles')

@endsection

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Bordered Table</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Role</th>
                                    <th>Active</th>
                                    <th style="width: 20%">Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                <tr id="admin_{{$admin->id}}_row">
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td>{{$admin->gender_key}}</td>
                                    <td>{{$admin->roles[0]->name}}</td>
                                    {{-- <td><span
                                            class="badge @if($admin->active) bg-success @else bg-danger @endif">@if($admin->active)
                                            Active @else In-Active @endif</span> --}}
                                    <td>
                                        <span
                                            class="badge @if($admin->active) bg-success @else bg-danger @endif">{{$admin->active_key}}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('admins.edit',$admin->id)}}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" onclick="confirmDelete('{{$admin->id}}')"
                                                class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    performDelete(id);
                }
        })
    }
    function performDelete(id) {
        axios.delete('/cms/admin/admins/'+id)
        .then(function (response) {
            // handle success
            console.log(response);
            // toastr.success(response.data.message);
            showSwalMessage(response.data);
            // document.getElementById('admin_'+id+'_row').remove();
        })
        .catch(function (error) {
            // handle error 4xx - 5xx
            console.log(error);
            // toastr.error(error.response.data.message);
            showSwalMessage(error.response.data);
        })
        .then(function () {
            // always executed
        });
    }

    function showSwalMessage(data) {
        Swal.fire(
            data.title,
            data.message,
            data.icon,
        )
    }
</script>
@endsection