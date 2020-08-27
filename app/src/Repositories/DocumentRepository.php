<?php

namespace App\src\Repositories;

use App\src\Models\Document;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * Class DocumentRepository
 * @package App\src\Repositories
 */
class DocumentRepository
{
    protected $document;

    /**
     * DocumentRepository constructor.
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Get Documents List
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->document
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get Document By Id
     * @param string $id
     * @return Document
     */
    public function getById(string $id): Document
    {
        $document = $this->document
            ->where('id', $id)
            ->first();
        if (!$document) {
            throw new ModelNotFoundException("Document not found by ID $id", 404);
        }
        return $document;
    }

    /**
     * Create Draft Document
     * @param array $data
     * @return Document
     * @throws \Exception
     */
    public function create(): Document
    {
        return $this->document->create();
    }

    /**
     * Update Document
     * @param Document $document
     * @param array $data
     * @return Document
     */
    public function update(Document $document, array $data): Document
    {
        $document->status = empty($data['status']) ? $document->status : $data['status'];
        $document->payload = empty($data['payload']) ? $document->payload : $data['payload'];
        $document->save();
        return $document;
    }

}
