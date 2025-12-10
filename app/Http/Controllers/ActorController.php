<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ActorController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = session('api_token');
    }

    // Színészek listázása
    public function index(Request $request)
    {
        $needle = $request->get('needle');

        try {
            $url = $needle ? "actors?needle=" . urlencode($needle) : "actors";
            $response = Http::api()->get($url);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Hiba történt a színészek lekérdezésekor.';
                return redirect()->route('actors.index')->with('error', $message);
            }

            $actors = $response->json()['actors'] ?? [];

            return view('actors.index', [
                'entities' => $actors,
                'isAuthenticated' => $this->token !== null,
            ]);

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', "Nem sikerült betölteni a színészeket: " . $e->getMessage());
        }
    }

    // Egy színész adatainak megtekintése
    public function show($id)
    {
        try {
            $response = Http::api()->get("/actors/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'A színész nem található.';
                return redirect()->route('actors.index')->with('error', $message);
            }

            $actor = $response->json()['actor'] ?? null;

            if (!$actor) {
                return redirect()->route('actors.index')
                    ->with('error', "A színész adatai nem érhetők el.");
            }

            return view('actors.show', ['entity' => $actor]);

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', "Nem sikerült betölteni a színész adatait: " . $e->getMessage());
        }
    }

    // Új színész létrehozása (form)
    public function create()
    {
        return view('actors.create');
    }


    // Új színész mentése
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $response = Http::api()->withToken($this->token)->post('/actors', [
                'name' => $request->name,
            ]);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Nem sikerült létrehozni a színészt.';
                return redirect()->route('actors.index')->with('error', $message);
            }

            return redirect()->route('actors.index')
                ->with('success', "{$request->name} színész sikeresen létrehozva!");

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }



    // Színész szerkesztése (form)
    public function edit($id)
    {
        try {
            $response = Http::api()->get("/actors");
            if ($response->failed()) {
                return redirect()->route('actors.index')
                    ->with('error', 'Nem sikerült lekérni a színészeket.');
            }

            $actors = $response->json()['actors'] ?? [];
            $actor = collect($actors)->firstWhere('id', (int)$id);

            if (!$actor) {
                return redirect()->route('actors.index')
                    ->with('error', 'A színész nem található.');
            }

            return view('actors.edit', ['entity' => $actor]);

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', 'API hiba: ' . $e->getMessage());
        }
    }

    // Színész frissítése
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $response = Http::api()->withToken($this->token)->patch("/actors/$id", [
                'name' => $request->name,
            ]);

            if ($response->successful()) {
                return redirect()->route('actors.index')
                    ->with('success', "{$request->name} színész sikeresen frissítve!");
            }

            $message = $response->json('message') ?? 'Ismeretlen hiba.';
            return redirect()->route('actors.index')->with('error', $message);

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', 'API hiba: ' . $e->getMessage());
        }
    }

    // Színész törlése
    public function destroy($id)
    {
        try {
            $response = Http::api()->withToken($this->token)->delete("/actors/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Nem sikerült törölni a színészt.';
                return redirect()->route('actors.index')->with('error', $message);
            }

            $name = $response->json()['name'] ?? 'Ismeretlen';

            return redirect()->route('actors.index')
                ->with('success', "$name színész sikeresen törölve!");

        } catch (\Exception $e) {
            return redirect()->route('actors.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }
}
