<?php

namespace KnpU\LoremIpsumBundle\Controller;

use KnpU\LoremIpsumBundle\Event\FilterApiResponseEvent;
use KnpU\LoremIpsumBundle\KnpUIpsum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcher;

class IpsumApiController extends AbstractController
{
    /**
     * @var KnpUIpsum
     */
    private $knpUIpsum;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    public function __construct(
        KnpUIpsum $knpUIpsum,
        ?EventDispatcher $eventDispatcher = null
    ) {
        $this->knpUIpsum = $knpUIpsum;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function index()
    {
        $data = [
            'paragraphs' => $this->knpUIpsum->getParagraphs(),
            'sentences' => $this->knpUIpsum->getSentences()
        ];

        $event = new FilterApiResponseEvent($data);
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch('knpu_lorem_ipsum.filter_api', $event);
        }

        return $this->json($event->getData());
    }
}