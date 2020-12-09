@extends('desk-layout.main')
@section('title', 'User')
@section('subtitle', 'Data User')
@section('content')

@if (session('update'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Sukses!</h5>
    {{ session('update') }}
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data User </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Create</th>
                        <th>Aktivasi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $user->name }}
                        </td>
                        <td style="text-align: right;">
                            {{ $user->email }}
                        </td>
                        <td style="text-align: right;">
                            {{ $user->created_at }}
                        </td>
                        <td>
                            @if($user->role == '')
                            <form action="{{ $user->id }}" method="post" class="d-inline">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-xs">Not Activate</button>
                            </form>
                            @else
                            <button type="button" class="btn btn-primary btn-xs">Activate</button>
                            @endif
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection