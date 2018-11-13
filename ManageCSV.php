<?php 

namespace CSV;

/**
 * ManageCSV
 * 
 * writes data to csv file and exports it
 *
 */
class ManageCSV {

    /**
     * filename
     * @var string
     */
    private $file;

    /**
     * handle of the file
     * @var resource
     */
    private $handle;

    /**
     * Class constructor
     * @param string $filename
     * @param string $mode
     */
    public function __construct($filename, $mode = 'r')
    {
        $this->file = $filename . '.csv';
        $this->handle = fopen($this->file, $mode);
    }

    /**
     * Class destructor
     */
    public function __destruct()
    {
        if(is_resource($this->handle)) {
            $this->close();
        }
    }

    /**
     * closes file 
     */
    public function close()
    {
        fclose($this->handle); 
    }

    /**
     * writes data to file, rewind handle
     * @param array $data
     */
    public function write($data)
    {
        foreach ($data as $line) {
            fputcsv($this->handle, $line); 
        }
        rewind($this->handle);
    }

    /**
     * exports file
     */
    public function export()
    {
        fpassthru($this->handle);
    }
}