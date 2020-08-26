<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\src\Models\Message;

class MessageTest extends TestCase
{
    /**
     * A basic messages test.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/messages');

        $response->assertStatus(200);
    }

    /**
     * Create new Message
     */
    public function testCreate()
    {
        Message::create([
            'author' => 'Elena B.',
            'text' => 'My friend, my friend. I am very, very sick. I don\'t know where this pain came from. Either the wind whistles over an empty and deserted field. Roofing paper, like a grove in September, showered the brains with alcohol.'
        ]);

        $this->assertDatabaseHas('messages', [ 'author' => 'Elena B.' ]);

        Message::where('author', 'Elena B.')->delete();
    }
}
