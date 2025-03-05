<?php

use App\Http\Controllers\ArgumentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->group(function () {
    Route::middleware("guest")->group(function () {
        Route::post("/users", "store");
    });

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/user", "user");
    });
});

Route::controller(AuthController::class)->group(function () {
    Route::post("/auth/login", "login")->middleware("guest");
    Route::post("/auth/logout", "logout")->middleware("auth:sanctum");
});

Route::controller(ArgumentController::class)->group(function () {
    Route::get("/arguments/{argument}", "argumentById");

    Route::middleware("auth:sanctum")->group(function () {
        Route::get("/arguments", "index");
    });
});

Route::controller(ThesisController::class)->group(function () {
    Route::get("/theses/random", "random")->middleware("auth:sanctum");
});

Route::post("/judge", function (Request $request) {
    $data = $request->validate([
        "thesis" => "required",
        "argument" => "required|min:30|max:3000"
    ]);

    $apiKey = env("GEMINI_API_KEY");

    $response = Http::withHeader("Content-Type", "application/json")
        ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        [
                            'text' => "T: $request->thesis\nA: $request->argument"
                        ]
                    ]
                ]
            ],
            'systemInstruction' => [
                'role' => 'user',
                'parts' => [
                    [
                        "text" => "Pracuj v slovenskom jazyku. Nezvýrazňuj žiadny text, nepoužívaj listy.\n\nOhodnoť tento argument podľa logiky, argumentačných faulov, jednoduchosti, presnosti. \nNajprv je zadefinovaná téma argumentu v riadku \"T: [theme]\", ďalej v ďalšom riadku je celý argument \"A: [argument]\".\n\nOhodnoť argument podľa týchto kritérií:\nTvrdenie - 0-1 b - Má argument jasne stanovené tvrdenie na začiatku?\nVysvetlenie - 0-5 b - Má argument vysvetlenie alebo zostáva v rovine tvrdenia? Nadväzuje vysvetlenie na tvrdenie? Existuje jasná spojitosť medzi tvrdením a vysvetlením? Ako rozsiahle je toto vysvetlenie? Sú všetky kroky v príčinnovýsledkovom reťazci dostatočne vysvetlené? Nachádzajú sa v argumente logické skoky a diery vo vysvetlení? Nachádzajú sa v argumente kontradikcie (protierečenia)? Nachádzajú sa v argumente logické chyby?\nDôkaz - 0-3 b - Nachádza sa v argumente dôkaz? Podporuje tento dôkaz vysvetlenie? Existuje link medzi vysvetlením a dôkazom? Je dôkaz dostatočne vysvetlený a pochopiteľný? Je uvedený zdroj dôkazu? Je tento zdroj dôveryhodný?\nStratégia - 0-4 b - Súvisí tento argument s témou? Je to jeden z kľúčových argumentov alebo ide skôr o okrajový a menej dôležitý bod?\nŠtýl - 0-1 b - (Gramatické chyby a preklepy nehodnotíme, pokiaľ je text čitateľný.) Je po prvom prečítaní jasné, čo sa autor snažil povedať? Pomáha štýl a výber slov obsahu argumentu, alebo mu skôr škodí? Číta sa argument príjemne? Aký dojem zanechal argument po prečítaní?\nRozsah - 0-1 b - Držal sa argument rozsahu max. 300 slov?\n\nAk sa v argumente nachádza jeden z nižšie spomenutých pojmov, udeľ trestné body:\nAd hominem (-1b), nadávky (-1b).\n\nNásledne napíš poznámky k argumentu, tieto poznámky by sa mali týkať zlých argumentačných taktík, logických chýb a možností ako argument zlepšiť. Napíš 1 až 5 poznámok."
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 1,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1500,
                'responseMimeType' => 'text/plain',
            ],
        ]);

    if ($response->successful()) {
        $responseData = $response->json();
        return response()->json($responseData["candidates"][0]["content"]["parts"][0]["text"]);
    } else {
        // Handle error
        return response()->json(['error' => 'Nastala chyba pri hodnotení.'], 500);
    }
})->middleware("auth:sanctum");
