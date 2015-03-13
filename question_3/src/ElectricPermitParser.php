<?php
namespace p33rs;
class ElectricPermitParser extends Parser {

    const ID_TABLE = 'InfoReq1_dgEID';

    private $keys = [];

    /** return block259, lot26 Permit #, Block, Lot, Street #, Street Name, Unit, Current Stage and Stage Date */

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
                var_export($this->keys);
                continue;
            }
            $result[] = $this->getRowData($row);
        }
        return $result;
    }

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
     *
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