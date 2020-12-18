<div>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Form Contact</h3>

        </div>
        <form wire:submit.prevent="update">
            <input wire:model="contactId" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                    @error('name')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input wire:model="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone">
                    @error('phone')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="card-footer col-mb-3">
                <div class="float-right">
                    <button type="submit" class="btn btn-primary"><i class="far fa-edit"></i>
                        Update
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>