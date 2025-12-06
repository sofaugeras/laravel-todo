<?php

namespace Tests\Feature;

use App\Models\Listes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodosValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Méthode utilitaire pour poster un Todo avec des données par défaut
     */
    private function postTodo(array $overrides = [])
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $liste = Listes::factory()->create();

        $data = array_merge([
            'texte' => 'Acheter du café',
            'date_fin' => now()->addDay()->format('Y-m-d\TH:i'),
            'priority' => 0,              // bouton radio importance
            'categories' => [],             // tableau de catégories (checkbox)
            'liste' => $liste->id,     // correspond à $request->input('liste')
        ], $overrides);

        return $this->post('/action/add', $data);
    }

    public function test_texte_est_obligatoire()
    {
        $response = $this->postTodo(['texte' => '']);

        $response->assertRedirect(route('todo.liste'));

        $response->assertSessionHas('message', "Veuillez saisir un ToDo d'une longueur max de 255 caractères");

        $this->assertDatabaseCount('todos', 0);
    }

    public function test_texte_ne_doit_pas_depasser_255_caracteres()
    {
        $longTexte = str_repeat('a', 256);

        $response = $this->postTodo(['texte' => $longTexte]);

        $response->assertRedirect(route('todo.liste'));

        $response->assertSessionHas('message', "Veuillez saisir un ToDo d'une longueur max de 255 caractères");

        $this->assertDatabaseCount('todos', 0);
    }

    public function test_un_todos_valide_est_cree()
    {
        $response = $this->postTodo(); // toutes les valeurs par défaut sont valides

        $response->assertSessionDoesntHaveErrors();
        $response->assertRedirect(); // ou ->assertRedirect('/'); selon ton contrôleur

        $this->assertDatabaseCount('todos', 1);

        $this->assertDatabaseHas('todos', [
            'texte' => 'Acheter du café',
            'termine' => 0,
            'important' => 0,
        ]);
    }
}
