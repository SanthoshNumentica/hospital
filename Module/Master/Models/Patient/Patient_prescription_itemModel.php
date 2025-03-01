<?php
namespace App\Models\Patient;

use CodeIgniter\Model;

class Patient_prescription_itemModel extends Model {
	protected $table = 'patient_prescription_item';
	protected $primaryKey = 'id';
	protected $returnType = 'App\Domain\Patient\Patient_prescription_item';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['medicine', 'frequency', 'dosage', 'm_type', 'duration', 'notes', 'patient_prescription_fk_id'];
	protected $useTimestamps = false;
	protected $afterFind = ['groupedByDate'];

	protected function groupedByDate(array $data) {
		if (empty($data['data'])) {
			return $data;
		}
		if (count($data['data']) !== count($data['data'], COUNT_RECURSIVE)) {
			foreach ($data['data'] as &$item) {
				$item = $this->groupItem($item);
			}
		} else {
			// $data['data'] = $this->groupItem($data['data']);
		}
		return $data;
	}

	protected function groupItem($item) {
		$d = ['visit_on' => $item['visit_on'] ?? '', 'doctorName' => $item['doctorName'] ?? '', 'id' => $item['patient_prescription_fk_id'] ?? ''];
		$item = unsetVariable(['visit_on', 'doctorName'], $item);
		$result = [];
		foreach ($item as $key => $value) {
			$values = explode('~', $value);
			foreach ($values as $index => $splitValue) {
				if (!isset($result[$index])) {
					$result[$index] = [];
				}
				$result[$index][$key] = $splitValue;
			}
		}
		$d['item'] = $result;
		return $d;

	}
}