<?php
namespace p33rs;
class Parser
{
    /** @var DOMDocument */
    protected $document;
    /**
     * @param string $markup
     */
    public function __construct($markup)
    {
        libxml_use_internal_errors(true); // this markup sure is awful!
        $document = \DOMDocument::loadHTML($markup);
        libxml_use_internal_errors(false);
        if (!$document) {
            throw new \DomainException('Expected valid markup');
        }
        $this->document = $document;
    }
    /**
     * @param string $id
     * @return string
     */
    public function getValue($id)
    {
        $element = $this->document->getElementById($id);
        if (!$element) {
            return null;
        }
        return $element->getAttribute('value');
    }
}