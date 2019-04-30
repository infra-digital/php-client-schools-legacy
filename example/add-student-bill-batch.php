<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '10014';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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