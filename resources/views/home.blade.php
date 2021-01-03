@extends('desk-layout.main')
@section('title', 'Home')
@section('subtitle', 'Home')
@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-4 col-12">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp. {{ number_format($cek_sum_credit_today) }}</h3>
                <p>SUM KREDIT</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-4 col-12">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp. {{ number_format($cek_sum_debit_today) }}</h3>

                <p>SUM DEBIT</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mutasi Hari Ini {{ date('d-M-Y', strtotime(now())) }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Sumber</th>
                                <th>Keterangan</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mutations as $mutation)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $mutation->name }}
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