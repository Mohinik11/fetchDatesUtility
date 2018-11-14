<?php

use PHPUnit\Framework\TestCase;
use FindDate\PaymentDate;
use FindDate\ManageCSV;
use org\bovigo\vfs\vfsStream;

class PaymentDateTest extends TestCase
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
     * @type  PaymentDate
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
        $this->paymentDate = new PaymentDate($this->csvHandler);
    }

    /**
     * test for constructor
     */
    public function testCanBeInstantiated()
    {
        $this->assertInstanceOf(
            PaymentDate::class,
            new PaymentDate($this->csvHandler)
        );
    }

    /**
     * test for Error while wrting to file
     */
    public function testExportPaymentDatesErrorWriting()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(false);
        $this->assertEquals('Error in writing file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for Error while downloading the file
     */
    public function testExportPaymentDatesErrorDownloading()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(false);
        $this->assertEquals('Error in downloading file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for Error while closing the file
     */
    public function testExportPaymentDatesErrorClosing()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('close')->willReturn(false);
        $this->assertEquals('Error in closing file', $this->paymentDate->exportPaymentDates());
    }

    /**
     * test for successful processing of file
     */
    public function testExportPaymentDatesSuccess()
    {
        $this->csvHandler->expects($this->any())->method('write')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('export')->willReturn(true);
        $this->csvHandler->expects($this->any())->method('close')->willReturn(true);
        $this->assertTrue($this->paymentDate->exportPaymentDates());
    }

}