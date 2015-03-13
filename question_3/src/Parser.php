<?php
namespace p33rs;
class Parser
{
    private $document;
    public function __construct($markup)
    {
        $document = \DOMDocument::loadHTML($markup);
        if (!$document) {
            throw new \DomainException('Expected valid markup');
        }
        $this->document = $document;
    }
    public function getValue($id)
    {
        $element = $this->document->getElementById($id);
        if (!$element) {
            return null;
        }
        return $element->getAttribute('value');
    }
}