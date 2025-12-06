<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class BDDValidationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_voir_la_connexion_de_test() { 
        $this->assertSame('mysql', config('database.default')); 
        $this->assertSame('todo_test', config('database.connections.mysql.database'));
    }


}
