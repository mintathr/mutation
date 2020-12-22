<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Tambah Merchant</h3>
                </div>
                <form wire:submit.prevent="store">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Merchant</label>
                            <select name="" wire:model="bank_id" id="bank" class="form-control select2bs4" style="width: 100%;">
                                <option disabled selected>--Pilih--</option>
                                @foreach($accounts as $account)
                                <option value="{{ $account->bank_id }}">{{ $account->bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank')
                            <div class="text-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer col-mb-3">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary"><i class="far fa-edit"></i>
                                Create
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div>