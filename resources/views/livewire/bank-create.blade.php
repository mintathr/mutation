<div>
    <!-- <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true" x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false" x-on:livewire-upload-progress="progress = $event.detail.progress"> -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Tambah Merchant</h3>
                </div>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Merchant</label>
                            <input wire:model="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="file_img">Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" wire:model="file_img" class="custom-file-input @error('name') is-invalid @enderror">
                                    <label class="custom-file-label">Upload</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                                @error('file_img')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div wire:loading wire:target="file_img" class="text-sm text-gray-500 italic">Uploading...</div>
                            <!---- Progess Bar ---->
                            <!-- <div x-show="isUPloading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div> -->
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