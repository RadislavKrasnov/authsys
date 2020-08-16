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
     * @return MessageManagerInterface
     */
    public function addMessages(array $messages): object
    {
        foreach ($messages as $message) {
            $this->addMessage($message);
        }

        return $this;
    }

    /**
     * Add message into collection
     *
     * @param string $message
     * @return MessageManagerInterface
     */
    public function addMessage(string $message): object
    {
        $messages = $this->getMessages();

        if (empty($messages)) {
            $messages = new Collection();
        }

        $messages->append($message);
        $this->session->addData(MessageManagerInterface::SESSION_DATA_NAME, $messages);

        return $this;
    }

    /**
     * Get collection of messages
     *
     * @param boolean $clear
     * @return Collection|null
     */
    public function getMessages($clear = false): ?object
    {
        $messageCollection = $this->session->getData(MessageManagerInterface::SESSION_DATA_NAME);

        if (empty($messageCollection)) {
            return null;
        }

        if ($clear) {
            $messageCollection = clone $this->session->getData(MessageManagerInterface::SESSION_DATA_NAME);
            $this->session->getData(MessageManagerInterface::SESSION_DATA_NAME)->clear();
        }

        return $messageCollection;
    }
}
