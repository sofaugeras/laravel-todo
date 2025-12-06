<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Todos;
use App\Models\Listes;
use App\Models\User;

class TodosModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_todos_appartient_a_une_liste()
    {
        // Arrange : création d'une liste
        $liste = Listes::factory()->create();

        // Act : création d'un Todos lié à cette liste
        $todo = Todos::factory()->for($liste, 'listes')->create();

        // Assert : la relation renvoie bien la bonne liste
        $this->assertTrue($todo->listes->is($liste));
    }

}





