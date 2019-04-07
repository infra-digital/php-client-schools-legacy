<?php
/*
 * ===!!! USE THIS FILE ONLY FOR DEMO OR TESTING PURPOSE !!!===
 * This wrapper use for conventional PHP way.
 * If you using composer or PSR, please use the PSR wrapper.
 */

require_once 'IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '10014';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

/*
 * Create student (one by one)
 *
 * Method : createStudent($name, $billKeyValue, $phone = '', $email = '', $description = '')
 *
 * Arguments below :
 * $name : Please use alphabetical charachters only, without ' or " or -
 * $billKeyValue : Nomor Induk Siswa, Nomor Induk Mahasiswa.
 * $email : Optional
 * $description : Nama Kelas (Untuk Sekolah), Nama Paket (Untuk Bimbingan Belajar)
 *
 * Here is the example :
 */
$response = $idnConnector->createStudent('Test User', '0001','0987612345', 'use.only@valid.domain', 'This is test to create user');
echo'Create Student : <br>';var_dump($response);echo "<br><br>";


/*
 * Create students (batch) and you can use foreach to insert the data
 *
 * Method : appendStudentData($name, $billKeyValue, $phone = '', $email = '', $description = '')
 *
 * Arguments below :
 * $name : Please use alphabetical charachters only, without ' or " or -
 * $billKeyValue : Nomor Induk Siswa, Nomor Induk Mahasiswa.
 * $email : Optional
 * $description : Nama Kelas (Untuk Sekolah), Nama Paket (Untuk Bimbingan Belajar)
 *
 * Here is the example :
 */
$exampleStudentDataFromMySQL = array(
    array('name' => 'Test First Student', 'bill_key_value' => '0001', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user'),
    array('name' => 'Test Second Student', 'bill_key_value' => '0002', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user'),
    array('name' => 'Test Third Student', 'bill_key_value' => '0003', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user'),
    array('name' => 'Test Fourth Student', 'bill_key_value' => '0004', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user'),
);
/*
 * Now we have four list of array to simulate the result taken from database
 * now we will demonstrate how to use appendStudentData and createStudents to create student by batch
 * Remember! the data is only sample data, all the column name is only a sample, this may difference with your actual data.
 * You may change it to fit with your system
 */
foreach ($exampleStudentDataFromMySQL as $val) {
    /*
     * Here we use appendStudentData to add (append) student data before we commit it to the IDN API
     * Remember the argument passing to the method are sequenced :
     *
     * 1. $name
     * 2. $billKeyValue
     * 3. $phone
     * 4. $email
     * 5. $description
     */
    $idnConnector->appendStudentData(
        $val['name'],
        $val['bill_key_value'],
        $val['phone'],
        $val['email'],
        $val['description']
    );
}
/*
 * Then we call createStudents() to commit the appended data. and the method will return the response from the API
 * Remember we only need to call createStudents() once from the outside of iteration (foreach)
 */
$response = $idnConnector->createStudents();
echo'Create Student Batch : <br>';var_dump($response);echo "<br><br>";


/*
 * Add Bill Components (batch)
 *
 * appendBillComponentData($billKey, $accountCode, $billComponentName, $amount, $expiryDate, $dueDate, $activeDate = '', $penaltyAmount  = 0, $notes = ''))
 *
 * $billKey : Nomor Induk Siswa, Nomor Induk Mahasiswa. (Pastikan sudah dicreate sebelumnya)
 * $accountCode : Kode Rekening that has been provisioned by IDN. Please ask for the list of codes for your school
 * $amount : Amount of the bill to be charged
 * $expiryDate : Setelah tanggal ini bill tidak bisa dibayar (YYYMMDD)
 * $dueDate : Tanggal Kedaluarsa. Jika ada penalty, maka setelah tanggal ini akan bermulai ditagih (YYYMMDD)
 * $activeDate : Tanggal tagihan ini mulai dapat dibayar (Optional) (YYYMMDD)
 * $penaltyAmount : Penalti yang akan berlaku jika tagihan tidak dibayar sebelum dueDate
 * $notes : Optional Catatan
 */
$exampleBillComponentDataFromMySQL = array(
    array(
        'bill_key' => '0001',
        'account_code' => 'MANDIRI',
        'bill_component_name' => 'First bill component',
        'expiry_date' => '20190520',
        'due_date' => '20190520',
        'amount' => 100000,
        'active_date' => '20180520',
        'penalty_amount' => 0,
        'notes' => '',
    ),
    array(
        'bill_key' => '0002',
        'account_code' => 'MANDIRI',
        'bill_component_name' => 'Second bill component',
        'expiry_date' => '20190520',
        'due_date' => '20190520',
        'amount' => 200000,
        'active_date' => '20180520',
        'penalty_amount' => 0,
        'notes' => '',
    ),
    array(
        'bill_key' => '0003',
        'account_code' => 'MANDIRI',
        'bill_component_name' => 'Third bill component',
        'expiry_date' => '20190520',
        'due_date' => '20190520',
        'amount' => 300000,
        'active_date' => '20180520',
        'penalty_amount' => 0,
        'notes' => '',
    ),
);
/*
 * Now we have three list of array to simulate the result taken from database
 * now we will demonstrate how to use appendBillComponentData and addBillComponents to create bill component(s) by batch
 * Remember! the data is only sample data, all the column name is only a sample, this may difference with your actual data.
 * You may change it to fit with your system
 */
foreach ($exampleBillComponentDataFromMySQL as $val) {
    /*
     * Here we use appendBillComponentData to add (append) bill component(s) data before we commit it to the IDN API
     * Remember the argument passing to the method are sequenced :
     * 1. $billKey
     * 2. $accountCode
     * 3. $billComponentName
     * 4. $amount
     * 5. $expiryDate
     * 6. $dueDate
     * 7. $activeDate
     * 8. $penaltyAmount
     * 9. $notes
     */
    $idnConnector->appendBillComponentData(
        $val['bill_key'],
        $val['account_code'],
        $val['bill_component_name'],
        $val['amount'],
        $val['expiry_date'],
        $val['due_date'],
        $val['active_date'],
        $val['penalty_amount'],
        $val['notes']
    );
}
/*
 * Then we call addBillComponents() to commit the appended data. and the method will return the response from the API
 * Remember we only need to call addBillComponents() once from the outside of iteration (foreach)
 */
$response = $idnConnector->addBillComponents();
echo'Add Bill Component : <br>';print_r($response);echo "<br><br>";


/*
 * Get student data
 *
 * getStudents($name = '', $billKey = '', $offset = 0, $limit = 0)
 *
 * $billKey: Nomor Induk Siswa, Nomor Induk Mahasiswa.
 * $offset: For pagination, start results at record number $offset 
 * $limit: Limit Result yang akan di return. Default 50 siswa. Maximal 1500 siswa
 */
$response = $idnConnector->getStudents('Test User', '', 0, 5);
echo'Get Student : <br>';var_dump($response);echo "<br><br>";

/*
 * Search for bill(s)
 *
 * getBills($query = array())
 *
 * This API lets you search bills within your school according to search criteria.
 * In addition we also provide some specific examples of common queries in the next sections.
 * If there is no search criteria or query parameters, then by default the system will return 50 latest bills.
 */
$response = $idnConnector->getBills();// without parameters (return 50 latest bills)
echo'Get Bills without parameter: <br>';var_dump($response);echo "<br><br>";

/*
 * Available parameters
 *
 * state => "provisioned", "expired" or "paid"
 * account_code => Account Code (destination of funds)
 * start_payment_date => Bills that were paid after this date (YYYYMMDD)
 * end_payment_date => Bills that were paid before this date (YYYYMMDD)
 * start_due_date => Bills that are due after this date (YYYYMMDD)
 * end_due_date => Bills that are due before this date (YYYYMMDD)
 * offset => Offset of results (for pagination)
 * limit => Limit on number of results, default = 50
 *
 * All of the parameters is optional, but you can include some or all of them (make it fit with your PHP project)
 */
$parameters = array(
    'state' => 'provisioned',
    'account_code' => 'BCA',
    'ref_number' => 'KHJG21',
    'start_payment_date' => '20180320',
    'end_payment_date' => '20180320',
    'start_due_date' => '20180320',
    'end_due_date' => '20180320',
    'offset' => '0',
    'limit' => '50',
    'notes' => '999'
);
$response = $idnConnector->getBills($parameters);// with parameters
echo'Get Student with parameter: <br>';var_dump($response);echo "<br><br>";

/*
 * Get a Students Bills
 * getStudentBills($nis, $parameters = array())
 * Here you must provide the NIS and the parameters is optional
 *
 * You must include the NIS
 *
 * Available parameters
 *
 * state => "provisioned", "expired" or "paid"
 * account_code => Account Code (destination of funds)
 * start_payment_date => Bills that were paid after this date (YYYYMMDD)
 * end_payment_date => Bills that were paid before this date (YYYYMMDD)
 * start_due_date => Bills that are due after this date (YYYYMMDD)
 * end_due_date => Bills that are due before this date (YYYYMMDD)
 * offset => Offset of results (for pagination)
 * limit => Limit on number of results, default = 50
 *
 * All of the parameters is optional, but you can include some or all of them (make it fit with your PHP project)
 */
$nis = "0001";
$parameters = array();
$studentBills = $idnConnector->getStudentBills($nis, $parameters);
echo'Get Student bill: <br>';var_dump($studentBills);echo '<br><br>';
$studentBillsData = $studentBills['data'];

/*
 * Here we use updateBillComponent to update component data then commit it to the IDN API
 * Remember the argument passing to the method are sequenced :
 * 1. $billKey
 * 2. $lastUpdateBy
 * 3. $billerCode
 * 4. $billKey
 * 2. $accountCode
 * 3. $billComponentName
 * 4. $amount
 * 5. $expiryDate
 * 6. $dueDate
 * 7. $activeDate
 * 8. $penaltyAmount
 * 9. $notes
 */
$update = $idnConnector->updateBillComponent(
    $studentBillsData[0]['bill_component_id'],
    'Automatic-Updater',
    $username,
    '0001',
    'MANDIRI',
    'Updated bill component',
    2000000,
    '20190501',
    '20190501',
    '20190401',
    0,
    $studentBillsData[0]['bill_component_id'],
    ''
);
echo'Update Bill Component: <br>';var_dump($update);echo '<br><br>';

