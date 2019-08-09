<?php

class FileExplorer
{
    public $path;
    public $currentDirectoryList;

    public function getPath()
    {
        return file_get_contents("./cwd");
    }

    public function setPath()
    {
        file_put_contents("./cwd", $this->path);
    }

    public function getDirectoryList()
    {
        foreach (new DirectoryIterator($this->path) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $this->currentDirectoryList[] = [
                'el' => $fileInfo->getFileName(),
                'type' => $fileInfo->isDir() ? 'dir' : 'file',
            ];
        }
    }

    public function display()
    {
        echo '<a href="./index.php?type=up">Up a level</a>';
        echo '<br>';
        echo "Current directory: $this->path";
        echo '<br>';

        foreach ($this->currentDirectoryList as $value) {
            $fileRow = ($value['type'] === 'dir') ? 'Dir: ' . $value['el'] : 'File: ' . $value['el'];
            $link = ($value['type'] === 'dir') ? "<a href='./index.php?type=into&name={$value['el']}'>Go into dir</a>" : "<a href='./index.php?type=open&name={$value['el']}'>Open file</a>";
            echo $fileRow . ' ' . $link;
            echo '<br>';
        }
    }

    public function manageClick()
    {
        $type = $_GET['type'];
        $name = $_GET['name'];
        switch ($type) {
            case NULL:
                $this->path = __DIR__;
                $this->setPath();
                $this->getDirectoryList();
                $this->display();
                break;
            case 'up':
                $this->path = $this->getPath();
                $this->path = dirname($this->path, 1);
                $this->setPath();
                $this->getDirectoryList();
                $this->display();
                break;
            case 'into':
                $this->path = $this->getPath();
                $this->path = $this->path . "\\$name\\";
                $this->setPath();
                $this->getDirectoryList();
                $this->display();
                break;
            case 'open':
                $this->path = $this->getPath();
                $filename = $this->path . "\\$name";
                echo $filename;
                popen($filename, 'r');
                header('Location:' . $_SERVER['HTTP_REFERER']);
                break;
        }
    }
}
