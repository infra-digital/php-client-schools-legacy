<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
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
$response = $idnConnector->createStudent(
    'Test User 01',
    '10001',
    '0987612345',
    'use.only@valid.domain',
    'This is test to create user'
    //'branch_code' //Uncomment this line to use difference branch code from $username
);
echo'Create Student : <br>';var_dump($response);echo "<br><br>";

