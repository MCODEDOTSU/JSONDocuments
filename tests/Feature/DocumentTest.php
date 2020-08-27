<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\src\Models\Document;

class DocumentTest extends TestCase
{

    use RefreshDatabase;

    const PAYLOAD = [
        'actor' => 'The fox',
        'meta' => [
            'type' => 'quick',
            'color' => 'brown'
        ],
        'actions' => [[
            'action' => 'jump over',
            'actor' => 'lazy dog',
        ]],
    ];

    /**
     * A basic messages test.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/api/v1/document');
        $response->assertStatus(200);
    }

    #region Test Structure

    /**
     * Create new Document
     */
    public function testCreateDocumentStructure()
    {
        $response = $this->post('/api/v1/document');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'document' => [
                    'id',
                    'status',
                    'payload',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Show Document
     */
    public function testShowDocumentStructure()
    {
        $document = Document::create();
        $response = $this->get('/api/v1/document/' . $document->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'document' => [
                    'id',
                    'status',
                    'payload',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Update Document
     */
    public function testUpdateDocumentStructure()
    {
        $document = Document::create();
        $response = $this->patch('/api/v1/document/' . $document->id, [
            'document' => [
                'payload' => self::PAYLOAD,
            ],
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'document' => [
                    'id',
                    'status',
                    'payload',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Publish Document
     */
    public function testPublishDocumentStructure()
    {
        $document = Document::create();

        $response = $this->post("/api/v1/document/{$document->id}/publish");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'document' => [
                    'id',
                    'status',
                    'payload',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    /**
     * Documents List
     */
    public function testIndexDocumentStructure()
    {
        $response = $this->get("/api/v1/document?page=1&perPage=5");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'document' => [
                    '*' => [
                        'id',
                        'status',
                        'payload',
                        'created_at',
                        'updated_at',
                    ]
                ],
                'pagination' => [
                    'page',
                    'perPage',
                    'total',
                ]
            ]);
    }

    #endregion

    #region Test Data

    /**
     * Create new Document
     */
    public function testCreateDocumentData()
    {
        $response = $this->post('/api/v1/document');
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [
                    'status' => 'draft',
                    'payload' => [],
                ],
            ]);
    }

    /**
     * Show Document
     */
    public function testShowDocumentData()
    {
        $document = Document::create();
        $response = $this->get('/api/v1/document/' . $document->id);
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [
                    'status' => 'draft',
                    'payload' => [],
                    'id' => $document->id,
                    'created_at' => $document->created_at,
                    'updated_at' => $document->updated_at,
                ],
            ]);
    }

    /**
     * Update Document
     */
    public function testUpdateDocumentData()
    {
        $document = Document::create();
        $response = $this->patch('/api/v1/document/' . $document->id, [
            'document' => [
                'payload' => self::PAYLOAD,
            ],
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [
                    'status' => 'draft',
                    'payload' => self::PAYLOAD,
                    'id' => $document->id,
                    'created_at' => $document->created_at,
                    'updated_at' => $document->updated_at,
                ],
            ]);
    }

    /**
     * Publish Document
     */
    public function testPublishDocumentData()
    {
        $document = Document::create();
        $response = $this->post("/api/v1/document/{$document->id}/publish");
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [
                    'status' => 'published',
                    'payload' => [],
                    'id' => $document->id,
                    'created_at' => $document->created_at,
                    'updated_at' => $document->updated_at,
                ],
            ]);
    }

    /**
     * Documents List
     */
    public function testIndexDocumentData()
    {
        factory(Document::class, 9)->create();

        $response = $this->get("/api/v1/document?page=1&perPage=5");
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [],
                'pagination' => [
                    'page' => 1,
                    'perPage' => 5,
                    'total' => 5,
                ]
            ]);

        $response = $this->get("/api/v1/document?page=2&perPage=5");
        $response
            ->assertStatus(200)
            ->assertJson([
                'document' => [],
                'pagination' => [
                    'page' => 2,
                    'perPage' => 5,
                    'total' => 4,
                ]
            ]);
    }

    #endregion

    #region Test Warning Requests

    /**
     * Document Not Found Error
     */
    public function testDocumentNotFound()
    {
        $response = $this->get('/api/v1/document/718ce61b-a669-45a6-8f31-32ba41f94784');
        $response->assertStatus(404);
    }

    /**
     * Update Published Document Error
     */
    public function testUpdatePublishedDocument()
    {
        $document = Document::create();
        $response = $this->post("/api/v1/document/{$document->id}/publish");
        $response->assertStatus(200);
        $response = $this->patch('/api/v1/document/' . $document->id, [
            'document' => [
                'payload' => self::PAYLOAD,
            ],
        ]);
        $response->assertStatus(400);
    }

    /**
     * Publish Published Document Error
     */
    public function testPublishPublishedDocument()
    {
        $document = Document::create();
        $response = $this->post("/api/v1/document/{$document->id}/publish");
        $response->assertStatus(200);
        $response = $this->post("/api/v1/document/{$document->id}/publish");
        $response->assertStatus(200);
    }

    /**
     * Update Empty Document Error
     */
    public function testUpdateEmptyDocument()
    {
        $document = Document::create();
        $response = $this->patch('/api/v1/document/' . $document->id, [
            'document' => [ ],
        ]);
        $response->assertStatus(400);
    }

    #endregion
}
