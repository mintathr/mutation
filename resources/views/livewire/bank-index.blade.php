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
    <livewire:bank-create></livewire:bank-create>

    <div class="row">
        <div class="card col-lg-6">
            <div class="card-header">
                <h3 class="card-title">List Bank</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <select wire:model="paginate" name="" id="" class="form-control form-control-sm w-auto">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="text" wire:model="search" name="" id="" class="form-control form-control-sm" placeholder="Search">

                    </div>
                </div>
                <div class="mb-3"></div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banks as $bank)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $bank->name }}</td>
                            <td><img src="/storage/{{ $bank->file_img }}" style="width: 50px;height:50px;"></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 offset md-4">
                {{ $banks->links('link_pagination') }}
            </div>
        </div>
    </div>
</div>