<?php

namespace App\Http\Controllers;
use App\src\Services\DocumentService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use \Validator;

/**
 * Class DocumentController
 * @package App\Http\Controllers
 */
class DocumentController extends Controller
{
    protected $documentService;

    /**
     * DocumentController constructor.
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * Get Documents
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function index(Request $request)
    {
        $page = !empty($request->input('page'))  ? (int)$request->input('page') : 1;
        $perPage = !empty($request->input('perPage'))  ? (int)$request->input('perPage') : 20;
        try {
            $documents = $this->documentService->getAllByPage($page, $perPage);
            return response([
                'document' => $documents->getCollection(),
                'pagination' => [
                    'page' => $documents->currentPage(),
                    'perPage' => $documents->perPage(),
                    'total' => $documents->count(),
                ],
            ], 200);
        } catch (Exception $ex) {
            return response([
                'error' => $ex->getMessage()
            ], $ex->getCode() == 404 ? $ex->getCode() : 400);
        }
    }

    /**
     * Create Document
     * @return Response
     */
    public function store(): Response
    {
        try {
            return response([
                'document' => $this->documentService->create()
            ], 200);
        } catch (Exception $ex) {
            return response([
                'error' => $ex->getMessage()
            ], $ex->getCode() == 404 ? $ex->getCode() : 400);
        }
    }

    /**
     * Get Document By Id
     * @param string $id
     * @return ResponseFactory|Response
     */
    public function show(string $id): Response
    {
        try {
            return response([
                'document' => $this->documentService->getById($id)
            ], 200);
        } catch (Exception $ex) {
            return response([
                'error' => $ex->getMessage()
            ], $ex->getCode() == 404 ? $ex->getCode() : 400);
        }
    }

    /**
     * Update Document
     * @param string $id
     * @param Request $request
     * @return Response
     */
    public function update(string $id, Request $request): Response
    {

        $validator = Validator::make($request->all(), [
            'document' => 'required|array',
            'document.payload' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response([ 'error' => 'Validation error' ], 400);
        }

        try {
            return response([
                'document' => $this->documentService->update($id, $request->document['payload'])
            ], 200);
        } catch (Exception $ex) {
            return response([
                'error' => $ex->getMessage()
            ], $ex->getCode() == 404 ? $ex->getCode() : 400);
        }
    }

    /**
     * Publish Document
     * @param string $id
     * @return ResponseFactory|Response
     */
    public function publish(string $id): Response
    {
        try {
            return response([
                'document' => $this->documentService->publish($id)
            ], 200);
        } catch (Exception $ex) {
            return response([
                'error' => $ex->getMessage()
            ], $ex->getCode() == 404 ? $ex->getCode() : 400);
        }
    }

}
