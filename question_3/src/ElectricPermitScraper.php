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

    private function getPermits($block, $lot)
    {
        // First, make a request to create a query.
        $this->createQuery($block, $lot);
        // Next, find the "one page" link and request that.
        $permitList = $this->getPermitList();
        $permitState = $this->getStateData($permitList);
        $results = $this->requestFullList($permitState);
        // Parse the result.
        return $this->parse($results);
    }

    private function getPermitList()
    {
        return $this->fetcher->fetch(
            self::URL_PAGED_LIST,
            'POST'
        );
    }

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

    /** return block259, lot26 Permit #, Block, Lot, Street #, Street Name, Unit, Current Stage and Stage Date */

    private function parse($results)
    {
        var_export($results);
    }

}