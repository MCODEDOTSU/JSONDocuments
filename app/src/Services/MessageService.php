<?php

namespace App\src\Services;
use App\src\Models\Message;
use App\src\Repositories\MessageRepository;

/**
 * Class MessageRepository
 * @package App\src\Repositories
 */
class MessageService
{
    protected $messageRepository;

    /**
     * MessageService constructor.
     * @param MessageRepository $messageRepository
     */
    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * All Messages
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    public function getAll(int $limit, int $offset)
    {
        return $this->messageRepository->getAll($limit, $offset);
    }

    /**
     * Create Message
     * @param $data
     * @return Message
     */
    public function create($data): Message
    {
        return $this->messageRepository->create($data);
    }

}
