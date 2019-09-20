<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '90001';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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