<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\listModel;

class TodoDeleteTest extends TestCase
{
    protected $todoId;

    /**
     * A basic feature test example.
     * 
     * @return void
     */
    public function test_Delete_Todo()
    {

        $this->assertNotNull($this->todoId = 32);

        // Post request to delete the Todo item
        $response = $this->get("/listtodo/{$this->todoId}/delete");

        // Check for successful response
        $response->assertRedirect('/'); // Assuming it redirects to the list of Todos

        // Ensure that the Todo item has been deleted from the database
        $this->assertNull(listModel::find($this->todoId), 'Todo item should be deleted');

    }
    
}
