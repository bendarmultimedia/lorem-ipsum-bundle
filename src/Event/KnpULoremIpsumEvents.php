<?php

namespace KnpU\LoremIpsumBundle\Event;

final class KnpULoremIpsumEvents
{
    /**
     * Called directly before the Lorem Ipsum API data is returned.
     *
     * Listeners have the opportunity to change the data.
     *
     * @Event("KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent")
     */
    public const FILTER_API = FilterApiResponseEvent::class;
}
