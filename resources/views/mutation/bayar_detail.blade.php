@extends('desk-layout.main')
@section('title', 'Bayar Dari ' .$id_account->name)
@section('subtitle', 'Pembayaran Dari ' .$id_account->name)
@section('content')

<section class="content">
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">Form Pembayaran</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
            </div>
        </div>
        <form role="form" method="post" action="/mutasi/bayar" enctype="multipart/form-data">
            @csrf
            <input type="text" name="user_id" value="{{ Auth::user()->id }}">
            <input type="text" name="account_id" value="{{ $id_account->id }}">
            <input type="text" name="bank_name" value="{{ $id_account->name }}">
            <input type="text" name="slug" value="{{ $id_account->slug }}">
            <input type="text" name="id" value="{{ $id }}">
            <input type="text" name="nominal_credit" value="0">
            <div class="card-body">

                <div class="form-group">
                    <label for="debit">Nominal</label>
                    <input type="text" name="debit" id="nominal_debit" class="form-control @error('debit') is-invalid @enderror" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Nominal" value="{{ old('debit') }}">
                    @error('debit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date">tgl transaksi</label>
                    <input type="text" name="date" id="date" class="form-control date @error('date') is-invalid @enderror" date="" data-date-format="yyyy-mm-dd" placeholder="YYYY-MM-DD" value="{{ old('date') }}">
                    @error('date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" oninput="this.value=this.value.replace(/[^A-Za-z0-9 ]/g,'');" placeholder="Keterangan" value="{{ old('description') }}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <!-- /.card-body -->
            <!-- /.card -->
            <div class="card-footer col-mb-3">
                <div class="float-left">
                    <button onclick="window.location.href='{{ url()->previous() }}';" type="button" class="btn btn-info"><i class="fa fa-arrow-left"></i>
                        Back
                    </button>
                </div>
                <div class="float-right">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmation-modal"><i class="far fa-edit"></i>
                        Send
                    </button>
                </div>

                <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center font-18">
                                <h4 class="padding-top-30 mb-30 weight-500">yakin bayar?</h4>
                                <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto;">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal"><i class="fa fa-times"></i></button>
                                        Tidak
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary border-radius-100 btn-block confirmation-btn"><i class="fa fa-check"></i></button>
                                        Ya
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>



@endsection