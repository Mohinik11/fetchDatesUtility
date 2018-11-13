<?php 

namespace CSV;

class ManageCSV {

    private $file; 
    private $handle; 

    public function __construct($filename, $mode = 'r')
    {
        $this->file = $filename . '.csv';
        $this->handle = fopen($this->file, $mode);
        return $this->file;
    }

    public function __destruct()
    {
        if(is_resource($this->handle)) {
            $this->close();
        }
    }

    public function close()
    {
        fclose($this->handle); 
    }

    public function write($data)
    {
        foreach ($data as $line) { 
            fputcsv($this->handle, $line); 
        }
        rewind($this->handle);
    }

    public function export()
    {
        fpassthru($this->handle);
    }
}