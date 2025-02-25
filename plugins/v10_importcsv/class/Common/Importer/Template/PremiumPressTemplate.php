<?php

namespace ImportWP\Common\Importer\Template;

use ImportWP\Common\Importer\ParsedData;
use ImportWP\EventHandler;

class PremiumPressTemplate extends PostTemplate
{
    protected $name = 'PremiumPress Themes';
	protected $mapper = 'premiumpress-product';

    public function __construct(EventHandler $event_handler)
    {
        parent::__construct($event_handler); 
		
         
		
    }

    public function register()
    {
        $groups = parent::register();
		 
        
        return $groups;
    }

    /**
     * Process data before record is importer.
     * 
     * Alter data that is passed to the mapper.
     *
     * @param ParsedData $data
     * @return ParsedData
     */
    public function pre_process(ParsedData $data)
    {  

        return parent::pre_process($data);
    }
}
