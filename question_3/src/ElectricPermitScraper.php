<?php
namespace p33rs;
class ElectricPermitScraper extends AbstractScraper
{

    const URL_PAGED_LIST = 'http://dbiweb.sfgov.org/dbipts/default.aspx?page=AddressData2&ShowPanel=EID';
    const URL_FULL_LIST = 'http://dbiweb.sfgov.org/dbipts/Default2.aspx?page=AddressData2&ShowPanel=EID';
    const TARGET_SHOW_ALL = 'InfoReq1$btnEidShowAll';
    const STATE_VIEWSTATE = '__VIEWSTATE';
    const STATE_EVENTTARGET = '__EVENTTARGET';
    const STATE_EVENTVALIDATION = '__EVENTVALIDATION';

    /**
     * @param string $block
     * @param string $lot
     * @param array $options
     * @return array
     */
    public function scrape ($block, $lot, array $options = [])
    {
        if (empty($block)) {
            throw new \BadFunctionCallException('requires block');
        }
        if (empty($lot)) {
            throw new \BadFunctionCallException('requires lot');
        }
        return $this->getPermits($block, $lot);
    }

    /**
     * @param string $block
     * @param string $lot
     * @return array
     */
    private function getPermits($block, $lot)
    {
        // First, make a request to get our session started.
        $this->createQuery($block, $lot);
        // Next, load a page of results so we can click the "one page" link.
        $permitList = $this->getPermitList();
        // We need to embed some data from that page into our request for the one-page.
        $permitState = $this->getStateData($permitList);
        // Finally, request all of the results in a single page.
        $results = $this->requestFullList($permitState);
        // Parse the result. Return an array.
        return $this->parse($results);
    }

    /**
     * @return string
     */
    private function getPermitList()
    {
        return $this->fetcher->fetch(
            self::URL_PAGED_LIST,
            'POST'
        );
    }

    /**
     * @param ViewState $viewState
     * @return string
     */
    private function requestFullList(ViewState $viewState)
    {
        $postData = [
            self::STATE_EVENTTARGET => self::TARGET_SHOW_ALL,
            self::STATE_VIEWSTATE => $viewState->getViewState(),
            self::STATE_EVENTVALIDATION => $viewState->getEventValidation(),
        ];
        return $this->fetcher->fetch(
            self::URL_FULL_LIST,
            'POST',
            $postData
        );
    }

    /**
     * @param $results
     * @return array
     */
    private function parse($results)
    {
        $parser = new ElectricPermitParser($results);
        return $parser->readList();
    }

}