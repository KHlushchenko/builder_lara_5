<?php

namespace Vis\Builder\Fields;

class PatternField extends AbstractField
{
    
    protected $fieldName;
    protected $attributes;
    protected $options;
    protected $definition;
    protected $calls;

    protected $handler;


    public function __construct($fieldName, $attributes, $options, $definition, $handler)
    {
        $this->attributes = $attributes;
        $this->options    = $options;
        $this->definition = $definition;
        $this->fieldName  = $fieldName;
        
        $this->handler = &$handler;
        
        $patternName = preg_replace('~^pattern\.~', '', $fieldName);
        $path = config_path() .'/builder/tb-definitions/pattern/'. $patternName .'.php';
        if (!file_exists($path)) {
            throw new \RuntimeException("No pattern definition - [{$patternName}].");
        }
        $this->calls = require($path);
    } // end __construct
    
    public function render($row = array())
    {
        $view = $this->calls['view'];
        return $view($row);
    } // end render
    
    public function update($values, $idRow)
    {
        $call = $this->calls['handle']['update'];
        return $call($values, $idRow);
    } // end update
    
    public function insert($values, $idRow)
    {
        $call = $this->calls['handle']['insert'];
        return $call($values, $idRow);
    } // end insert
    
    public function delete($idRow)
    {
        $call = $this->calls['handle']['delete'];
        return $call($idRow);
    } // end delete
    
    public function isPattern()
    {
        return true;
    } // end isPattern

    public function onSearchFilter(&$db, $value){
        return;
    }

    public function getClientsideValidatorRules()
    {
        return;
    }

    public function getClientsideValidatorMessages()
    {
        return;
    }

    public function doValidate($value)
    {
        return;
    }

    public function getEditInput($row = array())
    {
        return $this->render($row);
    }
    public function getTabbedEditInput($row = array())
    {
        return $this->render($row);
    }
}
