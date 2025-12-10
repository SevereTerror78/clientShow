@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rendező szerkesztése: {{ $director['name'] ?? '' }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('directors.update', $director['id']) }}" method="POST">
        @csrf
        @method('PATCH') {{-- vagy PUT, ahogy a controllerben van --}}

        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $director['name'] ?? '') }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Mentés</button>
        <a href="{{ route('directors.index') }}" class="btn btn-secondary">Mégse</a>
    </form>
</div>
@endsection
