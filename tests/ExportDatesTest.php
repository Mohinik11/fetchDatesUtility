<?php

use PHPUnit\Framework\TestCase;
use FindDate\ExportDates;
use FindDate\ManageCSV;
use org\bovigo\vfs\vfsStream;

class ExportDatesTest extends TestCase
{
    /**
     * fs directory
     *
     * @type  vfsStream
     */
    protected $fs;

    /**
     * csvHandler
     *
     * @type  ManageCSV
     */
    protected $csvHandler;

    /**
     * paymentDate
     *
     * @type  ExportDate
     */
    protected $paymentDate;

    /**
     * set up test environmemt
     */
    public function setUp()
    {
        $this->fs = vfsStream::setup('testDir');
        vfsStream::newFile('test.csv')->at($this->fs);
        $this->csvHandler = $this->getMockBuilder('FindDate\ManageCSV')
            ->setConstructorArgs([$this->fs->url().'/test'])
            ->getMock();
        $this->paymentDate = new ExportDates($this->csvHandler);
    }

    /**
     * test for constructor
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(
            ExportDates::class,
            new ExportDates($this->csvHandler)
        );
    }

    /**
     * test for Error while wrting to file
     */
    public function testExportExportDatesErrorWriting()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(false);
        $this->assertEquals('Error in writing file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for Error while downloading the file
     */
    public function testExportExportDatesErrorDownloading()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(false);
        $this->assertEquals('Error in downloading file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for Error while closing the file
     */
    public function testExportExportDatesErrorClosing()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('close')->willReturn(false);
        $this->assertEquals('Error in closing file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for successful processing of file
     */
    public function testExportExportDatesSuccess()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('close')->willReturn(true);
        $this->assertTrue($this->paymentDate->exportPaymentDates());
    }

}