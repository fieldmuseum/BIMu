<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use BIMu\BIMu;

class EMuServerTest extends TestCase
{
    /**
     * Tests that we found some results.
     */
    public function testConnection()
    {
        $dotenv = new Dotenv(__DIR__ . '/..');
        $dotenv->load();
        $bimu = new BIMu(getenv("EMU_IP"), getenv("EMU_PORT"), getenv("NARRATIVES_MODULE"));
        $bimu->search(
            [getenv("NARRATIVES_TITLE_FIELD") => getenv("EXAMPLE_NARRATIVE_TITLE")],
            [getenv("ID_FIELD"), getenv("NARRATIVES_TITLE_FIELD")]
        );
        $records = $bimu->getAll();

        $this->assertNotEmpty($records);
    }

    /**
     * Tests EMu server login
     */
    public function testLogin()
    {
        $dotenv = new Dotenv(__DIR__ . '/..');
        $dotenv->load();
        $bimu = new BIMu(
            getenv("EMU_IP"),
            getenv("EMU_PORT"),
            getenv("NARRATIVES_MODULE"),
            [getenv("USER") => getenv("PASSWORD")]
        );

        $this->assertNotEmpty($bimu);
    }
}
