<div>
    @if (session('sukses'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-check"></i> Sukses!</h5>
        {{ session('sukses') }}
    </div>
    @endif
    @if (session('gagal'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fas fa-info"></i> Gagal!</h5>
        {{ session('gagal') }}
    </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            @if($statusUpdate)
            <livewire:account-update></livewire:account-update>
            @else
            <livewire:account-create></livewire:account-create>
            @endif
        </div>
        <div class="col-lg-8">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Tabel Rekening</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="mb-3"></div>
                    <div class="table-responsive">
                        <table class="table" id="example1">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Merchant</th>
                                    <th scope="col">Rekening</th>
                                    <th scope="col">Nama Pemilik</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accounts as $account)
                                <tr>
                                    <td scope="row">{{ $loop->iteration }}</td>
                                    <td>{{ $account->bank->name }}</td>
                                    <td>{{ $account->no_rekening }}</td>
                                    <td>{{ $account->name_account }}</td>
                                    <td>{{ $account->flag }}</td>
                                    <td>{{ $account->keterangan }}</td>
                                    <td>
                                        <button wire:click="getAccount({{ $account->id }})" class="btn btn-sm btn-info text-white"><i class="far fa-edit"></i> Edit</button>
                                        <button wire:click="destroy({{ $account->id }})" class="btn btn-sm btn-danger text-white"><i class="far fa-trash-alt"></i> Delete</button>
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


</div>