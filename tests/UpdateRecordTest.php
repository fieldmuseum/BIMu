<?php

namespace BIMu\Tests;

use PHPUnit\Framework\TestCase;
use BIMu\BIMu;

class UpdateRecordTest extends TestCase
{
    /**
     * Test updating all record function.
     */
    public function testUpdateAllRecordFunction()
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
            ['irn', getenv('NARRATIVES_TITLE_FIELD')
        ]);
        $result = $bimu->update(
            [
                getenv('INSERT_NARR_TITLE_FIELD') => getenv('UPDATE_NARR_TITLE_VALUE'),
            ],
            [getenv('NARRATIVES_TITLE_FIELD'), getenv('INSERT_NARR_SUBTITLE_FIELD')]
        );
        $this->assertNotEmpty($result);
    }

    /**
     * Test updating a single record function.
     */
    public function testUpdateOneRecordFunction()
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
            ['irn', getenv('NARRATIVES_TITLE_FIELD')
        ]);
        $result = $bimu->updateOne(
            [
                getenv('INSERT_NARR_TITLE_FIELD') => getenv('UPDATE_NARR_TITLE_VALUE'),
            ],
            [getenv('NARRATIVES_TITLE_FIELD'), getenv('INSERT_NARR_SUBTITLE_FIELD')]
        );
        $this->assertNotEmpty($result);
    }
}
