@extends('desk-layout.main')
@section('title', 'Create' .{{ $tes }})
@section('subtitle', 'Create Mutasi')
@section('content')

<section class="content">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Mutasi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
            </div>
        </div>
        <form role="form" method="post" action="/mutation" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="card-body">
                <div class="form-group">
                    <label>Sumber Dana</label>
                    <select name="bank" id="bank" class="form-control">
                        <option disabled selected>--Pilih--</option>
                        @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                    @error('bank')
                    <div class="text-danger mt-2">
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
                <div class="form-group">
                    <label for="debit">Debit</label>
                    <input type="text" name="debit" id="nominal_debit" class="form-control @error('debit') is-invalid @enderror" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Debit" value="{{ old('debit') }}">
                    @error('debit')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="credit">Kredit</label>
                    <input type="text" name="credit" id="nominal_credit" class="form-control @error('credit') is-invalid @enderror" oninput="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="credit" value="{{ old('credit') }}">
                    @error('credit')
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
                <p style="color:red"><i>* bila pemasukan kolom kredit diisi dengan angka 0
                        <br>
                        * bila pengeluaran kolom debit diisi dengan angka 0</i></p>

            </div>

            <!-- /.card-body -->
            <!-- /.card -->
            <div class="card-footer col-mb-3">
                <div class="float-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmation-modal"><i class="far fa-edit"></i>
                        Create Mutasi
                    </button>
                </div>

                <div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body text-center font-18">
                                <h4 class="padding-top-30 mb-30 weight-500">Anda yakin create mutasi?</h4>
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