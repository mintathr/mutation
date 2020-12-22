<div>
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
    <livewire:account-create></livewire:account-create>

    <div class="row">
        <div class="card col-lg-6">
            <div class="card-header">
                <h3 class="card-title">Account</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                    </div>
                    <div class="col">

                    </div>
                </div>
                <div class="mb-3"></div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Merchant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $account)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $account->bank->name }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 offset md-4">

            </div>
        </div>
    </div>
</div>