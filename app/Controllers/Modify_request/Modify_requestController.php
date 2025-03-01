<?php

namespace Core\Controllers\Modify_request;

use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use Core\Domain\Modify_request\Modify_request;
use Core\Infrastructure\Persistence\Modify_request\SQLModify_requestRepository;
use Core\Infrastructure\Persistence\Modify_request\SQLModify_request_queryRepository;
use Core\Models\Utility\UtilityModel;

class Modify_requestController extends BaseController
{
    use DMLController;
    private $repository;
    private $userAgentHepler;
    private $staff_repo;
    private $child_repo;
    private $churchRepo;
    private $sponsorship_repo;
    private $donationRepo;
    private $queryRepo;

    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLModify_requestRepository();
        $this->queryRepo  = new SQLModify_request_queryRepository();
    }

    public function getList($tblLazy)
    {
        $ftbl;
        if ($tblLazy) {
            $ftbl = json_decode(utf8_decode(urldecode($tblLazy)));
        }
        $user_id = $this->userData->user_id ?? '';
        $data    = $this->repository->findAllByUserPagination($ftbl, $user_id);
        return $this->message(200, $data, 'Success');
    }
    public function getDetails($id)
    {
        $data          = $this->repository->findById($id);
        $data['query'] = $this->queryRepo->findAllByWhere(['modify_request_fk_id' => $id]);
        return $this->message(200, $data);
    }
    public function save()
    {
        $data               = $this->getDataFromUrl('json');
        $user_id            = $this->userData->user_id ?? 1;
        $userName           = $this->userData->fname ?? 'Admin';
        $data['created_by'] = $user_id;
        $status             = isset($data['status']) ? (int) $data['status'] : 2;
        if ($status == 1 || $status == 3) {
            $data['action_by'] = $user_id;
        }
        if (!checkValue($data, 'request_data')) {
            return $this->message(400, '', 'Request Data is Required');
        }
        // $req_d = $data['request_data'];
        // if (is_array($req_d)) {
        //     if (!isset($req_d[0])) {
        //         $req_d['created_by'] = $user_id;
        //         $req_d['created_byName'] = $userName;
        //     } else {
        //         foreach ($req_d as $key => &$v) {
        //             $v['created_by'] = $user_id;
        //         }
        //     }
        // } else if (is_object($req_d)) {
        //     $req_d->created_by = $user_id;
        // }
        if ($status == 4 || $status == 2) {
            if (isset($data['id']) && $data['id']) {
                $rdata = $this->repository->findById($data['id']);
                if (!empty($rdata) && ((int) $rdata['status'] == 1 || (int) $rdata['status'] == 3)) {
                    return $this->message(400, null, 'Already Actioned');
                }
            }
        }
        startDbTrans();
        $result;
        if (checkValue($data, 'id')) {
            $result = $this->repository->insert(new Modify_request($data));
        } else {
            $result = $this->repository->save(new Modify_request($data));
        }
        $this->updateRequest($data, $status == 2 ? $result : false);
        $res = applyDbChanges();
        return $this->message($res ? 200 : 400, $data, $res ? 'Success' : 'Unable to save Data');
    }

    public function reject($id)
    {
        $data = $this->repository->findById($id);
        if (empty($data)) {
            return $this->message(400, $data, 'Request Not Found');
        }
        $status = $data['status'] ?? null;
        if ($status == 1 || (int) $status == 3) {
            return $this->message(400, $data, 'Already Actioned');
        }
        startDbTrans();
        $this->updateRequest($data, 0);
        $data['status'] = 3;
        $this->repository->save($data);
        $res = applyDbChanges();
        return $this->message($res ? 200 : 400, $data, $res ? 'Success' : 'Unable to save Data');
    }

    private function updateRequest($data, $bool)
    {
        $type         = (int) $data['module_id'];
        $updateData   = array('modify_request' => $bool);
        $cond         = $data['ref_id'];
        $request_data = $data['request_data'] ?? '';
        $res          = true;
        if (checkValue($data, 'ref_id')) {
            switch ($type) {
                case 1:
                    $res = $this->tblUpdate($cond, $updateData);
                    break;
                case 4:
                    $res = $this->tblUpdate($cond, $updateData);
                    break;
                case 6:
                    $res = $this->tblUpdate($cond, $updateData, 'sponsorship', 'id');
                    $req = (array) $request_data;
                    if (isset($req['allotmentData'])) {
                        foreach ($req['allotmentData'] as $key => $v) {
                            $v   = (array) $v;
                            $mod = (int) $v['sponsorship_module'];
                            if ($mod == 1) {
                                $res = $this->tblUpdate($v['ref_id'], $updateData);
                            } else if ($mod == 2) {
                                $res = $this->tblUpdate($v['ref_id'], $updateData, 'child', 'child_id');
                            }
                        }
                    }
                    break;
                case 7:
                    $res = $this->tblUpdate($cond, $updateData, 'child', 'child_id');
                    break;
                case 13:
                    $res = $this->tblUpdate($cond, $updateData, 'church', 'church_id');
                    break;
                case 19:
                    $res = $this->tblUpdate($cond, $updateData, 'asset', 'asset_id');
                    break;
                case 21:
                    $res = $this->tblUpdate($cond, $updateData, 'activity', 'id');
                    break;
                case 23:
                    $res = $this->tblUpdate($cond, $updateData, 'donation', 'donation_id');
                    break;
                case 29:
                    $res = $this->tblUpdate($cond, $updateData, 'account', 'account_code');
                    break;
            }
        }
        return $res;
    }

    protected function tblUpdate($id, $data, $tbl = 'staff', $key = 'staff_emp_id', $dbProfile = 'master')
    {
        $utilityRepo = new UtilityModel($dbProfile);
        return $utilityRepo->updateData($tbl, $data, [$key => $id]);
    }
}
