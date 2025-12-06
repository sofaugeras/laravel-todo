<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AccueilTest extends TestCase
{
    use RefreshDatabase;

    public function test_invite_est_redirige_depuis_accueil_vers_login()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }

    public function test_invite_ne_peut_pas_acceder_aux_todos()
    {
        $response = $this->get('/todos');
        $response->assertRedirect(route('login'));
    }

    public function test_utilisateur_auth_peut_acceder_a_l_accueil()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        ->followingRedirects()
                        ->get('/');

        $response->assertOk();
        // On vérifiera qu'on voit bien le texte "Ma Todo List" dans la page
        $response->assertSee('Ma Todo List');
    }
    
    public function test_un_utilisateur_ne_peut_pas_modifier_le_todo_d_un_autre()
    {
        $a = User::factory()->create();
        $b = User::factory()->create();
        $todo = Todos::factory()->for($a, 'user')->create();

        $response = $this->actingAs($b)->post("/todos/{$todo->id}/edit", [
            'texte' => 'H4ck',
        ]);

        $response->assertForbidden();
    }
}
