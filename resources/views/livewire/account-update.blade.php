<div>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Rekening</h3>
        </div>
        <form wire:submit.prevent="update">
            <input wire:model="accountId" type="hidden" class="form-control">

            <div class="card-body">
                <div class="form-group">
                    <label>Nama Account</label>
                    <select name="" wire:model="bank_id" id="bank" class="form-control" style="width: 100%;">
                        <option value="">--Pilih--</option>
                        @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                    @error('bank_id')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kategori Rekening</label>
                    <div class="form-check">
                        <input class="form-check-input @error('flag') is-invalid @enderror" type="radio" wire:model="flag" name="flag" value="Pribadi" checked>
                        <label class="form-check-label">Rek Pribadi</label> <br>
                        <input class="form-check-input @error('flag') is-invalid @enderror" type="radio" name="flag" value="Others">
                        <label class="form-check-label">Rek Others</label>
                    </div>
                    @error('flag')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nomor Rekening</label>
                    <input type="text" wire:model="no_rekening" class="form-control @error('no_rekening') is-invalid @enderror" placeholder="Nomor Rekening">
                    @error('no_rekening')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Pemilik Rekening</label>
                    <input type="text" wire:model="name_account" class="form-control @error('name_account') is-invalid @enderror" placeholder="Nomor Rekening">
                    @error('name_account')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" wire:model="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan">
                    @error('keterangan')
                    <div class="text-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="card-footer col-mb-3">
                <div class="float-right">
                    <button type="submit" class="btn btn-info"><i class="far fa-edit"></i>
                        Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>