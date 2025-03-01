<?php
namespace Core\Libraries;

use Core\Libraries\Sms;
use Core\Models\Utility\UtilityModel;

class Otp
{
    private $UtilityModel;
    private $sms;
    public function __construct()
    {
        helper('Core\Helpers\Utility');
        $this->UtilityModel = new UtilityModel();
        $this->sms          = new Sms();
    }

    public function generate($mobile_no, $type = 'LOGIN')
    {
        // delete all esiting otp
        $mobile_no = trimMobileNumber($mobile_no, true);
        //add country code
        $mobile_no = '91' . $mobile_no;
        $this->UtilityModel->deleteData('otp', ['mobile_no' => $mobile_no]);
        // chekk
        $otp = ENVIRONMENT == 'production' ?  generateOTP(4) : '5907';
        $this->UtilityModel->replaceData('otp', ['mobile_no' => $mobile_no, 'otp' => $otp, 'created_at' => date("Y-m-d H:i:s")]);
        $smsId = 1;
        switch (strtoupper($type)) {
            default:
                $smsId = 1;
                break;
        }
        return ENVIRONMENT == 'production' ? $this->sms->send($smsId, ['otp' => $otp, 'mobile_no' => $mobile_no], true) : ['result' => true,'response' => true];
    }
    public function reSend($mobile_no, $type)
    {
        $result    = ['result' => false, 'response' => ''];
        $mobile_no = trimMobileNumber($mobile_no, true);
        //add country code
        $mobile_no = '91' . $mobile_no;
        $otpData   = $this->UtilityModel->getOtp($mobile_no)[0] ?? [];
        if (empty($otpData)) {
            $result['response'] = 'Otp Not generated';
            return $result;
        }
        $smsId = 1;
        switch (strtoupper($type)) {
            default:
                $smsId = 1;
                break;
        }
        $otp = $otpData['otp'];
        $this->UtilityModel->replaceData('otp', ['mobile_no' => $mobile_no, 'otp' => $otp, 'created_at' => date("Y-m-d H:i:s")]);
            return $this->sms->send($smsId, ['otp' => $otp, 'mobile_no' => $mobile_no], true);
        }

        public function verifyOtp($mobile_no, $otp)
    {
            $authConfig = new \Config\AppConstant();
            $result     = ['result' => false, 'response' => ''];
            $mobile_no  = trimMobileNumber($mobile_no, true);
            //add country code
            $mobile_no = '91' . $mobile_no;
            $otpData   = $this->UtilityModel->getOtp($mobile_no)[0] ?? [];

            if (empty($otpData)) {
                $result['response'] = 'Otp Not generated';
            } else {
                $masterOtp = '';
                $strTime   = strtotime($otpData["created_at"]);
                if($otp != $otpData['otp']){
                    //check master OTP
                    $otpS=$this->UtilityModel->executeQuery("Select value from settings where description = ?",['MASTER_OTP'])[0] ?? [];
                    $masterOtp=(int) $otpS['value'] ?? '';
                    if ((int) $otp != $masterOtp) {
                        $result['response'] = 'Otp Mismatch';
                        $strikes            = $otpData["otp_tries"] + 1;
                        $db                 = $this->UtilityModel->executeNoResult("UPDATE otp SET otp_tries=? WHERE mobile_no=?", [$strikes, $mobile_no]);
                        return $result;
                    }
                    $strTime=strtotime("now");
                }
                 $validTill = $strTime + ($authConfig->OTP_VALID * 60);
                 if (strtotime("now") >= $validTill) {
                    $result['response'] = 'Otp Expired';
                } else {
                    $result['result']   = true;
                    $result['response'] = 'Otp Verified';
                    $this->UtilityModel->deleteData('otp', ['mobile_no' => $mobile_no]);
                }
            }
            return $result;
        }

    }