<?php

namespace Tests\Feature;

use App\Models\listModel;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoEditTest extends TestCase
{
    protected $todoId;

    public function test_Edit_Todo()
    {
        // Ensure that the todoId is set
        $this->assertNotNull($this->todoId = 32);

        // Data to update the Todo item
        $newData = [
            'title' => 'Updated Task',
            'description' => 'Dont delay please',
            'deadline' => '2024-05-10', // Updated deadline
            // You can add other fields here if needed
        ];

        // Post request to update the Todo item
        $response = $this->post("/listtodo/{$this->todoId}/update", $newData);

        // Check for successful response
        $response->assertRedirect('/listtodo'); // Assuming it redirects to the list of Todos

        // Retrieve the updated Todo item from the database
        $updatedListItem = listModel::find($this->todoId);

        // Assert that the Todo item has been updated with the new data
        $this->assertEquals('Updated Task', $updatedListItem->title);
        $this->assertEquals('Dont delay please', $updatedListItem->description);
        $this->assertEquals('2024-05-10', $updatedListItem->deadline);
    }
}
