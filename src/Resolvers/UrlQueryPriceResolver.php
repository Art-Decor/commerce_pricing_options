<?php

namespace Drupal\commerce_pricing_options\Resolvers;

use Drupal\commerce\Context;
use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_price\Resolver\PriceResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * URL Query Price Resolver.
 *
 * This checks the current request, and if a `discount` parameter is passed,
 * all products will calculate with a 15% discount.
 */
class UrlQueryPriceResolver implements PriceResolverInterface
{

    /**
     * The current request.
     *
     * @var null|\Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Constructs a new UrlQueryPriceResolver object.
     *
     * @param \Symfony\Component\HttpFoundation\RequestStack $request
     *   The request.
     */
    public function __construct(RequestStack $request)
    {
        $this->request = $request->getCurrentRequest();
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(PurchasableEntityInterface $entity, $quantity, Context $context)
    {
        // We check if the request has a discount parameter. We will only return a
        // price if it does. By not returning a price, we allow other resolvers to
        // have a chance at returning the price value.
        if ($this->request->query->has('attribute_add')) {
            return $entity->getPrice()->add($entity->getPrice()->add('100')); //Operations : https://github.com/drupalcommerce/commerce/blob/643bb39620c083f6d52acd41c8170d7f34b40e1c/modules/price/src/Calculator.php#L72
        }
    }
}
