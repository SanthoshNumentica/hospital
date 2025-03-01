<?php

namespace App\Controllers;

use Config\Services;
use Core\Libraries\ExportExcel;
use Core\Controllers\DMLController;
use Core\Controllers\BaseController;
use Core\Models\Utility\UtilityModel;
use App\Infrastructure\Persistence\Patient\SQLPatientRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoiceRepository;
use App\Infrastructure\Persistence\Invoice\SQLInvoice_itemRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_illnessRepository;
use App\Infrastructure\Persistence\Patient\SQLPatient_treatmentRepository;
use App\Infrastructure\Persistence\Medicine\SQLMedicine_templateRepository;
use App\Infrastructure\Persistence\Payment\SQLPaymentRepository;
use App\Infrastructure\Persistence\Medicine\SQLMedicine_template_itemRepository;

class ReportController extends BaseController
{
    use DMLController;
    private $logModel;
    private $excelLib;
    private $repository;
    private $utility_repo;
    private $medical_Repo;
    private $patient_Repo;
    private $invoice_Repo;
    private $medicine_Repo;
    private $treatment_Repo;
    private $login_repository;
    private $invoiceitem_Repo;
    private $medicineTemp_Repo;
    private $medicienItem_Repo;
    private $paymentRepo;
    public function __construct()
    {
        $this->initializeFunction();
        helper('Core\Helpers\File');
        helper('Core\Helpers\Utility');
        $this->login_repository     = Services::UserLoginRepository();
        $this->utility_repo         = new UtilityModel();
        $this->excelLib             = new ExportExcel();
        $this->patient_Repo         = new SQLPatientRepository();
        $this->invoice_Repo         = new SQLInvoiceRepository();
        $this->invoiceitem_Repo     = new SQLInvoice_itemRepository();
        $this->medical_Repo         = new SQLPatient_illnessRepository();
        $this->treatment_Repo       = new SQLPatient_treatmentRepository();
        $this->medicineTemp_Repo    = new SQLMedicine_templateRepository();
        $this->medicienItem_Repo    = new SQLMedicine_template_itemRepository();
        $this->paymentRepo          = new SQLPaymentRepository();
    }

    public function index()
    {
    }

    public function genReport($module, $cond = [])
    {
        $data = $this->getDataFromUrl('json');
		$cond = checkValue($data, 'condition');
		if (checkValue($data, 'is_active_only')) {
			$ob = (object) ['colName' => strtolower($module) . '.deleted_at is Null ', 'value' => null, 'operation' => 'AND'];
			array_push($cond, $ob);
		}
		$dataResult = [];
        switch (strtolower($module)) {
            case 'patient':
                $result = $this->patient_Repo->getPatientReport($cond);
                foreach ($result as $k => &$v) {
                    $dE['basic'] = $v;
                    if (isset($data['medical_history'])) {
                        $dE['medical_history'] = $this->medical_Repo->findAllByWhere(['patient_fk_id' => $v['id']]) ?? [];
                    }
                    if (isset($data['treatment'])) {
                        $dE['treatment']      = $this->treatment_Repo->findAllByWhere(["patient_fk_id" => $v['id']]) ?? [];
                    }
                    if (!empty($dE)) {
                        array_push($dataResult, $dE);
                    }
                }
                break;
            case 'invoice':
                $result = $this->invoice_Repo->getInvoiceReport($cond);
                foreach ($result as $k => &$v) {
                    $dE['basic'] = $v;
                    if (isset($data['item'])) {
                        $dE['item'] = $this->invoiceitem_Repo->findAllByWhere(["invoice_fk_id" => $v['id']]);
                    }
                    if (!empty($dE)) {
                        array_push($dataResult, $dE);
                    }
                }
                break;
            case 'medicine':
                $result = $this->medicineTemp_Repo->findAll();
                foreach ($result as $k => &$v) {
                    $dE['basic']=$v;
                    if(isset($data['item'])){
                        $dE['item'] = $this->medicienItem_Repo->findAllByWhere(['medicine_template_fk_id' => $v['id']]);
                    }
                    if(isset($data['condition']))
                    {
                        $dE['patient'] = $this->patient_Repo->findAllByWhere(['id' =>$v['id']]);
                    }
                    if (!empty($dE)) {
                        array_push($dataResult, $dE);
                    }
                }
                break;
                case"payment":
                    $result =$this->paymentRepo->findAll();
                    foreach ($result as $k => &$v) {
                        $dE['basic']=$v;
                        if(isset($data['item'])){
                            $dE['item'] = $this->paymentRepo->findAllByWhere(['id' => $v['id']])?? [];
                        }
                        if (!empty($dE)) {
                            array_push($dataResult, $dE);
                        }
                    }
                    break;
                        }
        return $this->excelLib->export($dataResult, $data);
    }
}
