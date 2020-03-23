<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use BIMu\BIMu;

class BasicTest extends TestCase
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
     * Tests BIMu instance.
     */
    public function testInstance()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));

        $this->assertInstanceOf(BIMu::class, $bimu);
    }

    /**
     * Tests getting all search results.
     */
    public function testGetAll()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_SUBJECTS") => getenv("EXAMPLE_SUBJECT")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $records = $bimu->getAll();

        $this->assertNotEmpty($records);
        $this->assertGreaterThan(1, count($records));
    }

    /**
     * Tests getting a certain number of search results.
     */
    public function testGetSome()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_SUBJECTS") => getenv("EXAMPLE_SUBJECT")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $records = $bimu->get(9);
 
        $this->assertNotEmpty($records);
        $this->assertEquals(9, count($records));
    }

    /**
     * Tests getting one search result.
     */
    public function testGetOne()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_TITLE_FIELD") => getenv("EXAMPLE_NARRATIVE_TITLE")],
            [getenv("ID_FIELD")]
        );
        $records = $bimu->getOne();
 
        $this->assertNotEmpty($records);
        $this->assertEquals(2, count($records));
    }

    /**
     * Tests search returns array
     */
    public function testSearchResultsArray()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_TITLE_FIELD") => getenv("EXAMPLE_NARRATIVE_TITLE")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $records = $bimu->getAll();

        $this->assertArrayHasKey(0, $records);
    }

    /**
     * Tests search results hits
     */
    public function testHits()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_TITLE_FIELD") => getenv("EXAMPLE_NARRATIVE_TITLE")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $hits = $bimu->hits();

        $this->assertIsInt($hits);
        $this->assertGreaterThan(0, $hits);
    }

    /**
     * Tests search results count
     */
    public function testCount()
    {
        $this->loadEnv();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_TITLE_FIELD") => getenv("EXAMPLE_NARRATIVE_TITLE")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $bimu->getAll();
        $count = $bimu->count();

        $this->assertIsInt($count);
        $this->assertGreaterThan(0, $count);
    }
}
