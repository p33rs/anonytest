<?php
namespace p33rs;
/**
 * Specific to the SF DBI.
 * Another potential subclass could be, eg., a BuildingPermitScraper.
 */
abstract class AbstractScraper
{

    const URL_QUERY = 'http://dbiweb.sfgov.org/dbipts/?page=address&';
    const FIELD_VIEWSTATE = '__VIEWSTATE';
    const FIELD_EVENTVALIDATION = '__EVENTVALIDATION';

    /** @var Fetcher */
    protected $fetcher;

    /** @var Parser */
    protected $parser;

    /**
     * @param Fetcher $fetcher
     */
    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @param string $block
     * @param string $lot
     * @param array $options
     * @return mixed
     */
    public abstract function scrape($block, $lot, array $options = []);

    /**
     * First, we make an initial request to the page so that the site remembers,
     *   in our session data, what we were searching for and how we want to view it.
     * @param string $block
     * @param string $lot
     * @return string
     */
    protected function createQuery($block, $lot)
    {
        $url = AbstractScraper::URL_QUERY . http_build_query(['Block' => $block, 'Lot' => $lot]);
        return $this->fetcher->fetch(
            $url,
            'POST'
        );
    }

    /**
     * We got some hidden form fields with each response that certain actions require
     *   in order to maintain the session. This method pulls that data from the page.
     * @param string $page
     * @return ViewState
     */
    protected function getStateData($page)
    {
        $parser = new Parser($page);
        $state = $parser->getValue(self::FIELD_VIEWSTATE);
        $validation = $parser->getValue(self::FIELD_EVENTVALIDATION);
        if (!$state || !$validation) {
            throw new \RuntimeException('Got invalid query page');
        }
        return new ViewState($state, $validation);
    }

}