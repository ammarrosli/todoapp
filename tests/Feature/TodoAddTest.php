<?php

namespace Tests\Feature;

use App\Models\listModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// use PHPUnit\Framework\TestCase;

class TodoAddTest extends TestCase
{
    protected $todoId;

    /**
     * A basic feature test example.
     * 
     * @return void
     */

    public function test_add_todo()
    {
        // Data to add a new Todo item
        $todoData = [
            'title' => 'New Task',
            'description' => 'Dont Delay',
            'deadline' => '2024-05-08',
        ];

        // Post request to add a new Todo item
        $response = $this->post("/listtodo", $todoData);

        $response->assertRedirect('/'); 

        $newListItem = listModel::latest()->first();

        $this->todoId = $newListItem->id;

        // Assert that the Todo item has been added with the correct data
        $this->assertEquals('New Task', $newListItem->title);
        $this->assertEquals('Dont Delay', $newListItem->description);
        $this->assertEquals('2024-05-08', $newListItem->deadline);
    }


}
