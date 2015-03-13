<?php
/**
 * maybe overkill. but lends consistency + predictability.
 */
class ViewState{
    /** @var string */
    private $state;
    /** @var string */
    private $validation;
    /**
     * @param string $state
     * @param string $validation
     */
    public function __construct($state, $validation)
    {
        $this->state = $state;
        $this->validation = $validation;
    }
    /** @return string */
    public function getViewState()
    {
        return $this->state;
    }
    /** @return string */
    public function getEventValidation()
    {
        return $this->validation;
    }
}