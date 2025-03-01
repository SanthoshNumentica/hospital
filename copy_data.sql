-- patient table
INSERT INTO sident_new.patient (
    patient_id, 
    title_fk_id, 
    f_name, 
    l_name, 
    blood_group_fk_id, 
    dob, 
    address, 
    city, 
    mobile_no, 
    email_id, 
    gender_fk_id,
    chief_complaint
)
SELECT 
    patientid, 
    CASE 
        WHEN title = 'Mrs' THEN 1
        WHEN title = 'Mr.' THEN 2
        WHEN title = 'Miss.' THEN 3
        WHEN title = 'Bro.' THEN 4
        WHEN title = 'Pr.' THEN 5
        WHEN title = 'Sis.' THEN 6
        WHEN title = 'Rev.' THEN 8
        WHEN title = 'Er.' THEN 9
        WHEN title = 'Master.' THEN 10
        WHEN title = 'Baby.' THEN 11
        ELSE NULL -- Add an ELSE statement for cases not covered
    END AS title_fk_id,
    fname, 
    lname, 
    bloodgroup, 
    CAST(dob AS DATE),
    address,
    city,
    mobile,
    email,
    CASE 
        WHEN gender = 'Male' THEN 1
        WHEN gender = 'Female' THEN 2
        ELSE NULL -- Add an ELSE statement for cases not covered
    END AS gender_fk_id,
    chiefcomplaints
FROM sident.patient;

-- UPDATE sident_new.patient
-- SET dob = NULL
-- WHERE dob = '0000-00-00 00:00:00';   --important

-- appointment table
INSERT INTO sident_new.appointment (patient_fk_id,doctor_fk_id,appointment_on)
SELECT p.id,doctor_id,Date
FROM sident.testappointment t
INNER JOIN sident_new.patient p ON t.patient_id = p.patient_id;

-- medicine table
-- ALTER TABLE `medicine` DROP INDEX `medicineName`;

INSERT into sident_new.medicine (medicineName,description)
SELECT Name,Description
from sident.medicine;

-- medicine_dosage table
-- ALTER TABLE `medicine_dosage` DROP INDEX `medicine_dosageName`;

-- INSERT into sident_new.medicine_dosage (medicine_dosageName)
-- SELECT Dosage
-- from sident.dosage;

-- -- medicine_duration table
-- -- ALTER TABLE `medicine_duration` DROP INDEX `medicine_durationName`;

-- INSERT INTO sident_new.medicine_duration (medicine_durationName)
-- SELECT Duration
-- FROM sident.duration
-- ON DUPLICATE KEY UPDATE medicine_durationName = CONCAT(medicine_durationName, 'add');

-- -- medicine_frequency table
-- -- ALTER TABLE `medicine_frequency` DROP INDEX `medicine_frequencyName`;

-- INSERT into sident_new.medicine_frequency (medicine_frequencyName)
-- SELECT Frequency
-- from sident.frequency;

-- -- treatment table
-- INSERT into sident_new. treatment (id,treatment_code,treatmentName,amount)
-- SELECT treatmentid ,treatmentcode,treatmentname,amount
-- from sident. treatment;

-- patient_treatment table
-- created_by is the child and it is comes from user_login table and I set 2 is default because "receptionist is the default user"
ALTER TABLE `patient_treatment` CHANGE `status` `status` TINYINT(4) NULL DEFAULT '1';
ALTER TABLE `patient_treatment` CHANGE `created_by` `created_by` BIGINT(20) NOT NULL DEFAULT '2';

INSERT INTO sident_new.patient_treatment (patient_fk_id, treatment_fk_id, created_by,doctor_fk_id, remarks)
SELECT p.id AS patient_fk_id, pt.treatmentid AS treatment_fk_id, 2 AS created_by,pt.DoctorID AS doctor_fk_id, pt.remarks AS remarks
FROM sident.patienttreatment pt
INNER JOIN sident_new.patient p ON pt.patientid = p.patient_id;

ALTER TABLE `patient_treatment` CHANGE `created_by` `created_by` BIGINT(20) NOT NULL;

-- patient_treatment_teeth table
ALTER TABLE `patient_treatment_teeth` DROP INDEX `teethNumber`;

INSERT into sident_new. patient_treatment_teeth (patient_treatment_fk_id,teethNumber)
SELECT patienttreatmentid,tooth
from sident. treatmenttooth;
ALTER TABLE `patient_treatment_teeth` ADD INDEX `teethNumber` (`teethNumber`);

-- invoice table
-- INSERT INTO sident_new.invoice (invoice_date, patient_fk_id, created_by,status)
-- SELECT ci.Date, p.id, 2 AS created_by, 1 AS status
-- FROM sident.cwc_invoice_items ci
-- INNER JOIN sident_new.patient p ON ci.patient_id = p.patient_id;
INSERT INTO dental_be.invoice (invoice_date, patient_fk_id, created_by,status,total_amount,total_paid_amount)
SELECT null, p.id, 2 AS created_by, 1 AS status,ci.txamount,ci.txamount
FROM dental_new.cwc_invoice_items ci
INNER JOIN dental_be.patient p ON ci.patient_id = p.patient_id;

-- payment table
-- ALTER TABLE `payment` DROP INDEX `fk_payments_1_idx`;
-- ALTER TABLE `payment` DROP INDEX `fk_payments_2`;
INSERT INTO sident_new.payment (payment_date,ref_fk_id,created_by)
SELECT Date,invoice_id,2 as created_by
FROM sident.cwc_payment ;
-- medicine_template
INSERT into sident_new. medicine_template (medicine_templateName)
SELECT PresciptionName
from sident. prescriptionset;
-- medicine_template_item
INSERT INTO sident_new.invoice_item (invoice_fk_id, treatment_fk_id, description,amount)
SELECT invoice_no,treatmentdetailsid,treatmentname,txamount
FROM sident.cwc_invoice_items ci;
