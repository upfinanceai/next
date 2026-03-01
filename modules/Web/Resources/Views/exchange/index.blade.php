@extends('web::layouts.app')

@section('content')
    <div class="container">
        <h3>货币兑换</h3>
        <div class="row">
            <div class="col-lg-3 col-md-4">
                @livewire(\Modules\Web\Livewire\Exchanger::class)
            </div>
        </div>
    </div>
@endsection
