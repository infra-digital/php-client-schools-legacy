<?php
require_once dirname(__FILE__) . '/../IDNConnector.php'; // include the main class file
use IDNConnector\IDNConnector; // since we used namespace you should call the class using "use" or call it directly (new IDNConnector\IDNConnector($user, $pass))

$username = '10014';
$password = '123';
$idnConnector = new IDNConnector($username, $password); // Initiate the class and provide valid username and password IDNConnector($username, $password)
$idnConnector->devMode(); // Use this method to initiated the dev mode. This will use IDN development API URI testclient.infradigital.io

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
    array('name' => 'Test First Student', 'bill_key_value' => '0001', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user', 'branch_code' => ''),
    array('name' => 'Test Second Student', 'bill_key_value' => '0002', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user', 'branch_code' => ''),
    array('name' => 'Test Third Student', 'bill_key_value' => '0003', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user', 'branch_code' => ''),
    array('name' => 'Test Fourth Student', 'bill_key_value' => '0004', 'phone' => '0987612345', 'email' => 'use.only@valid.domain', 'description' => 'This is test to create user', 'branch_code' => ''),
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
     * 6. $branch_code
     */
    $idnConnector->appendStudentData(
        $val['name'],
        $val['bill_key_value'],
        $val['phone'],
        $val['email'],
        $val['description']
        //$val['branch_code']
    );
}
/*
 * Then we call createStudents() to commit the appended data. and the method will return the response from the API
 * Remember we only need to call createStudents() once from the outside of iteration (foreach)
 */
$response = $idnConnector->createStudents();
echo'Create Student Batch : <br>';var_dump($response);echo "<br><br>";