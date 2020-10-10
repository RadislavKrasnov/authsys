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

    const SESSION_SUCCESS_MESSAGES = 'success_messages';

    /**
     * Add collection of messages
     *
     * @param array $messages
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addMessages(array $messages, $key = self::SESSION_DATA_NAME): object;

    /**
     * Add message into collection
     *
     * @param string $message
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addMessage(string $message, $key = self::SESSION_DATA_NAME): object;

    /**
     * Get collection of messages
     *
     * @param boolean $clear
     * @param string $key
     * @return Collection|null
     */
    public function getMessages($clear = false, $key = self::SESSION_DATA_NAME): ?object;

    /**
     * Add collection of success messages
     *
     * @param array $messages
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addSuccessMessages(array $messages, $key = self::SESSION_SUCCESS_MESSAGES): object;

    /**
     * Add success message into collection
     *
     * @param string $message
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addSuccessMessage(string $message, $key = self::SESSION_SUCCESS_MESSAGES): object;

    /**
     * Get collection of success messages
     *
     * @param boolean $clear
     * @param string $key
     * @return Collection|null
     */
    public function getSuccessMessages($clear = false, $key = self::SESSION_SUCCESS_MESSAGES): ?object;
}
