<?php

namespace App\Controllers\Staff;

use Core\Controllers\BaseController;
use Core\Controllers\DMLController;
use App\Domain\Staff\Staff;
use App\Domain\Staff\Staff_attendence;
use App\Infrastructure\Persistence\Staff\SQLStaff_attendenceRepository;
use App\Infrastructure\Persistence\Staff\SQLStaffRepository;

class StaffController extends BaseController
{
    use DMLController;
    private $repository;
    private $attendanceRepo;
    private $userAgentHepler;
    public function __construct()
    {
        $this->initializeFunction();
        $this->repository = new SQLStaffRepository();
        $this->attendanceRepo = new SQLStaff_attendenceRepository();
    }
    public function save()
    {
        $data = $this->getDataFromUrl('json');
        $attendance = $data['attendance'] ?? [];
        if (checkValue($data, 'id')) {
            $this->repository->save(new Staff($data));
            $attendance = $this->attendanceRepo->update('school_fk_id', $attendance);
        } else {
            $id = $this->repository->insert(new staff($data));
            $attendance['staff_fk_id'] = $id;
            $this->attendanceRepo->insert(new Staff_attendence($attendance));
        }
        return $this->message(200, $data, "successFull");
    }

    public function staffAttendence()
    {
        $req = $this->getDataFromUrl('json');
        if (checkValue($req, 'finger_print')) {
            $biometric = password_hash($req['finger_print'],PASSWORD_BCRYPT);
            print_r($biometric);
        }
        return;
    }

    public function Search($terms, $where)
    {
        if ($this->reqMethod == 'get') {
            $data = [];
            $ftbl = [];
            if ($where) {
                $ftbl = json_decode(utf8_decode(urldecode($where)));
            }
            $terms = $terms == 'null' ? '' : $terms;
            //if (!empty($terms)) {
            $data = $this->repository->search($terms, $ftbl);
            //}
            return $this->message(200, $data, 'Success');
        } else {
            return $this->message(400, null, 'Method Not Allowed');
        }
    }
}
