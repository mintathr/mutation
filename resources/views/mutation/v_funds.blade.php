@extends('desk-layout.main')
@section('title', 'List Funds')
@section('subtitle', 'List Funds')
@section('content')
<style>
    .card {
        background-color: rgba(245, 245, 245, 0.4);
    }

    .card-header,
    .card-footer {
        opacity: 1
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 20%;
    }
</style>
<div class="container-fluid">
    <div class="row">
        @foreach($accounts as $account)
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <a href="/mutation/{{ Crypt::encryptString($account->id) }}/{{ $account->bank->slug }}"><img src="/storage/{{ $account->bank->file_img }}" class="center" style="width: 150px; height: 100px;"></a>
                </div>
                <div class="card-footer">{{ $account->no_rekening }} - {{ $account->name_account }}
                </div>

            </div>
        </div>

        @endforeach

    </div>

</div>



@endsection