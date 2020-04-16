<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use BIMu\BIMu;

class DeleteRecordTest extends TestCase
{
    /**
     * Test deleting records.
     */
    public function testDeleteRecordsFunction()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
        $dotenv->load();
        $bimu = new BIMu(
            getenv("EMU_IP"),
            getenv("EMU_PORT"),
            getenv("NARRATIVES_MODULE"),
            [getenv("EMU_USER") => getenv('PASSWORD')]
        );
        $bimu->search(
            ['irn' => getenv('UPDATE_TEST_IRN')],
            ['irn', getenv('NARRATIVES_TITLE_FIELD')]
        );
        $numRecordsDeleted = $bimu->delete(1);

        $this->assertEquals(1, $numRecordsDeleted);
    }
}
