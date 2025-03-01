<?php
namespace App\Infrastructure\Persistence\Invoice;
use Core\Domain\Exception\RecordNotFoundException;
use App\Domain\Invoice\Invoice_itemRepository;
use App\Domain\Invoice\Invoice_item;
use Core\Infrastructure\Persistence\DMLPersistence;
use App\Models\Invoice\Invoice_itemModel;

class SQLInvoice_itemRepository implements Invoice_itemRepository
{
    use DMLPersistence;

    /** @var AppModel */
    protected $model;

    public function __construct()
    {
        $this->model = new Invoice_itemModel();
    }
    public function setEntity($d)
    {
        return new Invoice_item($d);
    }

}