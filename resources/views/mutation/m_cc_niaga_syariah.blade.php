@extends('desk-layout.main')
@section('title', $bank_name)
@section('subtitle', 'Mutasi ' .$bank_name)
@section('content')

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
        <h3 class="card-title">{{ $bank_name }} </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
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
                            {{ $mutation->description }}
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($mutation->debit) }}
                        </td>
                        <td style="text-align: right;">
                            {{ number_format($mutation->credit) }}
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