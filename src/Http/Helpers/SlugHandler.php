<?php namespace Vis\Builder\Helpers;

use Vis\Builder\Handlers\CustomHandler;
use Vis\Builder\Facades\Jarboe;

class SlugHandler extends CustomHandler
{
    protected function setSlug(array $response)
    {
        $model =  $this->controller->getDefinition()['options']['model'];
        $model::where('id',$response['id'])->update(['slug' => Jarboe::urlify(($response['values']['title']))]);
    }
    
    public function onInsertRowResponse(array &$response)
    {
        $this->setSlug($response);
    } 
    
    public function onUpdateRowResponse(array &$response)
    {
        $this->setSlug($response);
    }
   
}
