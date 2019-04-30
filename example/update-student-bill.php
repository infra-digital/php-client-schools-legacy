<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '10014';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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