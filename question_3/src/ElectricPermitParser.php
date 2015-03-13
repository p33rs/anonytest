<?php
namespace p33rs;
class ElectricPermitParser extends Parser {

    /** @var string The HTML ID of the results table. */
    const ID_TABLE = 'InfoReq1_dgEID';

    /** @var string[] We'll scrape <th> for accurate label names. */
    private $keys = [];

    /**
     * @return array
     */
    public function readList()
    {
        /** @var \DOMElement $table */
        $table = $this->document->getElementById(self::ID_TABLE);
        if (!$table) {
            throw new \RuntimeException('Badly formatted permit list');
        }
        /** @var \DOMNodeList $rows */
        $rows = $table->getElementsByTagName('tr');
        $result = [];
        foreach ($rows as $key => $row) {
            if (!$key) {
                $this->keys = $this->getHeaders($row);
                continue;
            }
            $result[] = $this->getRowData($row);
        }
        return $result;
    }

    /**
     * @param \DOMElement $row table header row
     * @return string[]
     */
    private function getHeaders(\DOMElement $row)
    {
        $cells = $row->getElementsByTagName('th');
        $headers = [];
        foreach ($cells as $cell) {
            $headers[] = trim($cell->nodeValue);
        }
        return $headers;
    }

    /**
     * @param \DOMElement $row table content row
     * @return string[]
     */
    private function getRowData(\DOMElement $row)
    {
        $cells = $row->getElementsByTagName('td');
        $record = [];
        foreach ($cells as $key => $cell) {
            if (empty($this->keys[$key])) {
                break;
            }
            $record[$this->keys[$key]] = trim($cell->nodeValue);
        }
        return $record;
    }

}