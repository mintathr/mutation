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
</style>
<div class="container-fluid">
    <div class="row">
        @foreach($accounts as $account)
        <div class="col-md-3 justify-content-center">
            <div class="card">
                <div class="card-body">
                    <a href="/mutation/{{ Crypt::encryptString($account->bank->id) }}/{{ $account->bank->name }}"><img src="/assets-template/img/{{ $account->bank->file_img }}" class="card-img-top" alt="..."></a>
                </div>
            </div>
        </div>
        @endforeach




    </div>

</div>



@endsection