<?php
/**
 * Class w2p_Output_HTML_Base
 */
abstract class w2p_Output_HTML_Base
{
    protected $AppUI = null;
    public $df = null;
    protected $dtf = null;

    public function __construct($AppUI)
    {
        $this->AppUI = $AppUI;
        $this->df     = $AppUI->getPref('SHDATEFORMAT');
        $this->dtf    = $this->df . ' ' . $AppUI->getPref('TIMEFORMAT');
    }

    public function addLabel($label)
    {
        return '<label>' . $this->AppUI->_($label) . ':</label>';
    }

    public function showLabel($label)
    {
        echo $this->addLabel($label);
    }
}