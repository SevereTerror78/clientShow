@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rendezők</h1>

    {{-- Success / Error messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add new button only if logged in --}}
    @if($isAuthenticated)
    <a href="{{ route('directors.create') }}" class="btn btn-primary mb-3">Új rendező hozzáadása</a>
    @endif

    {{-- Search form --}}
    <form action="{{ route('directors.index') }}" method="GET" class="mb-3">
        <input type="text" name="needle" placeholder="Keresés..." value="{{ request('needle') }}">
        <button type="submit" class="btn btn-secondary">Keresés</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Létrehozva</th>
                <th>Frissítve</th>
                @if($isAuthenticated)
                    <th>Műveletek</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($entities as $director)
            <tr>
                <td>{{ $director['id'] ?? 'N/A' }}</td>
                <td>{{ $director['name'] ?? 'N/A' }}</td>
                <td>{{ $director['created_at'] ?? 'N/A' }}</td>
                <td>{{ $director['updated_at'] ?? 'N/A' }}</td>
                @if($isAuthenticated)
                    <td>
                        <a href="{{ route('directors.edit', $director['id']) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                        <form action="{{ route('directors.destroy', $director['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Biztos törlöd?')">Törlés</button>
                        </form>
                    </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ $isAuthenticated ? 5 : 4 }}" class="text-center">Nincsenek rendezők</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
