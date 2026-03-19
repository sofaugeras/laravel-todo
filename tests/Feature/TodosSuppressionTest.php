<?php

namespace Tests\Feature;

use App\Models\Todos;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodosSuppressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_suppression_sans_confirmation_est_impossible_via_get(): void
    {
        $user = User::factory()->create();
        $todo = Todos::factory()->create([
            'user_id' => $user->id,
            'termine' => 1,
        ]);

        $response = $this->actingAs($user)->get("/action/delete/{$todo->id}");

        $response->assertStatus(405);
        $this->assertNotSoftDeleted('todos', ['id' => $todo->id]);
    }

    public function test_suppression_avec_confirmation_supprime_le_todo(): void
    {
        $user = User::factory()->create();
        $todo = Todos::factory()->create([
            'user_id' => $user->id,
            'termine' => 1,
        ]);

        $response = $this->actingAs($user)
            ->delete("/action/delete/{$todo->id}");

        $response->assertRedirect(route('todo.liste'));
        $response->assertSessionHas('validation', 'ToDo correctement supprimé');

        // SoftDeletes : la ligne existe mais deleted_at est renseigné
        $this->assertSoftDeleted('todos', ['id' => $todo->id]);
    }

    public function test_todo_non_termine_ne_peut_pas_etre_supprime(): void
    {
        $user = User::factory()->create();
        $todo = Todos::factory()->create([
            'user_id' => $user->id,
            'termine' => 0,
        ]);

        $this->actingAs($user)->delete("/action/delete/{$todo->id}");

        // Le todo ne doit PAS être soft-deleted
        $this->assertNotSoftDeleted('todos', ['id' => $todo->id]);
    }
}
