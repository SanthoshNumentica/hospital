<?php
namespace App\Models\Patient;

use CodeIgniter\Model;

class Patient_imagesModel extends Model {
	public function __construct() {
		helper('Core\Helpers\File');
		$this->appConstant = new \Config\AppConstant();
		$this->imageColum = ['document' => $this->appConstant->patientImagesPath];
	}
	protected $table = 'patient_images';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_images';
	protected $useSoftDeletes = true;
	protected $allowedFields = ['patient_fk_id', 'document', 'remarks'];
	protected $useTimestamps = true;
	protected $beforeInsert = ['beforeSave'];
	protected $beforeUpdate = ['beforeSave'];
	protected $afterFind = ['addImageRealPath'];
	public function beforeSave(array $data) {
		$data['data'] = modelFileHandler($data['data'], $this->imageColum);
		return $data;
	}

	protected function addImageRealPath(array $data) {

		$data['data'] = addImageRealPath($data['data'], $this->imageColum);
		return $data;
	}
	private function addImagPath($data) {
		if (count($data) !== count($data, COUNT_RECURSIVE)) {
			foreach ($data as &$item) {
				$item = $this->mapPath($item);
			}
		} else {
			$data = $this->mapPath($data);
		}
		return $data;
	}
	private function mapPath($data) {
		if (!empty($data)) {
			foreach ($this->imageColum as $k => $v) {
				$data[$k] = $v . '/' . $data['patient_fk_id'];
			}
		}
		return $data;
	}
}
