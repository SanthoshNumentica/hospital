<?php
namespace Core\Libraries;

use App\Infrastructure\Persistence\Child\SQLChildRepository;
use App\Infrastructure\Persistence\Child\SQLChild_reportRepository;
use App\Infrastructure\Persistence\Church\SQLChurchRepository;
use App\Infrastructure\Persistence\Church\SQLChurch_reportRepository;
use App\Infrastructure\Persistence\Sponsor\SQLDedication_detailRepository;
use App\Infrastructure\Persistence\Sponsor\SQLSponsorRepository;
use App\Infrastructure\Persistence\Sponsor\SQLSponsorship_allotmentRepository;
use App\Infrastructure\Persistence\Sponsor\SQLSponsor_giftRepository;
use App\Infrastructure\Persistence\Staff\SQLStaffRepository;
use App\Infrastructure\Persistence\Staff\SQLStaff_addressRepository;
use App\Infrastructure\Persistence\Staff\SQLStaff_report_langRepository;
use Core\Libraries\PDFGenerator;
use Core\Models\Utility\UtilityModel;
use Mail\Libraries\Email;

class EmailConetentGenerator
{
    private $pdf;
    static $response;
    private $allotment_repository;
    public function __construct()
    {
        $this->UtilityModel          = new UtilityModel();
        $this->staff_repository      = new SQLStaffRepository();
        $this->child_repo            = new SQLChildRepository();
        $this->staff_addr_repository = new SQLStaff_addressRepository();
        $this->sponsor_repository    = new SQLSponsorRepository();
        $this->staff_report_repo     = new SQLStaff_report_langRepository();
        $this->gift_repo             = new SQLSponsor_giftRepository();
        $this->childReportRepo       = new SQLChild_reportRepository();
        $this->dedicationRepo        = new SQLDedication_detailRepository();
        $this->churchReortRepo       = new SQLChurch_reportRepository();
        $this->churchRepo            = new SQLChurchRepository();
        $this->allotment_repository  = new SQLSponsorship_allotmentRepository();
    }

    public function genContentSentEmail($id, $data, $attachment = [], $sendEmail = true)
    {
        $c     = $this->generateEmail($id, $data);
        $email = new Email();
        //pdf header replace
        $template = (array) $c['template'];
        if (checkValue($template, 'pdf_header')) {
            $pdf = new PDFGenerator();
            $c['template']->pdf_content = $pdf->genPdfHtmlContentWithHeader($template['pdf_content'], $template['pdf_header'], $template['pdf_footer'] ?? '');
        }
        return $email->mapWithConent($c['template'], $c['combineData'], $sendEmail, $attachment);
    }

    public function generateEmail($id, $data)
    {
        //$data        = $this->getDataFromUrl('json');
        $template = $this->UtilityModel->getDataById('email_template', array('id' => $id));

        $combineData = array();
        $sponsorId   = isset($data['sponsor_id']) ? $data['sponsor_id'] : '';
        if (!empty($template)) {
            switch ((int) $template->module_id) {
                case 1:
                    // staff...
                    $data['staff_emp_id']  = $data['staff_fk_id'] ?? $data['staff_emp_id'] ?? '';
                    $data['spouce_emp_id'] = $data['spouce_fk_id'] ?? '';
                    if (isset($data['staff_report_id']) && !empty($data['staff_report_id'])) {
                        $data                  = $this->getStaffReport($data['staff_report_id'], $data['staff_report_data'] ?? '');
                        $data['spouce_emp_id'] = $data['spouce_fk_id'] ?? '';
                        $data['staff_emp_id']  = $data['staff_fk_id'] ?? '';
                    }

                    if (checkValue($data, 'dedication_id')) {
                        $data                  = $this->dedicationRepo->findById($data['dedication_id']);
                        $data['spouce_emp_id'] = $data['accompany_staff_fk_id'] ?? '';
                        $data['staff_emp_id']  = $data['staff_fk_id'] ?? '';
                        $sponsorId             = $data['sponsor_fk_id'];
                    }

                    if (isset($data['spouce_emp_id']) && !empty($data['spouce_emp_id'])) {
                        $combineData = $this->getStaffDetails([$data['staff_emp_id'], $data['spouce_emp_id']], true, '', true);
                        $combineData = array_merge($data, $combineData);
                    } else if ($data['staff_emp_id']) {
                        $combineData = $this->getStaffDetails($data['staff_emp_id'], true, '', false, $template->id == 10);
                        $combineData = $this->reliveDataMap($combineData);
                        $combineData = array_merge($data, $combineData);
                    }
                    // staff dedication
                    if (keyExsits($data, 'accompany_staff_fk_id')) {
                        $report      = $this->dedicationDataMap($data);
                        $combineData = array_merge($report, $combineData);
                    }
                    // staff report
                    if (checkValue($data, 'report_month')) {
                        $report      = $this->reportDataMap($data);
                        $combineData = array_merge($report, $combineData);
                    }

                    if (isset($data['staff_emp_id_old'])) {
                        $staffData1  = $this->getStaffDetails($data['staff_emp_id_old'], false, 'Old');
                        $combineData = array_merge($staffData1, $combineData);
                    }
                    break;

                case 2:
                    //child
                    if (isset($data['child_report_id']) && !empty($data['child_report_id'])) {
                        $data = $this->getChildReport($data['child_report_id']);
                        //print_r($data);
                    }
                    if (isset($data['child_id']) && !empty($data['child_id'])) {
                        $combineData = $this->getChild($data['child_id']);
                    }
                    if (isset($data['from_report_date_month']) || isset($data['from_report_year'])) {
                        $report      = $this->reportDataMap($data);
                        $combineData = array_merge($report, $combineData);
                    }

                    break;
                case 3:
                    //church
                    if (isset($data['report_id']) && !empty($data['report_id'])) {
                        $combineData = $this->getChurchReport($data['report_id']);
                    }
                    break;
                case 4:
                    //sponsor gift
                    $combineData = $this->getGift($data['id']);
                    break;
            }
            $cc_email = [];
            if (!empty($sponsorId)) {
                $sponsorData = $this->getSponsorDetails($sponsorId);
                if (checkValue($data, 'sponsorship_module')) {
                    $c      = array('sp.sponsor_fk_id' => $sponsorData['id'], 'sp.sponsorship_module' => $data['sponsorship_module']);
                    $ref_id = $data['staff_fk_id'] ?? $data['child_fk_id'] ?? $data['church_fk_id'] ?? '';
                    if ($ref_id) {
                        $c = array_merge($c, ['ref_id' => $ref_id]);
                    }
                    $allot = $this->allotment_repository->findAllByWhereActive($c);
                    if (!empty($allot)) {
                        $cc_email = [];
                        foreach ($allot as $k => $v) {
                            array_push($cc_email, $v['cc_email']);
                        }
                    }
                }
                $combineData  = array_merge($sponsorData, $combineData);
                $template->to = $sponsorData['email_id'];
            } else {
                $template->to = $data['email_id'] ?? ($template->to ?? '') ?? '';
            }

            $combineData['date']      = date('d M Y');
            $combineData['signImage'] = converBaseImage(BASEURL . '/public/sign.jpg');
        }

        foreach ($template as $k => $v) {
            $combineData[$k] = $v;
            $map             = ["PROMO_OFFICE" => "promotionalEmail", 'ZONE' => "zoneEmail", "REGION" => "regionEmail", "CHURCH" => "churchEmail", "CHILD" => "childEmail", "HOME" => "homeEmail", "DEPARTMENT" => "departmentEmail", 'ADOFFICE' => 'adEmail_id'];
            if ($k == 'cc') {
                $CCArray   = explode(',', $v);
                $ccDbArray = explode(',', $template->cc_event);
                foreach ($ccDbArray as $mv) {
                    if (isset($map[$mv]) && checkValue($combineData, $map[$mv])) {
                        array_push($CCArray, $combineData[$map[$mv]]);
                    }
                }
                $combineData['cc'] = implode(',', array_filter($CCArray, 'strlen'));
            } else if ($k == 'to_event' && !empty($template->to_event)) {
                $TOArray           = [];
                $combineData['to'] = '';
                $toDbArray         = explode(',', $template->to_event);
                foreach ($toDbArray as $mv) {
                    if (isset($map[$mv]) && checkValue($combineData, $map[$mv])) {
                        array_push($TOArray, $combineData[$map[$mv]]);
                    }
                }
                $combineData['to'] = implode(',', array_filter($TOArray, 'strlen'));
                $template->to      = $combineData['to'];
            }
        }
        if (!empty($cc_email)) {
            $combineData['cc'] = implode(',', array_filter($cc_email, 'strlen'));
        }
        return ["combineData" => $combineData, 'module_id' => $template->module_id, "template" => $template]; // to , cc body, pdf_content
    }

    private function getStaffReport($id, $data = '')
    {
        if (empty($data)) {
            $data = $this->staff_report_repo->findDetails($id);
        }
        foreach (['family_news', 'brief_ministry', 'promise_verse', 'prayer_points', 'praise_points'] as $k => $v) {
            $data[$v] = $data['src_content']->{$v} ?? '';
        }
        return $data;
    }

    private function dedicationDataMap($data = [])
    {
        if (empty($data)) {
            $data = $this->getDataFromUrl('json');
        }
        $map = ['arrivalDate' => 'arrival_date_time', 'depatureDate' => 'dept_date_time', 'dedicationDate' => 'date_time', 'dedicationPlace' => 'place', 'staffLeavingDate' => 'm_dept_date_time', 'staffArrivalDate' => 'm_arrival_date_time', 'accompanyStaffName' => 'accompany_name', "accompanyStaffEmpCode" => "accompany_staff_emp_id"];
        foreach (['arrival_date_time', 'dept_date_time', 'date_time', 'm_dept_date_time', 'm_arrival_date_time'] as $k => $v) {
            if (checkValue($data, $v)) {
                $data[$v] = date('Y-m-d h:i A', strtotime($data[$v]));
            }
        }
        $data = mapData($map, $data);
        return $data;

    }
    private function reportDataMap($data = [])
    {
        if (empty($data)) {
            $data = $this->getDataFromUrl('json');
        }
        $map = ['familyNews' => 'family_news', 'briefMinistry' => 'brief_ministry', 'promiseVerse' => 'promise_verse', 'prayerPoints' => 'prayer_points', 'praisePoints' => 'praise_points', 'reportMonth' => 'report_monthName', 'reportYear' => 'report_year', 'reportRange' => 'report_range'];
        if (isset($data['report_month'])) {
            $date                     = "${data['report_year']}-${data['report_month']}-01";
            $data['report_monthName'] = date('M', strtotime($date));
        }
        if (isset($data['from_report_date_month']) || isset($data['from_report_year'])) {
            $fDate                = "${data['from_report_year']}-${data['from_report_month']}-01";
            $tDate                = "${data['to_report_year']}-${data['to_report_month']}-01";
            $data['reportFrom']   = date('M Y', strtotime($fDate));
            $data['reportTo']     = date('M Y', strtotime($tDate));
            $data['report_range'] = $data['reportFrom'] . ' to ' . $data['reportTo'];
        }
        $data = mapData($map, $data);
        return $data;
    }
    private function reliveDataMap($data = [])
    {
        $map = ['reliveDate' => 'effect_from'];
        if (!checkValue($data, 'effect_from')) {
            $data['effect_from'] = $data['died_on'];
        }
        $data['effect_from'] = date('M Y', strtotime($data['effect_from']));
        return mapData($map, $data);
    }

    protected function getGift($id)
    {
        $data = $this->gift_repo->findById($id);
        $map  = array('distributionDetail' => 'distribution_detail', 'receivedDate' => 'received_date', 'deliveryDate' => 'delivery_date');
        $data = mapData($map, $data);
        return $data;
    }

    protected function getChildReport($id)
    {
        $data                 = $this->childReportRepo->findById($id);
        $data['profileImage'] = converBaseImage($data['profile_img_path']);
        $map                  = array('childName' => 'name', 'childId' => 'child_id');
        $data['brief']        = $data['src_content']->brief ? $data['src_content']->{'brief'} : '';
        $data                 = mapData($map, $data);
        return $data;
    }

    protected function getChurchReport($id)
    {
        $data                = $this->churchReortRepo->getDetails($id);
        $res                 = $this->churchRepo->findDetails($data['church_fk_id']);
        $data                = array_merge($data, $res);
        $data['reportRange'] = '';
        if (isset($data['from_date']) || isset($data['to_date'])) {
            $data['reportFrom']  = date('M Y', strtotime($data['from_date']));
            $data['reportTo']    = date('M Y', strtotime($data['to_date']));
            $data['reportRange'] = $data['reportFrom'] . ' to ' . $data['reportTo'];
        }
        return $data;
    }

    protected function getChild($id)
    {
        $data                 = $this->child_repo->findBasic($id);
        $data['profileImage'] = converBaseImage($data['profile_img_path']);
        $map                  = array('childName' => 'name', 'childId' => 'child_id');
        $data                 = mapData($map, $data);
        return $data;
    }
    private function getStaffDetails($aId, $address = false, $keyM = '', $isFamily = false, $isFull = false)
    {
        if (!$aId) {
            return [];
        }
        $id = $aId;
        if (!$isFamily) {
            $fun                            = $isFull ? 'findDetails' : 'findBasic';
            $data                           = $this->staff_repository->{$fun}($id);
            $id                             = $data['id'];
            $data['staffEmpcodeWithSpouce'] = $data['staff_emp_id'];
            $data['staffWithSpouceName']    = $data['fullName'];
            $data['profileImage']           = converBaseImage($data['family_img_path'] ?? ($data['profile_img_path'] ?? ''));
        } else {
            $resData                        = $this->staff_repository->findAllByIN($id);
            $data                           = $resData[0] ? $resData[0] : [];
            $id                             = $data['id'] ?? '';
            $name                           = $data['fullName'] ? $data['fullName'] : '';
            $data['staffEmpcodeWithSpouce'] = join(" & ", [$data['staff_emp_id'], $resData[1]['staff_emp_id']]);
            $data['staffWithSpouceName']    = join(" & ", [$data['fullName'], $resData[1]['fullName']]);
            $data['profileImage']           = converBaseImage($data['family_img_path'] ?? ($data['profile_img_path'] ?? ''));
        }
        $map               = array('staffName' . $keyM => 'fullName', 'staffEmpCode' . $keyM => 'staff_emp_id', 'departmentName' . $keyM => 'dName', 'mobileNo' . $keyM => 'mobile_no', 'zoneName' . $keyM => 'zoneName');
        $data              = mapData($map, $data);
        $data['staffName'] = $data['staffName' . $keyM] . ' ' . $data['last_name'];
        if ($address) {
            $resAd                = $this->staff_addr_repository->findAddressDetail(true, ['staff_fk_id' => $id, 'isPresent' => 1]) ?? [];
            $address              = $resAd[0] ?? [];
            $data['place']        = '';
            $data['staffAddress'] = '';
            if (!empty($address)) {
                $adr                  = $address[0] ?? $address;
                $data['staffAddress'] = $this->addressMap($adr);
                $data['place']        = $data['fieldName'] ? $data['fieldName'] : $adr['pName'];
            }
        }
        return $data;
    }

    private function addressMap($adr)
    {
        $addrArray = [$adr['street'] ?? '', $adr['address'] ?? '', $adr['districtName'] ? '<br>' . $adr['districtName'] : '', $adr['stateName'] ? '<br>' . $adr['stateName'] : '', $adr['countryName'], $adr['pincode'] ? '- ' . $adr['pincode'] : ''];
        return implode(',', array_filter($addrArray, 'strlen'));
    }

    public function getSponsorDetails($id, $address = false)
    {
        $map                    = array('sponsorName' => 'fullName', 'sponsorId' => 'sponsor_id', 'sponsorMobileNo' => 'mobile_no', 'sponsorEmailId' => 'email_id', 'promoName' => 'promotionalName');
        $data                   = $this->sponsor_repository->getDetails($id);
        $data['sponsorAddress'] = $this->addressMap($data);
        return mapData($map, $data);
    }

}
