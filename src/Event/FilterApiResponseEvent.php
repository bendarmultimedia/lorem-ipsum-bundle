<?php

namespace KnpU\LoremIpsumBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

class FilterApiResponseEvent extends Event
{
    protected array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the value of data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
