<?php
namespace jtl\Connector\Event\StatusChange;

use Symfony\Component\EventDispatcher\Event;
use jtl\Connector\Model\StatusChange;


class StatusChangeAfterPullEvent extends Event
{
    const EVENT_NAME = 'statuschange.after.pull';

	protected $statuschange;

    public function __construct(StatusChange &$statuschange)
    {
		$this->statuschange = $statuschange;
    }

    public function getStatuschange()
    {
        return $this->statuschange;
	}
	
}