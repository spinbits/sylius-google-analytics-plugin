<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Sonata\BlockBundle\Event\BlockEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\NavigationEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class NavigationEventListener implements EventSubscriberInterface
{
    private NavigationEventFactory $navEventFactory;
    private EventsBag $eventsStorage;

    /**
     * @param NavigationEventFactory $navEventFactory
     * @param EventsBag $eventsStorage
     */
    public function __construct(
        NavigationEventFactory $navEventFactory,
        EventsBag $eventsStorage
    ) {
        $this->navEventFactory = $navEventFactory;
        $this->eventsStorage = $eventsStorage;
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.product.show' => 'viewItem',
            'sonata.block.event.sylius.shop.product.index.before_list' => 'viewItemList',
            'kernel.controller_arguments' => 'onKernelRequest',//search
        ];
    }

    public function onKernelRequest(ControllerArgumentsEvent $event): void
    {
        /**
         * @psalm-suppress MixedArgument
         */
        $routeName = strval($event->getRequest()->attributes->get('_route'));

        if (!$event->isMainRequest()
            || !\is_array($event->getController())
            || 'sylius_shop_product_index' != $routeName
        ) {
            return;
        }

        if ($searchTerm = $this->getSearchTerm($event->getRequest())) {
            $this->eventsStorage->setEvent(
                $this->navEventFactory->search($searchTerm)
            );
        }
    }

    public function viewItem(ResourceControllerEvent $resourceControllerEvent): void
    {
        $product = $resourceControllerEvent->getSubject();

        if (!$product instanceof ProductInterface) {
            return;
        }

        $this->eventsStorage->setEvent(
            $this->navEventFactory->viewItem($product)
        );
    }

    public function viewItemList(BlockEvent $event): void
    {
        $this->eventsStorage->setEvent(
            $this->navEventFactory->viewItemList()
        );
    }

    private function getSearchTerm(Request $request): ?string
    {
        $criteria = $request->query->get('criteria');
        return (is_array($criteria) && isset($criteria['search']['value']))
            ? (string) $criteria['search']['value']
            : null;
    }
}
