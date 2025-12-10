@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Új rendező létrehozása</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('directors.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Mentés</button>
        <a href="{{ route('directors.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
</div>
@endsection
