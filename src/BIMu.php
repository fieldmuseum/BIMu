<?php

namespace BIMu;

class BIMu {

    /** @var string EMu server IP */
    private $ip; 

    /** @var int EMu server port */
    private $port;

    /** @var IMuSession session variable */
    private $session;

    /** @var IMuModule module variable */
    private $module;

    /** @var string name of the module we're querying */
    private $moduleName;

    /** @var IMuTerms IMu search terms */
    private $terms;

    /** @var array The fields we'd like to return in the results */
    private $fields;

    /** @var int The number of hits found from our search */
    private $hits;

    /** @var IMuModuleFetchResult The result from the search */
    private $result;

    /** @var array Any array of records returned from the search */
    private $records;

    /**
     * Object constructor
     */
    public function __construct($ip, $port, $moduleName, $login = null)
    {
        $this->ip = $ip;
        $this->port = $port;
        $this->moduleName = $moduleName;
        $this->session = new \IMuSession($this->ip, $this->port);
        $this->module = new \IMuModule($this->moduleName, $this->session);

        if (isset($login) && is_array($login)) {
            $username = (string) key($login);
            $password = (string) reset($login);
            $this->session->login($username, $password);
        }
    }

    /**
     * Object destructor
     */
    public function __destruct()
    {
        $this->session->logout();
    }

    /**
     * Search the EMu module.
     *
     * @param array $criteria
     *   Array of key, value pairs of the fieldname and value we're looking for.
     *   This defaults to IMuTerms AND condition. Add true as third param for
     *   OR searches.
     *
     * @param array $fields
     *   The machine names of the field we want to retrieve from the Module.
     *
     * @return BIMu
     *   Returns this object.
     */
    public function search(array $criteria, array $fields, bool $or = false) : BIMu
    {
        $this->fields = $fields;

        if ($or) {
            $this->terms = new \IMuTerms('OR');
        } else {
            $this->terms = new \IMuTerms();
        }

        foreach ($criteria as $key => $value) {
            $this->terms->add($key, $value);
        }

        $this->hits = $this->module->findTerms($this->terms);

        return $this;
    }

    /**
     * Return all results.
     *
     * @return array
     *   Returns an array of the records searched.
     */
    public function getAll() : array
    {
        $this->result = $this->module->fetch('start', 0, -1, $this->fields);
        $this->records = $this->result->rows;

        return $this->records;
    }

    /**
     * Return an arbitrary number of records.
     *
     * @param int $number
     *   The number of results we'd like returned.
     *
     * @return array
     *   Returns an array of the records searched.
     */
    public function get(int $number) : array
    {
        if ($number == 1) {
            $this->getOne();
        }
        else {
            $this->result = $this->module->fetch('start', 0, $number, $this->fields);
            $this->records = $this->result->rows;

            return $this->records;
        }
    }

    /**
     * Return the first result.
     *
     * @return array
     *   Returns an array of the records searched.
     */
    public function getOne() : array
    {
        $this->result = $this->module->fetch('start', 0, 1, $this->fields);
        $this->records = $this->result->rows;

        return $this->records;
    }
}