<?php
namespace App\Controllers\Medicine;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Infrastructure\Persistence\Medicine\SQLMedicine_template_itemRepository;

class Medicine_template_itemController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLMedicine_template_itemRepository();
    }
    public function deleteTemplateItem($id) {
		$id = (int) $id;
		if ($id) {
			if ($this->repository->deleteOfId($id)) {
				return $this->message(200, $id, 'Success');
			} else {
				return $this->message(400, null, 'Failed to Delete');
			}

		}
	}
}