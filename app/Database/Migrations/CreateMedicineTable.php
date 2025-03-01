<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicineTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'medicineName' => [
                'type' => 'VARCHAR',
                'constraint' => 145,
                'null' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'constraint' => null,
                'null' => true,
            ],
            'medicine_type_fk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('medicine');

        // Insert initial data
        $this->db->table('medicine')->insertBatch(array (
  0 => 
  array (
    'id' => '1',
    'medicineName' => 'TAB.GUDCEF-CV',
    'description' => '200',
    'status' => '1',
    'created_at' => '2024-01-08 11:39:24',
    'medicine_type_fk_id' => '1',
  ),
  1 => 
  array (
    'id' => '2',
    'medicineName' => 'rutoheal',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:39:58',
    'medicine_type_fk_id' => '1',
  ),
  2 => 
  array (
    'id' => '3',
    'medicineName' => 'pantap',
    'description' => '40',
    'status' => '1',
    'created_at' => '2024-01-08 11:44:06',
    'medicine_type_fk_id' => '1',
  ),
  3 => 
  array (
    'id' => '4',
    'medicineName' => 'mucopain',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:44:27',
    'medicine_type_fk_id' => '9',
  ),
  4 => 
  array (
    'id' => '6',
    'medicineName' => 'hiora sg',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:44:59',
    'medicine_type_fk_id' => '9',
  ),
  5 => 
  array (
    'id' => '7',
    'medicineName' => 'lycostar',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:45:56',
    'medicine_type_fk_id' => '3',
  ),
  6 => 
  array (
    'id' => '8',
    'medicineName' => 'stolin-r',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:46:36',
    'medicine_type_fk_id' => '7',
  ),
  7 => 
  array (
    'id' => '9',
    'medicineName' => 'cheerio',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:47:03',
    'medicine_type_fk_id' => '7',
  ),
  8 => 
  array (
    'id' => '10',
    'medicineName' => 'senquel-f',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:49:05',
    'medicine_type_fk_id' => '7',
  ),
  9 => 
  array (
    'id' => '11',
    'medicineName' => 'betakind',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:49:55',
    'medicine_type_fk_id' => '8',
  ),
  10 => 
  array (
    'id' => '12',
    'medicineName' => 'perioguard',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:50:23',
    'medicine_type_fk_id' => '8',
  ),
  11 => 
  array (
    'id' => '13',
    'medicineName' => 'ortho brush',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-08 11:51:05',
    'medicine_type_fk_id' => '10',
  ),
  12 => 
  array (
    'id' => '14',
    'medicineName' => 'moxikind -cv',
    'description' => '625',
    'status' => '0',
    'created_at' => '2024-01-08 11:56:50',
    'medicine_type_fk_id' => '1',
  ),
  13 => 
  array (
    'id' => '15',
    'medicineName' => 'ibukind plus',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-01-10 14:18:04',
    'medicine_type_fk_id' => '4',
  ),
  14 => 
  array (
    'id' => '16',
    'medicineName' => 'pantap',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-01-13 12:01:21',
    'medicine_type_fk_id' => '1',
  ),
  15 => 
  array (
    'id' => '18',
    'medicineName' => 'rutoheal',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-01-13 13:31:28',
    'medicine_type_fk_id' => '1',
  ),
  16 => 
  array (
    'id' => '19',
    'medicineName' => 'mucopain',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-01-13 19:06:29',
    'medicine_type_fk_id' => '1',
  ),
  17 => 
  array (
    'id' => '20',
    'medicineName' => 'cure next',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-01-17 20:13:05',
    'medicine_type_fk_id' => '1',
  ),
  18 => 
  array (
    'id' => '21',
    'medicineName' => 'ACEPON-P',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-01-17 20:49:44',
    'medicine_type_fk_id' => '3',
  ),
  19 => 
  array (
    'id' => '29',
    'medicineName' => 'amoxlline',
    'description' => '500',
    'status' => '0',
    'created_at' => '2024-02-26 12:35:17',
    'medicine_type_fk_id' => '1',
  ),
  20 => 
  array (
    'id' => '30',
    'medicineName' => 'flagyl',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-02-26 12:38:34',
    'medicine_type_fk_id' => '1',
  ),
  21 => 
  array (
    'id' => '31',
    'medicineName' => 'NOVA-CV',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-02-29 13:08:21',
    'medicine_type_fk_id' => NULL,
  ),
  22 => 
  array (
    'id' => '32',
    'medicineName' => 'CAZIQ',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-02 11:25:55',
    'medicine_type_fk_id' => NULL,
  ),
  23 => 
  array (
    'id' => '33',
    'medicineName' => 'SY.CLAVAM',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-02 18:54:37',
    'medicine_type_fk_id' => NULL,
  ),
  24 => 
  array (
    'id' => '34',
    'medicineName' => 'VANTEJ',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-05 18:57:45',
    'medicine_type_fk_id' => NULL,
  ),
  25 => 
  array (
    'id' => '35',
    'medicineName' => 'SY.FLAGLY',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-09 12:28:50',
    'medicine_type_fk_id' => NULL,
  ),
  26 => 
  array (
    'id' => '36',
    'medicineName' => 'CEFIPRL',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-09 18:49:21',
    'medicine_type_fk_id' => NULL,
  ),
  27 => 
  array (
    'id' => '37',
    'medicineName' => 'PANTOP',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-17 12:24:50',
    'medicine_type_fk_id' => NULL,
  ),
  28 => 
  array (
    'id' => '38',
    'medicineName' => 'PAERIO GUARD',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-17 12:41:07',
    'medicine_type_fk_id' => '1',
  ),
  29 => 
  array (
    'id' => '39',
    'medicineName' => 'PANTA KIND',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-18 19:37:43',
    'medicine_type_fk_id' => NULL,
  ),
  30 => 
  array (
    'id' => '40',
    'medicineName' => 'MOXIFORCE- CV',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-03-19 19:44:55',
    'medicine_type_fk_id' => '1',
  ),
  31 => 
  array (
    'id' => '41',
    'medicineName' => 'TAB.ACEPON -P',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-03-19 19:45:20',
    'medicine_type_fk_id' => '1',
  ),
  32 => 
  array (
    'id' => '42',
    'medicineName' => 'TAB.FLAGYL',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-03-19 21:05:13',
    'medicine_type_fk_id' => '0',
  ),
  33 => 
  array (
    'id' => '43',
    'medicineName' => 'TAB.MOXIKIND -CV',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-03-20 09:56:57',
    'medicine_type_fk_id' => '1',
  ),
  34 => 
  array (
    'id' => '44',
    'medicineName' => 'CLOXIMED -LB',
    'description' => '',
    'status' => '0',
    'created_at' => '2024-03-20 09:57:44',
    'medicine_type_fk_id' => '3',
  ),
  35 => 
  array (
    'id' => '45',
    'medicineName' => 'CAB.BETAMOX',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-03-20 10:03:47',
    'medicine_type_fk_id' => '3',
  ),
  36 => 
  array (
    'id' => '47',
    'medicineName' => 'T.MAHACEF-CV',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-03-23 19:07:28',
    'medicine_type_fk_id' => NULL,
  ),
  37 => 
  array (
    'id' => '48',
    'medicineName' => 'ACPON-P',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-01 18:01:24',
    'medicine_type_fk_id' => NULL,
  ),
  38 => 
  array (
    'id' => '49',
    'medicineName' => 'BETA KIND',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-09 18:50:58',
    'medicine_type_fk_id' => NULL,
  ),
  39 => 
  array (
    'id' => '50',
    'medicineName' => 'CHERRIO',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-16 19:17:44',
    'medicine_type_fk_id' => NULL,
  ),
  40 => 
  array (
    'id' => '51',
    'medicineName' => 'DOLO',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-16 20:43:16',
    'medicine_type_fk_id' => NULL,
  ),
  41 => 
  array (
    'id' => '52',
    'medicineName' => 'HIORA',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-18 19:24:21',
    'medicine_type_fk_id' => NULL,
  ),
  42 => 
  array (
    'id' => '53',
    'medicineName' => 'PERIO GUARD',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-22 19:38:23',
    'medicine_type_fk_id' => NULL,
  ),
  43 => 
  array (
    'id' => '54',
    'medicineName' => 'T.MAHACEF',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-04-27 20:42:22',
    'medicine_type_fk_id' => NULL,
  ),
  44 => 
  array (
    'id' => '55',
    'medicineName' => 'rutoheal     (9.5.24)',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-10 10:44:54',
    'medicine_type_fk_id' => NULL,
  ),
  45 => 
  array (
    'id' => '56',
    'medicineName' => 'betakind (9.5.24)',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-10 10:44:54',
    'medicine_type_fk_id' => NULL,
  ),
  46 => 
  array (
    'id' => '57',
    'medicineName' => 'PERIO GUARD (9.5.24)',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-10 10:44:54',
    'medicine_type_fk_id' => NULL,
  ),
  47 => 
  array (
    'id' => '58',
    'medicineName' => 'cure next  (9.5.24)',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-10 10:44:54',
    'medicine_type_fk_id' => NULL,
  ),
  48 => 
  array (
    'id' => '59',
    'medicineName' => 'DENTA91',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-15 13:35:50',
    'medicine_type_fk_id' => NULL,
  ),
  49 => 
  array (
    'id' => '60',
    'medicineName' => 'VANT',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-16 17:38:45',
    'medicine_type_fk_id' => NULL,
  ),
  50 => 
  array (
    'id' => '61',
    'medicineName' => 'BETADINE',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-21 14:01:50',
    'medicine_type_fk_id' => NULL,
  ),
  51 => 
  array (
    'id' => '62',
    'medicineName' => 'AMFIOR',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-24 14:19:55',
    'medicine_type_fk_id' => NULL,
  ),
  52 => 
  array (
    'id' => '63',
    'medicineName' => 'CAZAQ',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-27 18:23:12',
    'medicine_type_fk_id' => NULL,
  ),
  53 => 
  array (
    'id' => '64',
    'medicineName' => 'ULTRA SOFT BRUSH',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-05-27 20:19:24',
    'medicine_type_fk_id' => NULL,
  ),
  54 => 
  array (
    'id' => '65',
    'medicineName' => 'SEN',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-06-04 19:36:53',
    'medicine_type_fk_id' => NULL,
  ),
  55 => 
  array (
    'id' => '66',
    'medicineName' => 'AMOCRIN500',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-07-26 20:50:33',
    'medicine_type_fk_id' => NULL,
  ),
  56 => 
  array (
    'id' => '67',
    'medicineName' => 'PERIO',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-08-10 14:30:35',
    'medicine_type_fk_id' => NULL,
  ),
  57 => 
  array (
    'id' => '68',
    'medicineName' => 'CHERRI',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-08-26 18:18:24',
    'medicine_type_fk_id' => NULL,
  ),
  58 => 
  array (
    'id' => '69',
    'medicineName' => 'MUC',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-09-09 20:32:25',
    'medicine_type_fk_id' => NULL,
  ),
  59 => 
  array (
    'id' => '70',
    'medicineName' => 'BACTOCLAV 375',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-10-14 14:21:02',
    'medicine_type_fk_id' => '1',
  ),
  60 => 
  array (
    'id' => '71',
    'medicineName' => 'BETAKND',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-10-28 20:52:01',
    'medicine_type_fk_id' => NULL,
  ),
  61 => 
  array (
    'id' => '72',
    'medicineName' => 'CLOXIMED-LB',
    'description' => '500MG',
    'status' => '1',
    'created_at' => '2024-11-12 12:57:00',
    'medicine_type_fk_id' => '3',
  ),
  62 => 
  array (
    'id' => '73',
    'medicineName' => 'AMOCRIN',
    'description' => '500MG',
    'status' => '1',
    'created_at' => '2024-11-12 12:57:32',
    'medicine_type_fk_id' => '3',
  ),
  63 => 
  array (
    'id' => '74',
    'medicineName' => 'T.MOXIKIND-CV',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2024-11-16 19:32:04',
    'medicine_type_fk_id' => NULL,
  ),
  64 => 
  array (
    'id' => '75',
    'medicineName' => 'AMFLOR',
    'description' => '',
    'status' => '1',
    'created_at' => '2024-12-05 20:15:49',
    'medicine_type_fk_id' => '7',
  ),
  65 => 
  array (
    'id' => '76',
    'medicineName' => 'AMFLOR',
    'description' => '70G',
    'status' => '1',
    'created_at' => '2024-12-05 20:16:58',
    'medicine_type_fk_id' => '7',
  ),
  66 => 
  array (
    'id' => '77',
    'medicineName' => 'STORLIN-R',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2025-01-18 19:21:02',
    'medicine_type_fk_id' => NULL,
  ),
  67 => 
  array (
    'id' => '78',
    'medicineName' => 'AMOX',
    'description' => NULL,
    'status' => '1',
    'created_at' => '2025-01-25 21:18:20',
    'medicine_type_fk_id' => NULL,
  ),
));
    }

    public function down()
    {
        $this->forge->dropTable('medicine');
    }
}
