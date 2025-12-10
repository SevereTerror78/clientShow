@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Film szerkesztése: {{ $film['title'] }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('films.update', $film['id']) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="title" class="form-label">Cím</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $film['title'] }}" required>
        </div>

        <div class="mb-3">
            <label for="director_id" class="form-label">Rendező ID</label>
            <input type="number" name="director_id" id="director_id" class="form-control" value="{{ $film['director_id'] }}" required>
        </div>

        <div class="mb-3">
            <label for="release_date" class="form-label">Megjelenés</label>
            <input type="date" name="release_date" id="release_date" class="form-control" value="{{ $film['release_date'] }}" required>
        </div>

        <div class="mb-3">
            <label for="length" class="form-label">Hossz (perc)</label>
            <input type="number" name="length" id="length" class="form-control" value="{{ $film['length'] }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Leírás</label>
            <textarea name="description" id="description" class="form-control">{{ $film['description'] }}</textarea>
        </div>

        <button class="btn btn-success">Mentés</button>
        <a href="{{ route('films.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
</div>
@endsection
