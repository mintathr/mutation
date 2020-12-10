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
    <!--<livewire:contact-create :contacts="$contacts"></livewire:contact-create>-->
    <livewire:contact-create></livewire:contact-create>
    <hr>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td scope="row">{{ $loop->iteration }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->phone }}</td>
                <td>
                    <div class="btn btn-sm btn-info text-white">Edit</div>
                    <div class="btn btn-sm btn-danger text-white">Delete</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>