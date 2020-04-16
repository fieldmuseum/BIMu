<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use BIMu\BIMu;

class InsertRecordTest extends TestCase
{
    /**
     * Test inserting a record.
     */
    public function testInsertRecord()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
        $bimu = new BIMu(
            getenv("EMU_IP"),
            getenv("EMU_PORT"),
            getenv("NARRATIVES_MODULE"),
            [getenv("EMU_USER") => getenv('PASSWORD')]
        );
        $result = $bimu->insert(
            [
                getenv('INSERT_NARR_TITLE_FIELD') => getenv('INSERT_NARR_TITLE_VALUE'),
                getenv('INSERT_NARR_SUBTITLE_FIELD') => getenv('INSERT_NARR_SUBTITLE_VALUE')
            ],
            [getenv('INSERT_NARR_TITLE_FIELD'), getenv('INSERT_NARR_SUBTITLE_FIELD')]
        );
        $this->assertNotEmpty($result);
    }
}
