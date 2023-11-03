<?php

namespace KnpU\LoremIpsumBundle\Event;

final class KnpULoremIsumEvents
{
    /**
     * Callled directly brefore the Lorem Ipsum API data is returned
     *
     * Listeners have the opotrunity to change that data
     *
     * @Event("KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent")
     */
    const FILTER_API = 'knpu_lorem_ipsum.filter_api';
}