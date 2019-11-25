<?php
namespace Jtl\Connector\Core\Subscriber;

use Jtl\Connector\Core\Definition\Action;
use Jtl\Connector\Core\Definition\Controller;
use Jtl\Connector\Core\Event\Handle\RequestBeforeHandleEvent;
use Jtl\Connector\Core\Model\ProductPrice;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RequestBeforeHandleSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RequestBeforeHandleEvent::getEventName() => [
                ['handleProductPriceRequest', 0]
            ]
        ];
    }

    /**
     * @param RequestBeforeHandleEvent $event
     */
    public function handleProductPriceRequest(RequestBeforeHandleEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getController() === Controller::PRODUCT_PRICE && $request->getAction() === Action::PUSH) {
            $prices = $request->getParams();
            $resortedPrices = [];

            /** @var ProductPrice $price */
            foreach ($prices as $price) {
                $resortedPrices[$price->getProductId()->getHost()][] = $price;
            }

            $request->setParams(array_values($resortedPrices));
        }
    }
}