@extends('layouts.app')

@section('content')
<main-component :Auth="{{\Illuminate\Support\Facades\Auth::id()}}"></main-component>
@endsection
