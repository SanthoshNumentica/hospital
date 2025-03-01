<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCityTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'cityName' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'state_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('city');

        // Insert initial data
        $this->db->table('city')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'cityName' => 'Rajapalayam',
    'state_id' => '1',
    'status' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'cityName' => 'Chathirapatti',
    'state_id' => '1',
    'status' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'cityName' => 'Tirunel Veli',
    'state_id' => '1',
    'status' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'cityName' => 's.ramalinga puram',
    'state_id' => '1',
    'status' => '1',
  ),
  4 => 
  array (
    'id' => '5',
    'cityName' => 'sivagri',
    'state_id' => '1',
    'status' => '1',
  ),
  5 => 
  array (
    'id' => '6',
    'cityName' => 'krishna puram',
    'state_id' => '1',
    'status' => '1',
  ),
  6 => 
  array (
    'id' => '7',
    'cityName' => 'kanni devan patty',
    'state_id' => '1',
    'status' => '1',
  ),
  7 => 
  array (
    'id' => '8',
    'cityName' => 'srivilli puthur',
    'state_id' => '1',
    'status' => '1',
  ),
  8 => 
  array (
    'id' => '9',
    'cityName' => 'muthanathi',
    'state_id' => '1',
    'status' => '1',
  ),
  9 => 
  array (
    'id' => '10',
    'cityName' => 'v.puthur',
    'state_id' => '1',
    'status' => '1',
  ),
  10 => 
  array (
    'id' => '11',
    'cityName' => 'sankaran kovil',
    'state_id' => '1',
    'status' => '1',
  ),
  11 => 
  array (
    'id' => '12',
    'cityName' => 'kannar patty',
    'state_id' => '1',
    'status' => '1',
  ),
  12 => 
  array (
    'id' => '13',
    'cityName' => 'vaithiya lingam puram',
    'state_id' => '1',
    'status' => '1',
  ),
  13 => 
  array (
    'id' => '14',
    'cityName' => 'pandicheery',
    'state_id' => '1',
    'status' => '1',
  ),
  14 => 
  array (
    'id' => '15',
    'cityName' => 'vaithiyalingam puram',
    'state_id' => '1',
    'status' => '1',
  ),
  15 => 
  array (
    'id' => '16',
    'cityName' => 'MADURAI',
    'state_id' => '1',
    'status' => '1',
  ),
  16 => 
  array (
    'id' => '17',
    'cityName' => 'MOOKKR NATHAM',
    'state_id' => '1',
    'status' => '1',
  ),
  17 => 
  array (
    'id' => '18',
    'cityName' => 'RAJAPLAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  18 => 
  array (
    'id' => '19',
    'cityName' => 'SANKAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  19 => 
  array (
    'id' => '20',
    'cityName' => 'CHITRA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  20 => 
  array (
    'id' => '21',
    'cityName' => 'PULLIYANKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  21 => 
  array (
    'id' => '22',
    'cityName' => 'SUNDHARA RAJA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  22 => 
  array (
    'id' => '23',
    'cityName' => 'SOLLAI SERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  23 => 
  array (
    'id' => '24',
    'cityName' => 'KRISHNAN KOVIL',
    'state_id' => '1',
    'status' => '1',
  ),
  24 => 
  array (
    'id' => '25',
    'cityName' => 'SANKARA PANDIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  25 => 
  array (
    'id' => '26',
    'cityName' => 'KOVIL PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  26 => 
  array (
    'id' => '27',
    'cityName' => 'WATRAP',
    'state_id' => '1',
    'status' => '1',
  ),
  27 => 
  array (
    'id' => '28',
    'cityName' => 'PARUVAKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  28 => 
  array (
    'id' => '29',
    'cityName' => 'KOVILOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  29 => 
  array (
    'id' => '30',
    'cityName' => 'AYYANA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  30 => 
  array (
    'id' => '31',
    'cityName' => 'IDAIYAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  31 => 
  array (
    'id' => '32',
    'cityName' => 'SUNDRA PANDIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  32 => 
  array (
    'id' => '33',
    'cityName' => 'VIJAYA RENGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  33 => 
  array (
    'id' => '34',
    'cityName' => 'AAVARANTHAI',
    'state_id' => '1',
    'status' => '1',
  ),
  34 => 
  array (
    'id' => '35',
    'cityName' => 'SUNDRA RAJA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  35 => 
  array (
    'id' => '36',
    'cityName' => 'SETHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  36 => 
  array (
    'id' => '37',
    'cityName' => 'VASU DEVA NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  37 => 
  array (
    'id' => '38',
    'cityName' => 'AALANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  38 => 
  array (
    'id' => '39',
    'cityName' => 'SOLLA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  39 => 
  array (
    'id' => '40',
    'cityName' => 'KOOMAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  40 => 
  array (
    'id' => '41',
    'cityName' => 'CHITTI KINARU',
    'state_id' => '1',
    'status' => '1',
  ),
  41 => 
  array (
    'id' => '42',
    'cityName' => 'SEITHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  42 => 
  array (
    'id' => '43',
    'cityName' => 'NALLA MANGALAM',
    'state_id' => '1',
    'status' => '1',
  ),
  43 => 
  array (
    'id' => '44',
    'cityName' => 'SAMSIKA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  44 => 
  array (
    'id' => '45',
    'cityName' => 'THENKARAI',
    'state_id' => '1',
    'status' => '1',
  ),
  45 => 
  array (
    'id' => '46',
    'cityName' => 'NAKKANERRI',
    'state_id' => '1',
    'status' => '1',
  ),
  46 => 
  array (
    'id' => '47',
    'cityName' => 'JAMEEN  KOLLAM KONDAN',
    'state_id' => '1',
    'status' => '1',
  ),
  47 => 
  array (
    'id' => '48',
    'cityName' => 'K.PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  48 => 
  array (
    'id' => '49',
    'cityName' => 'THENKARI',
    'state_id' => '1',
    'status' => '1',
  ),
  49 => 
  array (
    'id' => '50',
    'cityName' => 'AVATAMPATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  50 => 
  array (
    'id' => '52',
    'cityName' => 'SRIVILLI PUHTUR',
    'state_id' => '1',
    'status' => '1',
  ),
  51 => 
  array (
    'id' => '53',
    'cityName' => 'MAMSAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  52 => 
  array (
    'id' => '55',
    'cityName' => 'SAMUSIGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  53 => 
  array (
    'id' => '56',
    'cityName' => 'SENGOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  54 => 
  array (
    'id' => '57',
    'cityName' => 'VEERANAM',
    'state_id' => '1',
    'status' => '1',
  ),
  55 => 
  array (
    'id' => '58',
    'cityName' => 'KODAIKANAL',
    'state_id' => '1',
    'status' => '1',
  ),
  56 => 
  array (
    'id' => '59',
    'cityName' => 'VADUKA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  57 => 
  array (
    'id' => '60',
    'cityName' => 'DEVI PATTINAM',
    'state_id' => '1',
    'status' => '1',
  ),
  58 => 
  array (
    'id' => '61',
    'cityName' => 'REDDIYA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  59 => 
  array (
    'id' => '62',
    'cityName' => 'CHATRA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  60 => 
  array (
    'id' => '63',
    'cityName' => 'UCILLLAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  61 => 
  array (
    'id' => '64',
    'cityName' => 'SHIVA YANAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  62 => 
  array (
    'id' => '65',
    'cityName' => 'VEPPANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  63 => 
  array (
    'id' => '66',
    'cityName' => 'AYYANAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  64 => 
  array (
    'id' => '67',
    'cityName' => 'PALLI KINARU',
    'state_id' => '1',
    'status' => '1',
  ),
  65 => 
  array (
    'id' => '68',
    'cityName' => 'KARIVALM',
    'state_id' => '1',
    'status' => '1',
  ),
  66 => 
  array (
    'id' => '69',
    'cityName' => 'KILAVI KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  67 => 
  array (
    'id' => '70',
    'cityName' => 'THOMBAKKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  68 => 
  array (
    'id' => '71',
    'cityName' => 'KALINGAPERRIY PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  69 => 
  array (
    'id' => '72',
    'cityName' => 'MURUMPU',
    'state_id' => '1',
    'status' => '1',
  ),
  70 => 
  array (
    'id' => '73',
    'cityName' => 'PORUNGALATHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  71 => 
  array (
    'id' => '74',
    'cityName' => 'ADTIYMIL ROAD',
    'state_id' => '1',
    'status' => '1',
  ),
  72 => 
  array (
    'id' => '75',
    'cityName' => 'ARULACHI',
    'state_id' => '1',
    'status' => '1',
  ),
  73 => 
  array (
    'id' => '76',
    'cityName' => 'PANNAIOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  74 => 
  array (
    'id' => '77',
    'cityName' => 'THALAVAI PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  75 => 
  array (
    'id' => '78',
    'cityName' => 'SOUTH VENGA NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  76 => 
  array (
    'id' => '79',
    'cityName' => 'KOTHANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  77 => 
  array (
    'id' => '80',
    'cityName' => 'OPPANAYAL PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  78 => 
  array (
    'id' => '81',
    'cityName' => 'MELA KOODANGI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  79 => 
  array (
    'id' => '82',
    'cityName' => 'MELA GOPALAPURAM,',
    'state_id' => '1',
    'status' => '1',
  ),
  80 => 
  array (
    'id' => '83',
    'cityName' => 'GOTHAINACCHIYARPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  81 => 
  array (
    'id' => '84',
    'cityName' => 'KALASALINGAM UNIVERSITY',
    'state_id' => '1',
    'status' => '1',
  ),
  82 => 
  array (
    'id' => '85',
    'cityName' => 'THIRUNALVELLI',
    'state_id' => '1',
    'status' => '1',
  ),
  83 => 
  array (
    'id' => '86',
    'cityName' => 'SINGILLI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  84 => 
  array (
    'id' => '87',
    'cityName' => 'SOKKAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  85 => 
  array (
    'id' => '88',
    'cityName' => 'RAJAPALA',
    'state_id' => '1',
    'status' => '1',
  ),
  86 => 
  array (
    'id' => '89',
    'cityName' => 'KANNIDEVAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  87 => 
  array (
    'id' => '90',
    'cityName' => 'SANKARA PANDIYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  88 => 
  array (
    'id' => '91',
    'cityName' => 'AASILA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  89 => 
  array (
    'id' => '92',
    'cityName' => 'SAKTHI NAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  90 => 
  array (
    'id' => '93',
    'cityName' => 'N.PUTUR',
    'state_id' => '1',
    'status' => '1',
  ),
  91 => 
  array (
    'id' => '94',
    'cityName' => 'NADHI KUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  92 => 
  array (
    'id' => '95',
    'cityName' => 'THEN MALAI',
    'state_id' => '1',
    'status' => '1',
  ),
  93 => 
  array (
    'id' => '96',
    'cityName' => 'GOTHAI NACCIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  94 => 
  array (
    'id' => '97',
    'cityName' => 'IYYAN KARISAL KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  95 => 
  array (
    'id' => '98',
    'cityName' => 'MURAMBU',
    'state_id' => '1',
    'status' => '1',
  ),
  96 => 
  array (
    'id' => '99',
    'cityName' => 'MAMSA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  97 => 
  array (
    'id' => '100',
    'cityName' => 'sivanayendipatty',
    'state_id' => '1',
    'status' => '1',
  ),
  98 => 
  array (
    'id' => '101',
    'cityName' => 'sivanayendipatty',
    'state_id' => '1',
    'status' => '1',
  ),
  99 => 
  array (
    'id' => '102',
    'cityName' => 'AGTHAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  100 => 
  array (
    'id' => '103',
    'cityName' => 'EDIYENKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  101 => 
  array (
    'id' => '104',
    'cityName' => 'SANGUMAMPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  102 => 
  array (
    'id' => '105',
    'cityName' => 'VIRDHIRNAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  103 => 
  array (
    'id' => '106',
    'cityName' => 'SANKARPANDIYAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  104 => 
  array (
    'id' => '107',
    'cityName' => 'RAJAPALYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  105 => 
  array (
    'id' => '108',
    'cityName' => 'THIRUVENGATAM',
    'state_id' => '1',
    'status' => '1',
  ),
  106 => 
  array (
    'id' => '109',
    'cityName' => 'VALLAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  107 => 
  array (
    'id' => '110',
    'cityName' => 'THENKASI',
    'state_id' => '1',
    'status' => '1',
  ),
  108 => 
  array (
    'id' => '111',
    'cityName' => 'IYAN KARISAL KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  109 => 
  array (
    'id' => '112',
    'cityName' => 'PULLIYAN KUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  110 => 
  array (
    'id' => '113',
    'cityName' => 'KEELAVI KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  111 => 
  array (
    'id' => '114',
    'cityName' => 'VALLAYA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  112 => 
  array (
    'id' => '115',
    'cityName' => 'PEYAM PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  113 => 
  array (
    'id' => '116',
    'cityName' => 'MUTHUSAMY PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  114 => 
  array (
    'id' => '117',
    'cityName' => 'PILLAIYAR KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  115 => 
  array (
    'id' => '118',
    'cityName' => 'VELAYUTHAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  116 => 
  array (
    'id' => '119',
    'cityName' => 'SANGAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  117 => 
  array (
    'id' => '120',
    'cityName' => 'THESIKA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  118 => 
  array (
    'id' => '121',
    'cityName' => 'KEEA RAJAKULARAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  119 => 
  array (
    'id' => '122',
    'cityName' => 'PALAYA SENNA KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  120 => 
  array (
    'id' => '123',
    'cityName' => 'SIVAGIRI',
    'state_id' => '1',
    'status' => '1',
  ),
  121 => 
  array (
    'id' => '124',
    'cityName' => 'ELANDHAI  KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  122 => 
  array (
    'id' => '125',
    'cityName' => 'KARIVALLAM',
    'state_id' => '1',
    'status' => '1',
  ),
  123 => 
  array (
    'id' => '126',
    'cityName' => 'THENI',
    'state_id' => '1',
    'status' => '1',
  ),
  124 => 
  array (
    'id' => '127',
    'cityName' => 'PULIYENKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  125 => 
  array (
    'id' => '128',
    'cityName' => 'SENTHATIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  126 => 
  array (
    'id' => '129',
    'cityName' => 'KURINJIYA KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  127 => 
  array (
    'id' => '130',
    'cityName' => 'SITHAMANAYAKKAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  128 => 
  array (
    'id' => '131',
    'cityName' => 'VAITHIYA LINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  129 => 
  array (
    'id' => '132',
    'cityName' => 'SANKARANKOVIL',
    'state_id' => '1',
    'status' => '1',
  ),
  130 => 
  array (
    'id' => '133',
    'cityName' => 'METTU VADAKARAI',
    'state_id' => '1',
    'status' => '1',
  ),
  131 => 
  array (
    'id' => '134',
    'cityName' => 'KEEELA RAJAKULA RAMAN PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  132 => 
  array (
    'id' => '135',
    'cityName' => 'SENNA KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  133 => 
  array (
    'id' => '136',
    'cityName' => 'ALANGULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  134 => 
  array (
    'id' => '137',
    'cityName' => 'CHITRA PATY',
    'state_id' => '1',
    'status' => '1',
  ),
  135 => 
  array (
    'id' => '138',
    'cityName' => 'S.RAMA LINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  136 => 
  array (
    'id' => '139',
    'cityName' => 'MELAVARUGANAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  137 => 
  array (
    'id' => '140',
    'cityName' => 'SOLAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  138 => 
  array (
    'id' => '141',
    'cityName' => 'SUNDHRA NACCHIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  139 => 
  array (
    'id' => '142',
    'cityName' => 'PONDICHERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  140 => 
  array (
    'id' => '143',
    'cityName' => 'VAVANUYAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  141 => 
  array (
    'id' => '144',
    'cityName' => 'SATTUR',
    'state_id' => '1',
    'status' => '1',
  ),
  142 => 
  array (
    'id' => '145',
    'cityName' => 'SOLAI SERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  143 => 
  array (
    'id' => '146',
    'cityName' => 'KALANGA PERI PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  144 => 
  array (
    'id' => '147',
    'cityName' => 'KEELA RAJAKULA RAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  145 => 
  array (
    'id' => '148',
    'cityName' => 'KEELA RAJAKULA RAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  146 => 
  array (
    'id' => '149',
    'cityName' => 'THOMBAKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  147 => 
  array (
    'id' => '150',
    'cityName' => 'THESIGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  148 => 
  array (
    'id' => '151',
    'cityName' => 'RAYAGIRI',
    'state_id' => '1',
    'status' => '1',
  ),
  149 => 
  array (
    'id' => '152',
    'cityName' => 'KEELARAJAKULARAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  150 => 
  array (
    'id' => '153',
    'cityName' => 'MILKRISHNNAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  151 => 
  array (
    'id' => '154',
    'cityName' => 'MUDHUKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  152 => 
  array (
    'id' => '155',
    'cityName' => 'KOOGANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  153 => 
  array (
    'id' => '156',
    'cityName' => 'SUNDRA PANDIYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  154 => 
  array (
    'id' => '157',
    'cityName' => 'VIRUTHU NAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  155 => 
  array (
    'id' => '158',
    'cityName' => 'APPIYANAYAGANPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  156 => 
  array (
    'id' => '159',
    'cityName' => 'PATTATHURU',
    'state_id' => '1',
    'status' => '1',
  ),
  157 => 
  array (
    'id' => '160',
    'cityName' => 'KUVALIYAKANI',
    'state_id' => '1',
    'status' => '1',
  ),
  158 => 
  array (
    'id' => '161',
    'cityName' => 'USILAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  159 => 
  array (
    'id' => '162',
    'cityName' => 'TENKASI',
    'state_id' => '1',
    'status' => '1',
  ),
  160 => 
  array (
    'id' => '163',
    'cityName' => 'VAVANUYA NAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  161 => 
  array (
    'id' => '164',
    'cityName' => 'KARIVALAM',
    'state_id' => '1',
    'status' => '1',
  ),
  162 => 
  array (
    'id' => '165',
    'cityName' => 'VADAMALAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  163 => 
  array (
    'id' => '166',
    'cityName' => 'KOLOSALI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  164 => 
  array (
    'id' => '167',
    'cityName' => 'MPK KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  165 => 
  array (
    'id' => '168',
    'cityName' => 'CHOLAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  166 => 
  array (
    'id' => '169',
    'cityName' => 'W.PUTHU  PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  167 => 
  array (
    'id' => '170',
    'cityName' => 'AYYAAN KOLLAM KONDAN',
    'state_id' => '1',
    'status' => '1',
  ),
  168 => 
  array (
    'id' => '171',
    'cityName' => 'THIRUGOTHAIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  169 => 
  array (
    'id' => '172',
    'cityName' => 'RAAJAPALAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  170 => 
  array (
    'id' => '173',
    'cityName' => 'KULASEKARPERI',
    'state_id' => '1',
    'status' => '1',
  ),
  171 => 
  array (
    'id' => '174',
    'cityName' => 'CHENNAI',
    'state_id' => '1',
    'status' => '1',
  ),
  172 => 
  array (
    'id' => '175',
    'cityName' => 'RAJPALAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  173 => 
  array (
    'id' => '176',
    'cityName' => 'CHOLLA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  174 => 
  array (
    'id' => '177',
    'cityName' => 'KEEALA RAJA KULARAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  175 => 
  array (
    'id' => '178',
    'cityName' => 'THIRUK KOTHAIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  176 => 
  array (
    'id' => '179',
    'cityName' => 'PREUMAL PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  177 => 
  array (
    'id' => '180',
    'cityName' => 'MURUGANKUMICHI',
    'state_id' => '1',
    'status' => '1',
  ),
  178 => 
  array (
    'id' => '181',
    'cityName' => 'SANGARAPANDIYAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  179 => 
  array (
    'id' => '182',
    'cityName' => 'SANGARAPANDIYAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  180 => 
  array (
    'id' => '183',
    'cityName' => 'THALAVAIPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  181 => 
  array (
    'id' => '184',
    'cityName' => 'KOTHAINAICHIAYPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  182 => 
  array (
    'id' => '185',
    'cityName' => 'MEENAKSHIPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  183 => 
  array (
    'id' => '186',
    'cityName' => 'VEPPAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  184 => 
  array (
    'id' => '187',
    'cityName' => 'CHITHANBARA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  185 => 
  array (
    'id' => '188',
    'cityName' => 'MPKPUTHU PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  186 => 
  array (
    'id' => '189',
    'cityName' => 'ANNPOORANIYAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  187 => 
  array (
    'id' => '190',
    'cityName' => 'SIVAKASI',
    'state_id' => '1',
    'status' => '1',
  ),
  188 => 
  array (
    'id' => '191',
    'cityName' => 'KALANGA PERRY PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  189 => 
  array (
    'id' => '192',
    'cityName' => 'VISWANATHA PERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  190 => 
  array (
    'id' => '193',
    'cityName' => 'TUTY-8',
    'state_id' => '1',
    'status' => '1',
  ),
  191 => 
  array (
    'id' => '194',
    'cityName' => 'ANDALPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  192 => 
  array (
    'id' => '195',
    'cityName' => 'VAGAIKULAMPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  193 => 
  array (
    'id' => '196',
    'cityName' => 'REDIYA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  194 => 
  array (
    'id' => '197',
    'cityName' => 'NEW SUBBLAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  195 => 
  array (
    'id' => '198',
    'cityName' => 'NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  196 => 
  array (
    'id' => '199',
    'cityName' => 'NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  197 => 
  array (
    'id' => '200',
    'cityName' => 'SAMYNATHAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  198 => 
  array (
    'id' => '201',
    'cityName' => 'OURAISAMIPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  199 => 
  array (
    'id' => '202',
    'cityName' => 'NALLA NAIYAGAMPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  200 => 
  array (
    'id' => '203',
    'cityName' => 'METUVADAKARI',
    'state_id' => '1',
    'status' => '1',
  ),
  201 => 
  array (
    'id' => '204',
    'cityName' => 'RAMANATHAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  202 => 
  array (
    'id' => '205',
    'cityName' => 'CHOKKANATHANPUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  203 => 
  array (
    'id' => '206',
    'cityName' => 'R.REDDIAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  204 => 
  array (
    'id' => '207',
    'cityName' => 'NAGANERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  205 => 
  array (
    'id' => '208',
    'cityName' => 'KOVILPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  206 => 
  array (
    'id' => '209',
    'cityName' => 'NALUVASAN KOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  207 => 
  array (
    'id' => '210',
    'cityName' => 'ACHUMTHIVARTHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  208 => 
  array (
    'id' => '211',
    'cityName' => 'S.RAMALINGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  209 => 
  array (
    'id' => '212',
    'cityName' => 'GOMATHI  MUTHU PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  210 => 
  array (
    'id' => '213',
    'cityName' => 'KALANGAPERI',
    'state_id' => '1',
    'status' => '1',
  ),
  211 => 
  array (
    'id' => '214',
    'cityName' => 'NALLA MANKALAM',
    'state_id' => '1',
    'status' => '1',
  ),
  212 => 
  array (
    'id' => '215',
    'cityName' => 'MILL KRISHNA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  213 => 
  array (
    'id' => '216',
    'cityName' => 'PUNALVELI',
    'state_id' => '1',
    'status' => '1',
  ),
  214 => 
  array (
    'id' => '217',
    'cityName' => 'DHESIKAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  215 => 
  array (
    'id' => '218',
    'cityName' => 'MILEKRISHNAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  216 => 
  array (
    'id' => '219',
    'cityName' => 'RAMACHANDRANPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  217 => 
  array (
    'id' => '220',
    'cityName' => 'KURINJIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  218 => 
  array (
    'id' => '221',
    'cityName' => 'PERUMAL PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  219 => 
  array (
    'id' => '222',
    'cityName' => 'CHATRAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  220 => 
  array (
    'id' => '223',
    'cityName' => 'ACHAM THAVILTHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  221 => 
  array (
    'id' => '224',
    'cityName' => 'N.PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  222 => 
  array (
    'id' => '225',
    'cityName' => 'MANKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  223 => 
  array (
    'id' => '226',
    'cityName' => 'OPPANAIYAL PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  224 => 
  array (
    'id' => '227',
    'cityName' => 'RAJAPLYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  225 => 
  array (
    'id' => '228',
    'cityName' => 'PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  226 => 
  array (
    'id' => '229',
    'cityName' => 'NARI KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  227 => 
  array (
    'id' => '230',
    'cityName' => 'KALINGA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  228 => 
  array (
    'id' => '231',
    'cityName' => 'KORUKAMM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  229 => 
  array (
    'id' => '232',
    'cityName' => 'KALLU PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  230 => 
  array (
    'id' => '233',
    'cityName' => 'PARUVA KUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  231 => 
  array (
    'id' => '234',
    'cityName' => 'MELA KODANGI PTTY',
    'state_id' => '1',
    'status' => '1',
  ),
  232 => 
  array (
    'id' => '235',
    'cityName' => 'MUTHU KUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  233 => 
  array (
    'id' => '236',
    'cityName' => 'NORTH VENGANALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  234 => 
  array (
    'id' => '237',
    'cityName' => 'MUDUKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  235 => 
  array (
    'id' => '238',
    'cityName' => 'MUDUGUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  236 => 
  array (
    'id' => '239',
    'cityName' => 'VALAVANTHAN PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  237 => 
  array (
    'id' => '240',
    'cityName' => 'KONGAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  238 => 
  array (
    'id' => '241',
    'cityName' => 'PERUMATHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  239 => 
  array (
    'id' => '242',
    'cityName' => 'VANNIKONDAL',
    'state_id' => '1',
    'status' => '1',
  ),
  240 => 
  array (
    'id' => '243',
    'cityName' => 'KARISATHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  241 => 
  array (
    'id' => '244',
    'cityName' => 'SAMIATHA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  242 => 
  array (
    'id' => '245',
    'cityName' => 'KANSA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  243 => 
  array (
    'id' => '246',
    'cityName' => 'KURICHIYAR  PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  244 => 
  array (
    'id' => '247',
    'cityName' => 'GOPALA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  245 => 
  array (
    'id' => '248',
    'cityName' => 'MAMSA',
    'state_id' => '1',
    'status' => '1',
  ),
  246 => 
  array (
    'id' => '249',
    'cityName' => 'THIRU VENGADA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  247 => 
  array (
    'id' => '250',
    'cityName' => 'KALAVASAL',
    'state_id' => '1',
    'status' => '1',
  ),
  248 => 
  array (
    'id' => '251',
    'cityName' => 'APPAIYA NAYAGAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  249 => 
  array (
    'id' => '252',
    'cityName' => 'CHOKA LINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  250 => 
  array (
    'id' => '253',
    'cityName' => 'PUNAL VELI',
    'state_id' => '1',
    'status' => '1',
  ),
  251 => 
  array (
    'id' => '254',
    'cityName' => 'SOKKALINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  252 => 
  array (
    'id' => '255',
    'cityName' => 'ARCHUNAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  253 => 
  array (
    'id' => '256',
    'cityName' => 'CTHAMBARAM PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  254 => 
  array (
    'id' => '257',
    'cityName' => 'CHITHAMBARA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  255 => 
  array (
    'id' => '258',
    'cityName' => 'MUTHUGUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  256 => 
  array (
    'id' => '259',
    'cityName' => 'ATTAIMILL',
    'state_id' => '1',
    'status' => '1',
  ),
  257 => 
  array (
    'id' => '260',
    'cityName' => 'KODANGI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  258 => 
  array (
    'id' => '261',
    'cityName' => 'PERU MAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  259 => 
  array (
    'id' => '262',
    'cityName' => 'MUDHU GUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  260 => 
  array (
    'id' => '263',
    'cityName' => 'CHOKKALINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  261 => 
  array (
    'id' => '264',
    'cityName' => 'MELA MARATHONI',
    'state_id' => '1',
    'status' => '1',
  ),
  262 => 
  array (
    'id' => '265',
    'cityName' => 'SHIVA LINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  263 => 
  array (
    'id' => '266',
    'cityName' => 'SUBBULA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  264 => 
  array (
    'id' => '267',
    'cityName' => 'VISHWA NATHA PERY',
    'state_id' => '1',
    'status' => '1',
  ),
  265 => 
  array (
    'id' => '268',
    'cityName' => 'THIRUNELVELI',
    'state_id' => '1',
    'status' => '1',
  ),
  266 => 
  array (
    'id' => '269',
    'cityName' => 'NARI MADU',
    'state_id' => '1',
    'status' => '1',
  ),
  267 => 
  array (
    'id' => '270',
    'cityName' => 'ASILA PUIRAM',
    'state_id' => '1',
    'status' => '1',
  ),
  268 => 
  array (
    'id' => '271',
    'cityName' => 'KARISAL KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  269 => 
  array (
    'id' => '272',
    'cityName' => 'RAMA THEVAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  270 => 
  array (
    'id' => '273',
    'cityName' => 'MUTHA NADHI',
    'state_id' => '1',
    'status' => '1',
  ),
  271 => 
  array (
    'id' => '274',
    'cityName' => 'AYAN KOLLAM KONDAN',
    'state_id' => '1',
    'status' => '1',
  ),
  272 => 
  array (
    'id' => '275',
    'cityName' => 'APPANAYAGAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  273 => 
  array (
    'id' => '276',
    'cityName' => 'RRAJAPALAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  274 => 
  array (
    'id' => '277',
    'cityName' => 'SOLAI SERI',
    'state_id' => '1',
    'status' => '1',
  ),
  275 => 
  array (
    'id' => '278',
    'cityName' => 'THULUKAN GULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  276 => 
  array (
    'id' => '279',
    'cityName' => 'PANTHA PULI',
    'state_id' => '1',
    'status' => '1',
  ),
  277 => 
  array (
    'id' => '280',
    'cityName' => 'CHATRA PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  278 => 
  array (
    'id' => '281',
    'cityName' => 'VASUDEVA NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  279 => 
  array (
    'id' => '282',
    'cityName' => 'THAVATHANAM',
    'state_id' => '1',
    'status' => '1',
  ),
  280 => 
  array (
    'id' => '283',
    'cityName' => 'NAKKANERI',
    'state_id' => '1',
    'status' => '1',
  ),
  281 => 
  array (
    'id' => '284',
    'cityName' => 'SANKALINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  282 => 
  array (
    'id' => '285',
    'cityName' => 'KURUCHIYAR PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  283 => 
  array (
    'id' => '286',
    'cityName' => 'INAM KOVIL PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  284 => 
  array (
    'id' => '287',
    'cityName' => 'SUNDRA NACCIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  285 => 
  array (
    'id' => '288',
    'cityName' => 'NAL KODAM SEVAL',
    'state_id' => '1',
    'status' => '1',
  ),
  286 => 
  array (
    'id' => '289',
    'cityName' => 'SUNDAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  287 => 
  array (
    'id' => '290',
    'cityName' => 'SUNDARA NACCHIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  288 => 
  array (
    'id' => '291',
    'cityName' => 'ASILA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  289 => 
  array (
    'id' => '292',
    'cityName' => 'MPK PUTHU PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  290 => 
  array (
    'id' => '293',
    'cityName' => 'SOLLAI SEERI',
    'state_id' => '1',
    'status' => '1',
  ),
  291 => 
  array (
    'id' => '294',
    'cityName' => 'SENTHADIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  292 => 
  array (
    'id' => '295',
    'cityName' => 'ULLAR',
    'state_id' => '1',
    'status' => '1',
  ),
  293 => 
  array (
    'id' => '296',
    'cityName' => 'AYYAN KOLLAM KODAN',
    'state_id' => '1',
    'status' => '1',
  ),
  294 => 
  array (
    'id' => '297',
    'cityName' => 'PARA PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  295 => 
  array (
    'id' => '298',
    'cityName' => 'PUNNAIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  296 => 
  array (
    'id' => '299',
    'cityName' => 'PULIYAKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  297 => 
  array (
    'id' => '300',
    'cityName' => 'SUNDRA NACCHIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  298 => 
  array (
    'id' => '301',
    'cityName' => 'VIRUTHUNAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  299 => 
  array (
    'id' => '302',
    'cityName' => 'NARI MEDU',
    'state_id' => '1',
    'status' => '1',
  ),
  300 => 
  array (
    'id' => '303',
    'cityName' => 'NATHI KUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  301 => 
  array (
    'id' => '304',
    'cityName' => 'THAILAGULLAM',
    'state_id' => '1',
    'status' => '1',
  ),
  302 => 
  array (
    'id' => '305',
    'cityName' => 'CHOLA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  303 => 
  array (
    'id' => '306',
    'cityName' => 'RAJAPALAYM',
    'state_id' => '1',
    'status' => '1',
  ),
  304 => 
  array (
    'id' => '307',
    'cityName' => 'THILA KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  305 => 
  array (
    'id' => '308',
    'cityName' => 'DEVIPATTINAM',
    'state_id' => '1',
    'status' => '1',
  ),
  306 => 
  array (
    'id' => '309',
    'cityName' => 'SUNDHRA PANDIYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  307 => 
  array (
    'id' => '310',
    'cityName' => 'SOKKANATHAN PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  308 => 
  array (
    'id' => '311',
    'cityName' => 'ATTIMILL',
    'state_id' => '1',
    'status' => '1',
  ),
  309 => 
  array (
    'id' => '312',
    'cityName' => 'KRISHNAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  310 => 
  array (
    'id' => '313',
    'cityName' => 'CHITRAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  311 => 
  array (
    'id' => '314',
    'cityName' => 'SENNIKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  312 => 
  array (
    'id' => '315',
    'cityName' => 'PUTHUPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  313 => 
  array (
    'id' => '316',
    'cityName' => 'GOTHAINACHIYARPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  314 => 
  array (
    'id' => '317',
    'cityName' => 'KUMAPATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  315 => 
  array (
    'id' => '318',
    'cityName' => 'SANKARAMOORTHI PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  316 => 
  array (
    'id' => '319',
    'cityName' => 'VALLIOUR',
    'state_id' => '1',
    'status' => '1',
  ),
  317 => 
  array (
    'id' => '320',
    'cityName' => 'KARISANTHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  318 => 
  array (
    'id' => '321',
    'cityName' => 'MUHAOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  319 => 
  array (
    'id' => '322',
    'cityName' => 'DESIKA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  320 => 
  array (
    'id' => '323',
    'cityName' => 'DEVATHANAM',
    'state_id' => '1',
    'status' => '1',
  ),
  321 => 
  array (
    'id' => '324',
    'cityName' => 'INAM KARISAL KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  322 => 
  array (
    'id' => '325',
    'cityName' => 'MOTTAMALAI',
    'state_id' => '1',
    'status' => '1',
  ),
  323 => 
  array (
    'id' => '326',
    'cityName' => 'SUNDRA RAJAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  324 => 
  array (
    'id' => '327',
    'cityName' => 'KOONAM KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  325 => 
  array (
    'id' => '328',
    'cityName' => 'THENMALAI',
    'state_id' => '1',
    'status' => '1',
  ),
  326 => 
  array (
    'id' => '329',
    'cityName' => 'ARUGAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  327 => 
  array (
    'id' => '330',
    'cityName' => 'THIRUVENKADA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  328 => 
  array (
    'id' => '331',
    'cityName' => 'MALAI PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  329 => 
  array (
    'id' => '332',
    'cityName' => 'SANKAMPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  330 => 
  array (
    'id' => '333',
    'cityName' => 'SHIVAGIRI',
    'state_id' => '1',
    'status' => '1',
  ),
  331 => 
  array (
    'id' => '334',
    'cityName' => 'PULIYAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  332 => 
  array (
    'id' => '335',
    'cityName' => 'SATTI KINARU',
    'state_id' => '1',
    'status' => '1',
  ),
  333 => 
  array (
    'id' => '336',
    'cityName' => '9342961560',
    'state_id' => '1',
    'status' => '1',
  ),
  334 => 
  array (
    'id' => '337',
    'cityName' => 'LAKSHMIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  335 => 
  array (
    'id' => '338',
    'cityName' => 'KALANGA PERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  336 => 
  array (
    'id' => '339',
    'cityName' => 'SANKARA PANDIYA PURAM,',
    'state_id' => '1',
    'status' => '1',
  ),
  337 => 
  array (
    'id' => '340',
    'cityName' => 'KARIVALAM VANTHA NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  338 => 
  array (
    'id' => '341',
    'cityName' => 'MANGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  339 => 
  array (
    'id' => '342',
    'cityName' => 'SATTIKINARU',
    'state_id' => '1',
    'status' => '1',
  ),
  340 => 
  array (
    'id' => '343',
    'cityName' => 'SANKARALINGA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  341 => 
  array (
    'id' => '344',
    'cityName' => 'KOODANGI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  342 => 
  array (
    'id' => '345',
    'cityName' => 'GOMATHI MUTHU PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  343 => 
  array (
    'id' => '346',
    'cityName' => 'KUVALAI KANI',
    'state_id' => '1',
    'status' => '1',
  ),
  344 => 
  array (
    'id' => '347',
    'cityName' => 'RAJAPALATAM',
    'state_id' => '1',
    'status' => '1',
  ),
  345 => 
  array (
    'id' => '348',
    'cityName' => 'THIRATHANGAL',
    'state_id' => '1',
    'status' => '1',
  ),
  346 => 
  array (
    'id' => '349',
    'cityName' => 'ANNAITHALA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  347 => 
  array (
    'id' => '350',
    'cityName' => 'GANAPATHI SUNDHARA NACCHIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  348 => 
  array (
    'id' => '351',
    'cityName' => 'SAMSIKAPUR',
    'state_id' => '1',
    'status' => '1',
  ),
  349 => 
  array (
    'id' => '352',
    'cityName' => 'DEVIPATINAM',
    'state_id' => '1',
    'status' => '1',
  ),
  350 => 
  array (
    'id' => '353',
    'cityName' => 'ELANTHARA KONDAN',
    'state_id' => '1',
    'status' => '1',
  ),
  351 => 
  array (
    'id' => '354',
    'cityName' => 'KARISEL KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  352 => 
  array (
    'id' => '355',
    'cityName' => 'VADAKARAI',
    'state_id' => '1',
    'status' => '1',
  ),
  353 => 
  array (
    'id' => '356',
    'cityName' => 'VELAYUHTHA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  354 => 
  array (
    'id' => '357',
    'cityName' => 'RAJAPALAM',
    'state_id' => '1',
    'status' => '1',
  ),
  355 => 
  array (
    'id' => '358',
    'cityName' => 'SRIVILLIPUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  356 => 
  array (
    'id' => '359',
    'cityName' => 'PULIYANKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  357 => 
  array (
    'id' => '360',
    'cityName' => 'CHINNA VALLIKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  358 => 
  array (
    'id' => '361',
    'cityName' => 'THEN KASI',
    'state_id' => '1',
    'status' => '1',
  ),
  359 => 
  array (
    'id' => '362',
    'cityName' => 'RAYAPPAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  360 => 
  array (
    'id' => '363',
    'cityName' => 'KALANGAPERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  361 => 
  array (
    'id' => '364',
    'cityName' => 'KOONAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  362 => 
  array (
    'id' => '365',
    'cityName' => 'MALLI',
    'state_id' => '1',
    'status' => '1',
  ),
  363 => 
  array (
    'id' => '366',
    'cityName' => 'RAJAPAALYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  364 => 
  array (
    'id' => '367',
    'cityName' => 'SITHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  365 => 
  array (
    'id' => '368',
    'cityName' => 'INDRA COLONY',
    'state_id' => '1',
    'status' => '1',
  ),
  366 => 
  array (
    'id' => '369',
    'cityName' => 'SALEAM',
    'state_id' => '1',
    'status' => '1',
  ),
  367 => 
  array (
    'id' => '370',
    'cityName' => 'THACH NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  368 => 
  array (
    'id' => '371',
    'cityName' => 'SENTADIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  369 => 
  array (
    'id' => '372',
    'cityName' => 'PUTHUKODAI',
    'state_id' => '1',
    'status' => '1',
  ),
  370 => 
  array (
    'id' => '373',
    'cityName' => 'KEELA RAJA KULARAM',
    'state_id' => '1',
    'status' => '1',
  ),
  371 => 
  array (
    'id' => '374',
    'cityName' => 'JAMEEN NATHAMPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  372 => 
  array (
    'id' => '375',
    'cityName' => 'VIRANAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  373 => 
  array (
    'id' => '376',
    'cityName' => 'AYYANARPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  374 => 
  array (
    'id' => '377',
    'cityName' => 'PUTHUKOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  375 => 
  array (
    'id' => '378',
    'cityName' => 'VELAKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  376 => 
  array (
    'id' => '379',
    'cityName' => 'NALLAMA NAYAGAN PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  377 => 
  array (
    'id' => '380',
    'cityName' => 'KEELAN MARAI NADU',
    'state_id' => '1',
    'status' => '1',
  ),
  378 => 
  array (
    'id' => '381',
    'cityName' => 'PONNAGARAM',
    'state_id' => '1',
    'status' => '1',
  ),
  379 => 
  array (
    'id' => '382',
    'cityName' => 'MUTHNATHI',
    'state_id' => '1',
    'status' => '1',
  ),
  380 => 
  array (
    'id' => '383',
    'cityName' => 'KALLAMA NAYAKANPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  381 => 
  array (
    'id' => '384',
    'cityName' => 'THIRUNALVELI',
    'state_id' => '1',
    'status' => '1',
  ),
  382 => 
  array (
    'id' => '385',
    'cityName' => 'SOLLAISERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  383 => 
  array (
    'id' => '386',
    'cityName' => 'VALPARAI',
    'state_id' => '1',
    'status' => '1',
  ),
  384 => 
  array (
    'id' => '387',
    'cityName' => 'SANKARAPANDIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  385 => 
  array (
    'id' => '388',
    'cityName' => 'MUTHANADHI',
    'state_id' => '1',
    'status' => '1',
  ),
  386 => 
  array (
    'id' => '389',
    'cityName' => 'VETTARAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  387 => 
  array (
    'id' => '390',
    'cityName' => 'RAMACHANDRAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  388 => 
  array (
    'id' => '391',
    'cityName' => 'ASHILAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  389 => 
  array (
    'id' => '392',
    'cityName' => 'SEVAL PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  390 => 
  array (
    'id' => '393',
    'cityName' => 'DEVIPADINAAM',
    'state_id' => '1',
    'status' => '1',
  ),
  391 => 
  array (
    'id' => '394',
    'cityName' => 'SAMSIKAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  392 => 
  array (
    'id' => '395',
    'cityName' => 'THIRUNELVELLI',
    'state_id' => '1',
    'status' => '1',
  ),
  393 => 
  array (
    'id' => '396',
    'cityName' => 'MELAVARAGUNA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  394 => 
  array (
    'id' => '397',
    'cityName' => 'NADHIKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  395 => 
  array (
    'id' => '398',
    'cityName' => 'ALANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  396 => 
  array (
    'id' => '399',
    'cityName' => 'SANKANRAN KOVIL',
    'state_id' => '1',
    'status' => '1',
  ),
  397 => 
  array (
    'id' => '400',
    'cityName' => 'CHOKKALINGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  398 => 
  array (
    'id' => '401',
    'cityName' => 'VALAYAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  399 => 
  array (
    'id' => '402',
    'cityName' => 'REDDIYAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  400 => 
  array (
    'id' => '403',
    'cityName' => 'TAHARAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  401 => 
  array (
    'id' => '404',
    'cityName' => 'KONGANGULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  402 => 
  array (
    'id' => '405',
    'cityName' => 'SUNDARAPANDIAM',
    'state_id' => '1',
    'status' => '1',
  ),
  403 => 
  array (
    'id' => '406',
    'cityName' => 'ASILAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  404 => 
  array (
    'id' => '407',
    'cityName' => 'CHATRAPTTY',
    'state_id' => '1',
    'status' => '1',
  ),
  405 => 
  array (
    'id' => '408',
    'cityName' => 'VANGAR PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  406 => 
  array (
    'id' => '409',
    'cityName' => 'ETTISERI',
    'state_id' => '1',
    'status' => '1',
  ),
  407 => 
  array (
    'id' => '410',
    'cityName' => 'CHITHAMBARAM',
    'state_id' => '1',
    'status' => '1',
  ),
  408 => 
  array (
    'id' => '411',
    'cityName' => 'GOAMTHI MUTHUMARI',
    'state_id' => '1',
    'status' => '1',
  ),
  409 => 
  array (
    'id' => '412',
    'cityName' => 'ILANDHAIKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  410 => 
  array (
    'id' => '413',
    'cityName' => 'GOAMTHI MUTHUPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  411 => 
  array (
    'id' => '414',
    'cityName' => 'KADAYANALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  412 => 
  array (
    'id' => '415',
    'cityName' => 'METOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  413 => 
  array (
    'id' => '416',
    'cityName' => 'KALINGAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  414 => 
  array (
    'id' => '417',
    'cityName' => 'THESIKAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  415 => 
  array (
    'id' => '418',
    'cityName' => 'THIRUVENGATAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  416 => 
  array (
    'id' => '419',
    'cityName' => 'SANGUPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  417 => 
  array (
    'id' => '420',
    'cityName' => 'T.N.PUTHUKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  418 => 
  array (
    'id' => '421',
    'cityName' => 'KEELATHIRUVEDDA NALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  419 => 
  array (
    'id' => '422',
    'cityName' => 'KULASEKARAPERRI',
    'state_id' => '1',
    'status' => '1',
  ),
  420 => 
  array (
    'id' => '423',
    'cityName' => 'RAMAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  421 => 
  array (
    'id' => '424',
    'cityName' => 'SOLAISERI',
    'state_id' => '1',
    'status' => '1',
  ),
  422 => 
  array (
    'id' => '425',
    'cityName' => 'SENNALKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  423 => 
  array (
    'id' => '426',
    'cityName' => 'KOONANGULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  424 => 
  array (
    'id' => '427',
    'cityName' => 'ATHANKARA PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  425 => 
  array (
    'id' => '428',
    'cityName' => 'SINGARAJAKOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  426 => 
  array (
    'id' => '429',
    'cityName' => 'ANDRA PRADESH',
    'state_id' => '1',
    'status' => '1',
  ),
  427 => 
  array (
    'id' => '430',
    'cityName' => 'KANSAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  428 => 
  array (
    'id' => '431',
    'cityName' => 'CHATRAPATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  429 => 
  array (
    'id' => '432',
    'cityName' => 'PATTIYUR',
    'state_id' => '1',
    'status' => '1',
  ),
  430 => 
  array (
    'id' => '433',
    'cityName' => 'RENGANAYAKA PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  431 => 
  array (
    'id' => '434',
    'cityName' => 'S.RAMACHNADRA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  432 => 
  array (
    'id' => '435',
    'cityName' => 'SAMINATHAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  433 => 
  array (
    'id' => '436',
    'cityName' => 'PEYAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  434 => 
  array (
    'id' => '437',
    'cityName' => 'MANGUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  435 => 
  array (
    'id' => '438',
    'cityName' => 'KALNAGAPERRY PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  436 => 
  array (
    'id' => '439',
    'cityName' => 'SUNDRANACCHIYAR PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  437 => 
  array (
    'id' => '440',
    'cityName' => 'ARUPPUKOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  438 => 
  array (
    'id' => '441',
    'cityName' => 'MAHARAJA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  439 => 
  array (
    'id' => '442',
    'cityName' => 'VALLAYAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  440 => 
  array (
    'id' => '443',
    'cityName' => 'RR NAGAR',
    'state_id' => '1',
    'status' => '1',
  ),
  441 => 
  array (
    'id' => '444',
    'cityName' => 'MELA GOPALAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  442 => 
  array (
    'id' => '445',
    'cityName' => 'CityRAJAPALAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  443 => 
  array (
    'id' => '446',
    'cityName' => 'SAMUSIKAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  444 => 
  array (
    'id' => '447',
    'cityName' => 'VAIGAIKULAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  445 => 
  array (
    'id' => '448',
    'cityName' => 'KALANGAPERRY PUTHUR',
    'state_id' => '1',
    'status' => '1',
  ),
  446 => 
  array (
    'id' => '449',
    'cityName' => 'VELAYUTHA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  447 => 
  array (
    'id' => '450',
    'cityName' => 'KOTTAIYOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  448 => 
  array (
    'id' => '451',
    'cityName' => 'SOUTH VENNGANALLUR',
    'state_id' => '1',
    'status' => '1',
  ),
  449 => 
  array (
    'id' => '452',
    'cityName' => 'KUNNUR',
    'state_id' => '1',
    'status' => '1',
  ),
  450 => 
  array (
    'id' => '453',
    'cityName' => 'IDAYAN KULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  451 => 
  array (
    'id' => '454',
    'cityName' => 'VEMBAKOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  452 => 
  array (
    'id' => '455',
    'cityName' => 'COIMBATORE',
    'state_id' => '1',
    'status' => '1',
  ),
  453 => 
  array (
    'id' => '456',
    'cityName' => 'SUBBULAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  454 => 
  array (
    'id' => '457',
    'cityName' => 'BANGALORE',
    'state_id' => '1',
    'status' => '1',
  ),
  455 => 
  array (
    'id' => '458',
    'cityName' => 'MALAYADI PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  456 => 
  array (
    'id' => '459',
    'cityName' => 'SHIVARAM PETTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  457 => 
  array (
    'id' => '460',
    'cityName' => 'KAMACHIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  458 => 
  array (
    'id' => '461',
    'cityName' => 'ATCHAM THAVILTHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  459 => 
  array (
    'id' => '462',
    'cityName' => 'S.RAMA LINGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  460 => 
  array (
    'id' => '463',
    'cityName' => 'SHIVAKASI',
    'state_id' => '1',
    'status' => '1',
  ),
  461 => 
  array (
    'id' => '464',
    'cityName' => 'VAYAI KULLAM PATTI',
    'state_id' => '1',
    'status' => '1',
  ),
  462 => 
  array (
    'id' => '465',
    'cityName' => 'THIRUVENGADAM',
    'state_id' => '1',
    'status' => '1',
  ),
  463 => 
  array (
    'id' => '466',
    'cityName' => 'IDANYANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  464 => 
  array (
    'id' => '467',
    'cityName' => 'SENRHDIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  465 => 
  array (
    'id' => '468',
    'cityName' => 'PALAYANKOTTAI',
    'state_id' => '1',
    'status' => '1',
  ),
  466 => 
  array (
    'id' => '469',
    'cityName' => 'KEELARAJKULARAMAN',
    'state_id' => '1',
    'status' => '1',
  ),
  467 => 
  array (
    'id' => '470',
    'cityName' => 'ACHAMTHAVILTHAN',
    'state_id' => '1',
    'status' => '1',
  ),
  468 => 
  array (
    'id' => '471',
    'cityName' => 'SUNDARAJAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  469 => 
  array (
    'id' => '472',
    'cityName' => 'SERNDAMARAM',
    'state_id' => '1',
    'status' => '1',
  ),
  470 => 
  array (
    'id' => '473',
    'cityName' => 'SHIVAGAMIYA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  471 => 
  array (
    'id' => '474',
    'cityName' => 'IDAYANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  472 => 
  array (
    'id' => '475',
    'cityName' => 'CHITHIRAM PATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  473 => 
  array (
    'id' => '476',
    'cityName' => 'RAJAPALAAYAM',
    'state_id' => '1',
    'status' => '1',
  ),
  474 => 
  array (
    'id' => '477',
    'cityName' => 'POTTALPTDUR',
    'state_id' => '1',
    'status' => '1',
  ),
  475 => 
  array (
    'id' => '478',
    'cityName' => 'RAMAKIRSHNA PURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  476 => 
  array (
    'id' => '479',
    'cityName' => 'SANKRALINGAPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  477 => 
  array (
    'id' => '480',
    'cityName' => 'NAKKANERRY',
    'state_id' => '1',
    'status' => '1',
  ),
  478 => 
  array (
    'id' => '481',
    'cityName' => 'MUTHUKUDI',
    'state_id' => '1',
    'status' => '1',
  ),
  479 => 
  array (
    'id' => '482',
    'cityName' => 'APPANOOR',
    'state_id' => '1',
    'status' => '1',
  ),
  480 => 
  array (
    'id' => '483',
    'cityName' => 'VALLAPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
  481 => 
  array (
    'id' => '484',
    'cityName' => 'DEVARKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  482 => 
  array (
    'id' => '485',
    'cityName' => 'ARUGANKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  483 => 
  array (
    'id' => '486',
    'cityName' => 'SANKRAN KOVIL',
    'state_id' => '1',
    'status' => '1',
  ),
  484 => 
  array (
    'id' => '487',
    'cityName' => 'SUNDRA RAJPURAM',
    'state_id' => '1',
    'status' => '1',
  ),
  485 => 
  array (
    'id' => '488',
    'cityName' => 'PUNNAIVANAM',
    'state_id' => '1',
    'status' => '1',
  ),
  486 => 
  array (
    'id' => '489',
    'cityName' => 'NARIKULAM',
    'state_id' => '1',
    'status' => '1',
  ),
  487 => 
  array (
    'id' => '490',
    'cityName' => 'RAJAPALAAYM',
    'state_id' => '1',
    'status' => '1',
  ),
  488 => 
  array (
    'id' => '491',
    'cityName' => 'PUDUPATTY',
    'state_id' => '1',
    'status' => '1',
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('city');
    }
}
