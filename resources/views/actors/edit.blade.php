@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Színész szerkesztése</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actors.update', $entity['id']) }}" method="POST">
        @csrf
        @method('PATCH') 

        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $entity['name'] }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mentés</button>
        <a href="{{ route('actors.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
</div>
@endsection
