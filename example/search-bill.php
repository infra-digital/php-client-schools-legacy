<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '10014';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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