<?php 

class ManageCSV {

    private $file; 
    private $handle; 

    public function __construct($filename, $mode = 'r')
    {
        if(!is_string($filename)) {
            throw new InvalidArgumentException('Parameter $file must be a string. Provided type: ' . gettype($filename));
        }
        $this->file = $filename;
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
            // generate csv lines from the inner arrays
            fputcsv($this->handle, $line); 
        }
        rewind($this->handle);
    }

    public function export()
    {
        fpassthru($this->handle);
    }
}