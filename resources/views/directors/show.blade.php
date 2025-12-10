@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $entity['name'] }}</h1>

    <a href="{{ route('directors.index') }}" class="btn btn-secondary">Vissza a listához</a>
    <a href="{{ route('directors.edit', $entity['id']) }}" class="btn btn-warning">Szerkesztés</a>
</div>
@endsection
