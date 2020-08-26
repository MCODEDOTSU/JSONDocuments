<?php

namespace App\Http\Controllers;
use App\src\Services\MessageService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

/**
 * Class MessageController
 * @package App\Http\Controllers
 */
class MessageController extends Controller
{
    protected $messageService;

    /**
     * MessageController constructor.
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Get Messages
     * @param int $limit
     * @param int $offset
     * @return ResponseFactory|Response
     */
    public function index(int $limit = 0, int $offset = 0)
    {
        return view('messages.index', ['messages' => $this->messageService->getAll(0, 0)]);
    }

    /**
     * Create Message
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required|max:255',
            'text' => 'required',
        ]);

        $this->messageService->create([
            'author' => $request->input('author'),
            'text' => $request->input('text'),
        ]);

        return redirect('messages');
    }

}
