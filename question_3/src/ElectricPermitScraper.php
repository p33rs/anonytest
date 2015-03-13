<?php
namespace p33rs;
class ElectricPermitScraper extends AbstractScraper
{

    const URL_RESULTS = 'http://dbiweb.sfgov.org/dbipts/default.aspx?page=AddressData2&ShowPanel=EID';
    const TARGET_SHOW_ALL = 'InfoReq1$btnEidShowAll';
    const STATE_VIEWSTATE = '__VIEWSTATE';
    const STATE_EVENTTARGET = '__EVENTTARGET';
    const STATE_EVENTVALIDATION = '__EVENTVALIDATION';

    /** return block259, lot26 Permit #, Block, Lot, Street #, Street Name, Unit, Current Stage and Stage Date */
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
        $query = $this->createQuery($block, $lot);
        // Next, find the "one page" link and request that.
        $stateData = $this->getStateData($query);
        $list = $this->getList($stateData);
        // Parse the result.
        return $this->parse($list);
    }



    // requires:
    /*
     * Cookie variable: ASP.NET_SessionId
     */
    private function getList(ViewState $viewState)
    {
        if (empty($viewState)) {
            throw new \BadFunctionCallException('expect view state');
        }
        if (empty($eventValidation)) {
            throw new \BadFunctionCallException('expected event validation');
        }
        $postData = [
            self::STATE_EVENTTARGET => self::TARGET_SHOW_ALL,
            self::STATE_VIEWSTATE => $viewState->getViewState(),
            self::STATE_EVENTVALIDATION => $viewState->getEventValidation(),
        ];

    }

    private function parse($results)
    {

    }

}