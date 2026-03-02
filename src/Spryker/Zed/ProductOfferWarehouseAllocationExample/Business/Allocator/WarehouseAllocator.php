<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\ProductOfferWarehouseAllocationExample\Business\Allocator;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\ProductOfferWarehouseCriteriaTransfer;
use Spryker\Zed\ProductOfferWarehouseAllocationExample\Persistence\ProductOfferWarehouseAllocationExampleRepositoryInterface;

class WarehouseAllocator implements WarehouseAllocatorInterface
{
    /**
     * @var \Spryker\Zed\ProductOfferWarehouseAllocationExample\Persistence\ProductOfferWarehouseAllocationExampleRepositoryInterface
     */
    protected ProductOfferWarehouseAllocationExampleRepositoryInterface $productOfferWarehouseAllocationExampleRepository;

    public function __construct(
        ProductOfferWarehouseAllocationExampleRepositoryInterface $productOfferWarehouseAllocationExampleRepository
    ) {
        $this->productOfferWarehouseAllocationExampleRepository = $productOfferWarehouseAllocationExampleRepository;
    }

    public function allocateSalesOrderWarehouse(OrderTransfer $orderTransfer): OrderTransfer
    {
        foreach ($orderTransfer->getItems() as $itemTransfer) {
            $this->allocateSalesOrderItemWarehouse($itemTransfer, $orderTransfer);
        }

        return $orderTransfer;
    }

    protected function allocateSalesOrderItemWarehouse(
        ItemTransfer $itemTransfer,
        OrderTransfer $orderTransfer
    ): ItemTransfer {
        if (!$itemTransfer->getProductOfferReference()) {
            return $itemTransfer;
        }

        if ($itemTransfer->getWarehouse() && $itemTransfer->getWarehouseOrFail()->getIdStock()) {
            return $itemTransfer;
        }

        $stockTransfer = $this->productOfferWarehouseAllocationExampleRepository
            ->findProductOfferWarehouse(
                $this->createProductOfferWarehouseCriteriaTransfer($orderTransfer, $itemTransfer),
            );

        if (!$stockTransfer) {
            return $itemTransfer;
        }

        $itemTransfer->setWarehouse($stockTransfer);

        return $itemTransfer;
    }

    protected function createProductOfferWarehouseCriteriaTransfer(
        OrderTransfer $orderTransfer,
        ItemTransfer $itemTransfer
    ): ProductOfferWarehouseCriteriaTransfer {
        return (new ProductOfferWarehouseCriteriaTransfer())
            ->setProductOfferReference($itemTransfer->getProductOfferReferenceOrFail())
            ->setStore($orderTransfer->getStoreOrFail());
    }
}
