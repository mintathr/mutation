@extends('desk-layout.main')
@section('title', 'Banks')
@section('subtitle', 'Banks')
@section('content')

@if (session('sukses'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Sukses!</h5>
    {{ session('sukses') }}
</div>
@endif
@if (session('update'))
<div class="alert alert-info alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Sukses!</h5>
    {{ session('update') }}
</div>
@endif


<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Bank</h3>
                <div class="card-tools">
                    <a href="mutation/create" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Create</a>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Funds</th>
                                <th>Credit</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banks as $bank)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $bank->name }}
                                </td>
                                <td>
                                    {{ $bank->slug }}
                                </td>



                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection