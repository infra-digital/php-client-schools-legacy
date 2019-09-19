<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '90001';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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