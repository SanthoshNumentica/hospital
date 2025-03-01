<?php

namespace Core\Libraries;

class PDFGenerator
{
    private $response;
    protected $pdf;
    public function __construct()
    {
        helper('Core\Helpers\Date');
        $this->response = \Config\Services::response();
    }
    public function create($type, $data, $doc_name = 'invoice',$is_html=true)
    {
        $html        = '';
        $section     = [];
        $j_url       = '';
        $dateCol     = [];
        $paperFormat = '';

        switch ($type) {
            case 'invoice':
                $j_url = BASEURL . '/templates/invoice.txt';
                break;
        }

        $html = file_get_contents($j_url);
        $replacements = [
            '{receipt_no}'         => '1' ?? '',
            '{date}'               => $data['invoice_date'],
            '{amount_in_rupees}'   => $data['total_amount'] ?? 0,
            '{patient_name}'        => $data['patient_fullName'] ?? '',
            '{data}'               => 'Root Canal Treatment',
            '{patient_id}'          =>$data['patient_id'],
            '{address}'             =>$data['address']
        ];
        $html = str_replace(array_keys($replacements), array_values($replacements), $html);
        if($is_html){
            return $html;
        }
        $pdf = new PDFMaker($html, $paperFormat, '', $section, $dateCol, '');
        $pdf->genFooter($data, $data['pdf_footer'] ?? '');
        return $pdf->create($data, $doc_name);
    }
    public function genByTemp($data, $output = 'd', $doc_name = 'attament')
    {
        $pdf_content = $data['pdf_content'];
        // $pdf_content = $this->genPdfHtmlContentWithHeader($data['pdf_content'], $data['pdf_header'] ?? '', $data['pdf_footer'] ?? '');
        $pdf         = new PDFMaker($pdf_content, 'A4-P');
        return $pdf->create($pdf_content, $doc_name, $output);
    }

    public function genPdfHtmlContentWithHeader($body, $header = '', $footer = '')
    {
        return $this->mapContentWithHtml($body, $header, $footer);
    }

    protected function mapContentWithHtml($body, $header = '', $footer = '')
    {
        $st = '<html><head> <meta http-equiv="content-type" content="text/html; charset=utf-8" />  <meta charset="utf-8"><style media="all">
        html, body, p, h1, h2, h3, td, span {
            font-family: freesans;
            letter-spacing : 0px;
            color : black;
            font-size : 18px;
            text-align :justify;word-spacing : 3px
            font-variant :rubys;
        color: rgb(34, 34, 34) text-align: start;}table {page-break-inside: auto;}
        font-comicsansms{
            font-family: comicsansms !important;
        }
       </style>';
        $content    = $st . $header . $body . $footer;
        $content    = htmlspecialchars_decode($content . '</html>');
        $pattern    = array();
        $pattern[0] = "/<\/figure>/";
        $pattern[1] = "/<figure[^>]*>/";
        $content    = preg_replace($pattern, '', $content);
        $content    = str_replace('data:image/jpeg;base64,', '@', $content);
        $content    = str_replace('data:image/png;base64,', '@', $content);
        $content    = str_replace('data:image/gif;base64,', '@', $content);
        $content    = str_replace('data:image/bmp;base64,', '@', $content);
        return $content;
    }
}
