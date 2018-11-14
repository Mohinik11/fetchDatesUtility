<?php

use PHPUnit\Framework\TestCase;
use FindDate\PaymentDate;
use FindDate\ManageCSV;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class ManageCSVTest extends TestCase
{
    /**
     * fs directory
     *
     * @type  vfsStream
     */
    protected $fs;

    /**
     * file
     *
     * @type  vfsStream file
     */
    protected $file;

    /**
     * csv
     *
     * @type  ManageCSV
     */
    protected $csv;
    
    /**
     * set up test environmemt
     */
    public function setUp()
    {
        $this->fs = vfsStream::setup('testDir');
        $this->file = new vfsStreamFile('test.csv');
        $this->fs->addChild($this->file);
        $this->csv = new ManageCSV($this->fs->url().'/test');
    }

    /**
     * test for constructor
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(
            ManageCSV::class,
            new ManageCSV($this->fs->url().'/test')
        );
    }

    /**
     * test for constructor
     */
    public function testConstructorthrowException()
    {
        $this->expectException(\Exception::class);
        $this->file->chmod(0);
        new ManageCSV($this->fs->url().'/test');
    }

    /**
     * test for closing file
     */
    public function testCloseTrue()
    {
        $this->assertTrue($this->csv->close());
    }

    /**
     * test for writing file
     */
    public function testWriteTrue()
    {
        $this->assertTrue($this->csv->write([[1,2,3]]));
    }

    /**
     * test for exporting file
     */
    public function testExportTrue()
    {
        $this->assertEquals(0, $this->csv->export());
    }

}