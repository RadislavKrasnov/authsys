<?php

namespace Core\Api\Messages;

use Core\Messages\Collection;

/**
 * Interface MessageManagerInterface
 * @package Core\Api\Messages
 */
interface MessageManagerInterface
{
    const SESSION_DATA_NAME = 'messages';

    /**
     * Add collection of messages
     *
     * @param array $messages
     * @return MessageManagerInterface
     */
    public function addMessages(array $messages): object;

    /**
     * Add message into collection
     *
     * @param string $message
     * @return MessageManagerInterface
     */
    public function addMessage(string $message): object;

    /**
     * Get collection of messages
     *
     * @param boolean $clear
     * @return Collection|null
     */
    public function getMessages($clear = false): ?object;
}
