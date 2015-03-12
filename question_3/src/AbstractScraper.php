<?php
namespace p33rs;
abstract class AbstractScraper
{

    const URL_QUERY = 'http://dbiweb.sfgov.org/dbipts/default.aspx?page=AddressQuery';

    /** @var Fetcher */
    private $fetcher;

    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /*
     * Switching to "View all":
     *
     */
    public abstract function fetch(array $options = []);

}