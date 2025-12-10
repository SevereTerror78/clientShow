@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Filmek</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($isAuthenticated)
        <a href="{{ route('films.create') }}" class="btn btn-primary mb-3">Új film hozzáadása</a>
    @endif
    <form action="{{ route('actors.index') }}" method="GET" class="mb-3">
        <input type="text" name="needle" placeholder="Keresés..." value="{{ request('needle') }}">
        <button type="submit" class="btn btn-secondary">Keresés</button>
    </form>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Cím</th>
            <th>Rendező</th>
            <th>Megjelenés</th>
            <th>Hossz</th>
            @if($isAuthenticated)
                <th>Műveletek</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($entities as $film)
        <tr>
            <td>{{ $film['title'] ?? 'N/A' }}</td>
            <td>{{ $film['director'] ?? 'N/A' }}</td>
            <td>{{ $film['release_date'] ?? 'N/A' }}</td>
            <td>{{ $film['length'] ?? 'N/A' }} perc</td>
            @if($isAuthenticated)
                <td>
                    <a href="{{ route('films.edit', $film['id']) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                    <form action="{{ route('films.destroy', $film['id']) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Biztos törlöd?')">Törlés</button>
                    </form>
                </td>
            @endif
        </tr>
        @empty
        <tr>
            <td colspan="{{ $isAuthenticated ? 6 : 5 }}" class="text-center">Nincsenek filmek</td>
        </tr>
        @endforelse
    </tbody>
</table>

</div>
@endsection
