<?php
namespace App\Controllers\Invoice;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Invoice\SQLInvoice_itemRepository;

class Invoice_itemController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLInvoice_itemRepository();
    }
}