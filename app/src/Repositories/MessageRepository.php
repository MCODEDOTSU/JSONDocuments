<?php

namespace App\src\Repositories;
use App\src\Models\Message;

/**
 * Class MessageRepository
 * @package App\src\Repositories
 */
class MessageRepository
{
    protected $message;

    /**
     * MessageRepository constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * All Messages
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    public function getAll(int $limit, int $offset)
    {
        return $this->message
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Create Message
     * @param $data
     * @return Message
     */
    public function create($data): Message
    {
        return $this->message->create($data);
    }

}
