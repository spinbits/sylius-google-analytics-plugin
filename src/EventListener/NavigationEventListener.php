<?php
/**
 * @author Jakub Lech <info@smartbyte.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spinbits\SyliusGoogleAnalytics4Plugin\EventListener;

use Pagerfanta\Pagerfanta;
use Sonata\BlockBundle\Event\BlockEvent;
use Spinbits\SyliusGoogleAnalytics4Plugin\Factory\Events\NavigationEventFactory;
use Spinbits\SyliusGoogleAnalytics4Plugin\Storage\EventsBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class NavigationEventListener implements EventSubscriberInterface
{
    public function __construct(
        private NavigationEventFactory $navEventFactory,
        private EventsBag $eventsStorage
    ) {
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
        $routeName = $event->getRequest()->attributes->get('_route');

        if (!$event->isMainRequest()
            || !\is_array($event->getController())
            || 'sylius_shop_product_index' !== $routeName
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
        /** @var array<'products', mixed> $settings */
        $settings = $event->getSettings();

        $products = [];
        if (isset($settings['products']) && $settings['products'] instanceof Pagerfanta) {
            /** @var array<ProductInterface> $products */
            $products = (array) $settings['products']->getCurrentPageResults();
        }

        $this->eventsStorage->setEvent(
            $this->navEventFactory->viewItemList($products)
        );
    }

    private function getSearchTerm(Request $request): ?string
    {
        /** @var array<string, array<string, string|null|int>> $criteria */
        $criteria = (array) $request->query->get('criteria');
        return (isset($criteria['search']['value']))
            ? (string) $criteria['search']['value']
            : null;
    }
}
