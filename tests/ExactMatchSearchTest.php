<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use BIMu\BIMu;

class ExactMatchSearchTest extends TestCase
{
    /**
     * Loads the env
     */
    public function loadEnv()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
    }

    /**
     * Tests getting NO results from an exact match search.
     */
    public function testGetNoRecordsFromExactMatchSearch()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("CONST_MODULE"));
        $bimu->search(
            [getenv("CONST_RECORD_TYPE") => getenv("CONST_RECORD_VALUE_EXACT_NO")],
            [getenv("ID_FIELD"), getenv("CONST_RECORD_TYPE")],
            "="
        );
        $records = $bimu->getAll();

        $this->assertEmpty($records);
    }

    /**
     * Tests getting results from an exact match search.
     */
    public function testGetRecordsFromExactMatchSearch()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("CONST_MODULE"));
        $bimu->search(
            [getenv("CONST_RECORD_TYPE") => getenv("CONST_RECORD_VALUE_EXACT_YES")],
            [getenv("ID_FIELD"), getenv("CONST_RECORD_TYPE")],
            "="
        );
        $records = $bimu->getAll();

        $this->assertNotEmpty($records);
    }
}
