<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\ProductOfferWarehouseAllocationExample\Business\Allocator;

use Generated\Shared\Transfer\OrderTransfer;

interface WarehouseAllocatorInterface
{
    public function allocateSalesOrderWarehouse(OrderTransfer $orderTransfer): OrderTransfer;
}
