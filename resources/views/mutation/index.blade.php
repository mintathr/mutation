@extends('desk-layout.main')
@section('title', 'Mutations')
@section('subtitle', 'Mutations')
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



<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_credit) }}</h3>

                    <p>SALDO KREDIT</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-up-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last {{ $last_mutasi_credit }}</a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_debit) }}</h3>

                    <p>SALDO DEBIT</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-down-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last {{ $last_mutasi_debit }}</a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_credit_month) }}</h3>

                    <p>Saldo Kredit Bulan {{ now()->format('M') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-up-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last {{ $last_mutasi_credit }}</a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_debit_month) }}</h3>

                    <p>Saldo Debit Bulan {{ now()->format('M') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-down-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last {{ $last_mutasi_debit }}</a>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Mutasi</h3>
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
                        <th>Sumber Dana</th>
                        <th>
                            Keterangan
                        </th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Tanggal</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($mutations as $mutation)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $mutation->bank->name }}
                        </td>
                        <td>
                            {{ $mutation->description }}
                        </td>
                        <td>
                            {{ $mutation->debit }}
                        </td>
                        <td>
                            {{ $mutation->credit }}
                        </td>
                        <td>
                            {{ $mutation->date }}
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection