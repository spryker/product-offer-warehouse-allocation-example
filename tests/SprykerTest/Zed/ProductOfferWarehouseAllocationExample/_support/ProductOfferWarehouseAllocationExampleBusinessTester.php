<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\ProductOfferWarehouseAllocationExample;

use Codeception\Actor;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\ProductOfferStock\Persistence\SpyProductOfferStockQuery;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 * @method \Spryker\Zed\ProductOfferWarehouseAllocationExample\Business\ProductOfferWarehouseAllocationExampleFacadeInterface getFacade()
 *
 * @SuppressWarnings(\SprykerTest\Zed\ProductOfferWarehouseAllocationExample\PHPMD)
 */
class ProductOfferWarehouseAllocationExampleBusinessTester extends Actor
{
    use _generated\ProductOfferWarehouseAllocationExampleBusinessTesterActions;

    public function createOrderTransfer(?string $storeName = null, ?string $productOfferReference = null): OrderTransfer
    {
        return (new OrderTransfer())
            ->setStore($storeName)
            ->addItem(
                (new ItemTransfer())
                    ->setProductOfferReference($productOfferReference)
                    ->setQuantity(2),
            );
    }

    public function ensureProductOfferStockTableIsEmpty(): void
    {
        $productOfferStockQuery = $this->getProductOfferStockQuery();
        $this->ensureDatabaseTableIsEmpty($productOfferStockQuery);
        $productOfferStockQuery->deleteAll();
    }

    protected function getProductOfferStockQuery(): SpyProductOfferStockQuery
    {
        return SpyProductOfferStockQuery::create();
    }
}
