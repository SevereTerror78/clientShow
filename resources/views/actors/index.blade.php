@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Színészek</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($isAuthenticated)
        <a href="{{ route('actors.create') }}" class="btn btn-primary">Új színész</a>


    @endif

    <form action="{{ route('actors.index') }}" method="GET" class="mb-3">
        <input type="text" name="needle" placeholder="Keresés..." value="{{ request('needle') }}">
        <button type="submit" class="btn btn-secondary">Keresés</button>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Név</th>
                <th>Kép</th>
                @if($isAuthenticated)
                    <th>Műveletek</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($entities as $actor)
                <tr>
                    <td>{{ $actor['name'] ?? 'N/A' }}</td>
                    @if($isAuthenticated)
                        <td>
                            <a href="{{ route('actors.edit', $actor['id']) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                            <form action="{{ route('actors.destroy', $actor['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törlöd a színészt?')">Törlés</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $isAuthenticated ? 3 : 2 }}" class="text-center">Nincsenek színészek</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
