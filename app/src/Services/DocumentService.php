<?php

namespace App\src\Services;
use App\src\Models\Document;
use App\src\Repositories\DocumentRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class DocumentRepository
 * @package App\src\Repositories
 */
class DocumentService
{
    protected $documentRepository;

    /**
     * DocumentService constructor.
     * @param DocumentRepository $documentRepository
     */
    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    /**
     * Get Documents List
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllByPage(int $page, int $perPage): LengthAwarePaginator
    {
        $documents = $this->documentRepository->getAll();
        return new LengthAwarePaginator(
            $documents->forPage($page, $perPage),
            $documents->count(),
            $perPage,
            $page
        );
    }

    /**
     * Get Document By Id
     * @param string $id
     * @return Document
     */
    public function getById(string $id): Document
    {
        return $this->documentRepository->getById($id);
    }

    /**
     * Create Document
     * @return Document
     * @throws \Exception
     */
    public function create(): Document
    {
        $document = $this->documentRepository->create();
        return $this->getById($document->id);
    }

    /**
     * Update Document
     * @param string $id
     * @param array $payload
     * @return Document
     * @throws \Exception
     */
    public function update(string $id, array $payload): Document
    {
        $document = $this->documentRepository->getById($id);
        if ($document->status == 'published') {
            throw new \Exception("The document has already been published", 400);
        }
        $document = $this->documentRepository->update($document, [
            'payload' => $payload
        ]);
        return $this->getById($document->id);
    }

    /**
     * Publish Document
     * @param string $id
     * @return Document
     */
    public function publish(string $id): Document
    {
        $document = $this->documentRepository->getById($id);
        $document = $this->documentRepository->update($document, [
            'status' => 'published'
        ]);
        return $this->getById($document->id);
    }

}
