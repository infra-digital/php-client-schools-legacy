<?php
namespace IDNConnector;
require_once dirname(__FILE__) . '/ConnectorLibrary.php';

/**
 * Main Connector class
 * https://www.infradigital.io/api-docs#introduction
 * (c)2018 Infra Digital Nusantara
 *
 * Class IDNConnector
 */
class IDNConnector extends ConnectorLibrary
{
    private $env                = Constants::DEV_PROD;
    private $username           = '';
    private $password           = '';
    private $studentsData       = array();
    private $billComponentData  = array();

    /**
     * IDNConnector constructor.
     * Use the class with provide $username and $password IDNConnector($username, $password)
     * @param $username
     * @param $plainPassword
     */
    public function __construct($username, $plainPassword)
    {
        $this->username = $username;
        $this->password = $this->passwordHash($plainPassword);
    }

    /**
     * Make current operation mode to DEVELOPMENT mode
     */
    public function devMode()
    {
        $this->env = Constants::DEV_ENV;
    }

    /**
     * Used to append a new student data before send to API (Batch)
     *
     * @param $name
     * @param $billKeyValue
     * @param string $phone
     * @param string $email
     * @param string $description
     * @return $this
     */
    public function appendStudentData($name, $billKeyValue, $phone = '', $email = '', $description = '', $branch_code = '')
    {
        $this->studentsData[] = array(
            'name'              => $name,
            'bill_key_value'    => $billKeyValue,
            'phone'             => $phone,
            'email'             => $email,
            'description'       => $description,
            'branch_code'       => $branch_code,
        );

        return $this;
    }

    /**
     * Used to send the appended student data to API
     *
     * @return bool|mixed
     */
    public function createStudents()
    {
        if (empty($this->studentsData)) {
            return false;
        }

        $content = array(
            'bill_list' => $this->studentsData,
        );

        $this->studentsData = array();

        return $this->curlExec(
            Constants::POST_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill/batch', array(), $this->env),
            $content);
    }

    /**
     * Used for create a new student data
     *
     * @param $name
     * @param $billKeyValue
     * @param string $phone
     * @param string $email
     * @param string $description
     * @return mixed
     */
    public function createStudent($name, $billKeyValue, $phone = '', $email = '', $description = '', $branch_code = '')
    {
        $this->appendStudentData($name, $billKeyValue, $phone, $email, $description, $branch_code);
        $content = $this->studentsData[0];
        $this->studentsData = array();

        return $this->curlExec(
            Constants::POST_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill', array(), $this->env),
            $content);
    }

    /**
     * Used to update existing student data
     *
     * @param $name
     * @param $billKeyValue
     * @param string $phone
     * @param string $email
     * @param string $description
     * @return mixed
     */
    public function updateStudent($name, $billKeyValue, $phone = '', $email = '', $description = '', $branch_code = '')
    {
        $content = array(
            'name'              => $name,
            'bill_key_value'    => $billKeyValue,
            'phone'             => $phone,
            'email'             => $email,
            'description'       => $description,
            'branch_code'       => $branch_code,
        );

        return $this->curlExec(
            Constants::PUT_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill', array(), $this->env),
            $content);
    }

    /**
     * Used to append bill component data
     *
     * @param $billKey
     * @param $accountCode
     * @param $billComponentName
     * @param $amount
     * @param $expiryDate
     * @param $dueDate
     * @param string $activeDate
     * @param int $penaltyAmount
     * @param string $notes
     * @return $this
     */
    public function appendBillComponentData($billKey, $accountCode, $billComponentName, $amount, $expiryDate, $dueDate, $activeDate = '', $penaltyAmount  = 0, $notes = '', $branch_code = '')
    {
        $this->billComponentData[] = array(
            'bill_key'              => $billKey,
            'account_code'          => $accountCode,
            'bill_component_name'   => $billComponentName,
            'expiry_date'           => $this->convertDatetimeToIso($expiryDate),
            'due_date'              => $this->convertDatetimeToIso($dueDate),
            'amount'                => $amount,
            'active_date'           => $this->convertDatetimeToIso($activeDate),
            'penalty_amount'        => $penaltyAmount,
            'notes'                 => $notes,
            'branch_code'           => $branch_code,
        );

        return $this;
    }

    /**
     * Used to send appended bill component data to API
     *
     * @return bool|mixed
     */
    public function addBillComponents($billComponents = array())
    {
        if ( ! empty($billComponents)) {
            $this->billComponentData = $billComponents;
        }

        if (empty($this->billComponentData)) {
            return false;
        }

        $content = array(
            'bill_upload_list' => $this->billComponentData,
        );

        return $this->curlExec(
            Constants::POST_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/batch', array(), $this->env),
            $content);
    }

    /**
     * Update bill component data to API
     *
     * @param $billComponentID
     * @param $lastUpdateBy
     * @param $billerCode
     * @param $billKey
     * @param $accountCode
     * @param $billComponentName
     * @param $amount
     * @param $expiryDate
     * @param $dueDate
     * @param $activeDate
     * @param $penaltyAmount
     * @param $batchId
     * @param string $notes
     * @return mixed
     */
    public function updateBillComponent($billComponentID, $lastUpdateBy, $billerCode, $billKey, $accountCode, $billComponentName, $amount, $expiryDate, $dueDate, $activeDate, $penaltyAmount, $batchId, $notes = '', $branch_code= '')
    {
        $content = array(
            'id'                    => $billComponentID,
            'last_update_by'        => sprintf("%s(%s)", $lastUpdateBy, $this->username),
            'biller_code'           =>  $billerCode,
            'bill_key'              => $billKey,
            'account_code'          => $accountCode,
            'bill_component_name'   => $billComponentName,
            'expiry_date'           => $this->convertDatetimeToIso($expiryDate),
            'due_date'              => $this->convertDatetimeToIso($dueDate),
            'amount'                => $amount,
            'active_date'           => $this->convertDatetimeToIso($activeDate),
            'penalty_amount'        => $penaltyAmount,
            'batch_id'              => $batchId,
            'notes'                 => $notes,
            'branch_code'           => $branch_code,
        );

        return $this->curlExec(
            Constants::PUT_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component', array(), $this->env),
            $content);
    }

    /**
     * Used to delete bill component
     *
     * @param $deleteBy
     * @param array $billComponentId
     * @param string $transferRef
     * @return mixed
     */
    public function deleteBillComponent($deleteBy, array $billComponentId, $transferRef = '')
    {
        $content = array(
            'update_by'         => sprintf("%s(%s)", $deleteBy, $this->username),
            'bill_component_id' => $billComponentId,
            'transfer_ref'      => $transferRef,
        );

        return $this->curlExec(
            Constants::POST_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/delete', array(), $this->env),
            $content);
    }

    /**
     * Used to update payment status of the bill component
     *
     * @param $billerCode
     * @param $billKey
     * @param $billerRefNumber
     * @param array $billComponentList
     * @return mixed
     */
    public function updateBillComponentPaymentStatus($billerCode, $billKey, $billerRefNumber, array $billComponentList)
    {
        $content = array(
            'biller_code'           => $billerCode,
            'bill_key'              => $billKey,
            'biller_ref_number'     => $billerRefNumber,
            'bill_component_list'   => $billComponentList,
        );

        return $this->curlExec(
            Constants::POST_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/pay', array(), $this->env),
            $content);
    }

    /**
     * Get student data
     *
     * @param string $name
     * @param string $billKey
     * @param int $offset
     * @param int $limit
     * @return mixed
     */
    public function getStudents($name = '', $billKey = '', $offset = 0, $limit = 0)
    {
        $path = 'bill';
        $query = array();
        if ($name != '') {
            $query['name'] = $name;
        }
        if ($name != '') {
            $query['bill_key'] = $billKey;
        }
        if ($name != '') {
            $query['offset'] = $offset;
        }
        if ($name != '') {
            $query['limit'] = $limit;
        }

        return $this->curlExec(
            Constants::GET_METHOD,
            $this->buildApiURI($this->username, $this->password, $path, $query, $this->env),
            '');
    }

    /**
     * Search for bill(s)
     *
     * @param array $query
     * @return mixed
     */
    public function getBills($query = array())
    {
        return $this->curlExec(
            Constants::GET_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/search/biller', $query, $this->env),
            '');
    }

    /**
     * Get a Students Bills
     *
     * @param $nis
     * @param array $query
     * @return mixed
     */
    public function getStudentBills($nis, $query = array())
    {
        $query['bill_key'] = $nis;

        return $this->curlExec(
            Constants::GET_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/search/bill', $query, $this->env),
            '');
    }

    /**
     * Get a Students Bills
     *
     * @param $nis
     * @param array $query
     * @return mixed
     */
    public function getBillByID($id)
    {
        return $this->curlExec(
            Constants::GET_METHOD,
            $this->buildApiURI($this->username, $this->password, 'bill_component/get/' . $id, array(), $this->env),
            '');
    }
}