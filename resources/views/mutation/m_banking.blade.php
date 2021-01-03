@extends('desk-layout.main')
@section('title', $bank->name)
@section('subtitle', 'Mutasi ' .$bank->name)
@section('content')

<style>
    .card {
        background-color: rgba(245, 245, 245, 0.4);
    }

    .card-header,
    .card-footer {
        opacity: 1
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp. {{ number_format($saldo_all) }}</h3>

                    <p>SALDO KREDIT</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-up-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last </a>
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
                <a href="#" class="small-box-footer">Last </a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_credit_month) }}</h3>

                    <p>Total Penerimaan Bulan {{ now()->format('M') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-up-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last </a>
            </div>
        </div>

        <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp. {{ number_format($cek_sum_debit_month) }}</h3>

                    <p>Total Pengeluaran Bulan {{ now()->format('M') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-arrow-down-b"></i>
                </div>
                <a href="#" class="small-box-footer">Last </a>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col">
        <div class="col-sm-6 col-md-4 float-sm-left">
            <div class="card">
                <div class="card-body">
                    <a href="/mutasi/{{ $bank->slug }}/transfer/{{ $id }}" data-toggle="tooltip" data-placement="top" title="Menu Transfer"><img src="/assets-template/img/bank_transfer.svg" class="card-img-top" alt="..."></a>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 float-left">
            <div class="card">
                <div class="card-body">
                    <a href="/mutasi/{{ $bank->slug }}/topup/{{ $id }}" data-toggle="tooltip" data-placement="top" title="Menu Top Up"><img src="/assets-template/img/terima_uang.svg" class="card-img-top" alt="bayar"></a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4 float-left">
            <div class="card">
                <div class="card-body">
                    <a href="/mutasi/{{ $bank->slug }}/bayar/{{ $id }}" data-toggle="tooltip" data-placement="top" title="Menu Bayar"><img src="/assets-template/img/pembayaran.png" class="card-img-top" alt="..."></a>
                </div>
                <!-- <div class="card-link mt-5" style="text-align: center;">Bayar</div> -->
            </div>
        </div>

        <div class="col-sm-6 col-md-4 float-left">
            <div class="card">
                <div class="card-body">
                    <a href="/mutasi/{{ $bank->slug }}/tarik/{{ $id }}" data-toggle="tooltip" data-placement="top" title="Menu Tarik Tunai"><img src="/assets-template/img/tarik_tunai.png" class="card-img-top" alt="..."></a>
                </div>
                <!-- <div class="card-link mt-5" style="text-align: center;">Bayar</div> -->
            </div>
        </div>
        <!--<div class="col-md-4 float-right">
            <div class="card">
                <div class="card-body">
                    <a href=""><img src="/assets-template/img/topup.svg" class="card-img-top" alt="..."></a>
                </div>
            </div>
        </div>-->
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"> Tabel {{ $bank->name }} </h3>
                <div class="card-tools">
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
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Credit</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mutations as $mutation)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $mutation->date }}
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