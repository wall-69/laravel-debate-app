<?php

namespace Database\Seeders;

use App\Models\Thesis;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            "name" => "John",
            "surname" => "Doe",
            "email" => "john@doe.com",
            "password" => Hash::make("doedoe")
        ]);


        collect([
            "Umelá inteligencia by mala mať právnu zodpovednosť za svoje činy.",
            "Súkromie na internete je dôležitejšie ako národná bezpečnosť.",
            "Školy by mali úplne zrušiť známkovanie a hodnotiť študentov iným spôsobom.",
            "Sociálne siete spôsobujú viac škody ako úžitku v modernej spoločnosti.",
            "Zvieratá by mali mať rovnaké právne postavenie ako ľudia v otázke práv a ochrany.",
            "Povinná vojenská služba by mala byť zavedená vo všetkých krajinách.",
            "Pracovný týždeň by mal byť skrátený na štyri dni bez zníženia platu.",
            "Genetická úprava ľudí by mala byť povolená na elimináciu dedičných chorôb.",
            "Volebné právo by malo byť podmienené minimálnym testom politických znalostí.",
            "Kolonizácia Marsu by mala byť prioritou pre ľudstvo v 21. storočí."
        ])->each(fn ($thesis) => Thesis::factory()->create([
            "content" => $thesis
        ]));
    }
}
