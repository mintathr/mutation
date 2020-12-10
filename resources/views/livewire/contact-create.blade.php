<div>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Form Contact</h3>

        </div>
        <form wire:submit.prevent="store">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input wire:model="name" type="text" class="form-control" placeholder="Name">

                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input wire:model="phone" type="text" class="form-control" placeholder="Phone">
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