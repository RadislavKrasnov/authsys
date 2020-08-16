<?php

namespace Core\Messages;

use Core\ActiveRecord\Collection as ActiveRecordCollection;

/**
 * Class Collection
 * @package Core\Messages
 */
class Collection extends ActiveRecordCollection
{
    /**
     * Clear message collection
     */
    public function clear()
    {
        $this->exchangeArray([]);
    }
}
