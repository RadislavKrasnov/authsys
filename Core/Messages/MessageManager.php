<?php

namespace Core\Messages;

use Core\Messages\Collection;
use Core\Api\Messages\MessageManagerInterface;
use Core\Api\Session\SessionInterface;

/**
 * Class MessageManager
 * @package Core\Messages
 */
class MessageManager implements MessageManagerInterface
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * MessageManager constructor.
     *
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Add collection of messages
     *
     * @param array $messages
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addMessages(array $messages, $key = self::SESSION_DATA_NAME): object
    {
        foreach ($messages as $message) {
            $this->addMessage($message, $key);
        }

        return $this;
    }

    /**
     * Add message into collection
     *
     * @param string $message
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addMessage(string $message, $key = self::SESSION_DATA_NAME): object
    {
        $messages = $this->getMessages($key);

        if (empty($messages)) {
            $messages = new Collection();
        }

        $messages->append($message);
        $this->session->addData($key, $messages);

        return $this;
    }

    /**
     * Get collection of messages
     *
     * @param boolean $clear
     * @param string $key
     * @return Collection|null
     */
    public function getMessages($clear = false, $key = self::SESSION_DATA_NAME): ?object
    {
        $messageCollection = $this->session->getData($key);

        if (empty($messageCollection)) {
            return null;
        }

        if ($clear) {
            $messageCollection = clone $this->session->getData($key);
            $this->session->getData($key)->clear();
        }

        return $messageCollection;
    }

    /**
     * Add collection of success messages
     *
     * @param array $messages
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addSuccessMessages(array $messages, $key = self::SESSION_SUCCESS_MESSAGES): object
    {
        return $this->getMessages($messages, $key);
    }

    /**
     * Add success message into collection
     *
     * @param string $message
     * @param string $key
     * @return MessageManagerInterface
     */
    public function addSuccessMessage(string $message, $key = self::SESSION_SUCCESS_MESSAGES): object
    {
        return $this->addMessage($message, $key);
    }

    /**
     * Get collection of success messages
     *
     * @param boolean $clear
     * @param string $key
     * @return Collection|null
     */
    public function getSuccessMessages($clear = false, $key = self::SESSION_SUCCESS_MESSAGES): ?object
    {
        return $this->getMessages($clear, $key);
    }
}
