<?php
namespace App\Controllers\Medicine;
use App\Domain\Medicine\Medicine_template;
use App\Infrastructure\Persistence\Medicine\SQLMedicine_templateRepository;
use App\Infrastructure\Persistence\Medicine\SQLMedicine_template_itemRepository;
use Core\Controllers\BaseController;
use Core\Controllers\DMLController;

class Medicine_templateController extends BaseController {
	use DMLController;
	private $repository;
	private $userAgentHepler;
	private $medicineTemplateitem;
	public function __construct() {
		$this->initializeFunction();
		$this->repository = new SQLMedicine_templateRepository();
		$this->medicineTemplateitem = new SQLMedicine_template_itemRepository();
	}
	public function save() {
		$data = $this->getDataFromUrl('json');
		$action = !isset($data['id']) ? 'created' : 'updated';
		$data['status'] = 1;
		if (checkValue($data, 'id')) {
			$res = $this->repository->save(new Medicine_template($data));
		} else {
			$data['id'] = $this->repository->insert(new Medicine_template($data));
			$res = true;
		}

        if ($res && isset($data['id'])) {
            $itemData = mergeArrayKey(['item'], $data, ['medicine_template_fk_id'=> $data['id']]);
            $item = $this->medicineTemplateitem->setEntity($itemData['item']);
            $this->medicineTemplateitem->save($item->toRawArray(true));
        }
        $message = $res ? "Medicine Template $action Successfully" : 'Unable to save changes';
        return $this->message($res ? 200 : 400, $data, $message);
    }
    public function getMedicineByPatient($id)
{
    $data = $this->repository->findById($id); 
    $data['item'] = $this->medicineTemplateitem->findAllByWhere(['medicine_template_fk_id' => $id]);
    return $this->message(200, $data, 'Success');
}   
public function getList()
{
    
    $data = $this->repository->findAll();
    foreach ($data as $key => $v) {
        $medicineId = $v['id'];
        $data[$key]['items'] = $this->medicineTemplateitem->findAllByWhere(['medicine_template_fk_id' => $medicineId]);
    }
    return $this->message(200, $data, 'Success');
}
public function deleteTemplate($id) {
    $id = (int) $id;
    if ($id) {
        if ($this->repository->deleteOfId($id)) {
            return $this->message(200, $id, 'Success');
        } else {
            return $this->message(400, null, 'Failed to Delete');
        }

		if ($res && isset($data['id'])) {
			$itemData = mergeArrayKey(['item'], $data, ['medicine_template_fk_id' => $data['id']]);
			$item = $this->medicineTemplateitem->setEntity($itemData['item']);
			$this->medicineTemplateitem->save($item->toRawArray(true));
		}
		$message = $res ? "Medicine Template $action Successfully" : 'Unable to save changes';
		return $this->message($res ? 200 : 400, $data, $message);
	}
}
	public function getData($id) {
		$data = $this->repository->findById($id);
		$data['item'] = $this->medicineTemplateitem->findAllByWhere(['medicine_template_fk_id' => $id]);
		return $this->message(200, $data, 'Success');
	}
	public function getAll() {


		$data = $this->repository->findAll();
		foreach ($data as $key => $v) {
			$medicineId = $v['id'];
			$data[$key]['item'] = $this->medicineTemplateitem->findAllByWhere(['medicine_template_fk_id' => $medicineId]);
		}
		return $this->message(200, $data, 'Success');
	}


}