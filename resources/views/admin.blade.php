@extends('layouts.app')

@section('content')
    <div class="container">
        <admin :user="{{auth()->user()}}"></admin>
    </div>
@endsection
