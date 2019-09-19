<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '90001';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

$nis = "0001";
$parameters = array();
$studentBills = $idnConnector->getStudentBills($nis, $parameters);
echo'Get Student bill: <br>';var_dump($studentBills);echo '<br><br>';

$studentBillsData = $studentBills['data'];

$updatePaymentStatus = $idnConnector->updateBillComponentPaymentStatus(
    $username,
    '0001',
    '',
    array(
        $studentBillsData[0]['bill_component_id']
    )
);
echo'Update Bill Component Payment Status: <br>';var_dump($updatePaymentStatus);echo '<br><br>';