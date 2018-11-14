<?php 

namespace FindDate;

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
        $this->handle = @fopen($this->file, $mode);
        if(!$this->handle) {
            throw new \Exception('File open failed.');
        }
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
       return fclose($this->handle); 
    }

    /**
     * writes data to file, rewind handle
     * @param array $data
     */
    public function write($data)
    {
        try {
            foreach ($data as $line) {
                fputcsv($this->handle, $line); 
            }
            rewind($this->handle);
        } catch(Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * exports file
     */
    public function export()
    {
        return fpassthru($this->handle);
    }
}