@extends('layouts.app')

@section('content')
<div class="container">
<main-component :Auth="{{\Illuminate\Support\Facades\Auth::id()}}"></main-component>
</div>
@endsection
