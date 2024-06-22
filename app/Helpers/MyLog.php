<?php
namespace App\Helpers;

use App\Models\Settings;

class MyLog {
    protected static self|null $instance = null;

    final private function __construct() {
        $this->format = Settings::getValue('format');
        $this->path = Settings::getValue('path');
    }
    final protected function __clone(){}
    final public function __wakeup(){}


    public static function getInstance(): self
    {
        if(static::$instance === null)
            static::$instance = new static();

        return static::$instance;
    }

    protected string $format = 'txt';
    protected string $path = '/nikita/log/1';

    private function getFileName(): string
    {
        return $this->path.'.'.$this->format;
    }

    private function write($message, $type = 'info', $caller = null): void
    {
        $write = [
            'type' => match ($type) {
                'info' => 'Info',
                'warning' => 'Warning',
                'error' => 'Error'
            },
            'date' => date('d.m.Y H:i:s'),
            'content' => $message
        ];
        if(is_null($caller)) {
            $trace = debug_backtrace();
            $caller = $trace[2];
        }
        $write = [
            ...$write,
            'class' => $caller['class'] ?? null,
            'function' => $caller['function'] ?? null,
            'file' => $caller['file'] ?? null,
            'line' => $caller['line'] ?? null,
        ];


        if($this->format == 'xml') {
            $text = "<Message>\n";
            foreach($write as $key => $value) {
                $tag = strtoupper(substr($key, 0, 1)).substr($key, 1);
                $text .= "\t<".$tag.">$value</".$tag.">\n";
            }
            $text .= "</Message>\n";
        }
        else {
            $text = '['.$write['date'].']';
            $text .= ' ('.($write['class']?$write['class'].'::':'').$write['function'].'); '.$write['file'].':'.$write['line'];
            $text .= ' '.$write['type'].':';
            $text .= ' '.$write['content']."\n";
        }

        $fp = fopen($this->getFileName(), "a+");

        flock($fp, LOCK_EX);
        fwrite($fp, $text);
        fflush($fp);
        flock($fp, LOCK_UN);
    }
    public static function info(string $message): void
    {
        static::getInstance()->write($message);
    }
    public static function error(string $message): void
    {
        static::getInstance()->write($message, 'error');
    }
    public static function warn(string $message): void
    {
        static::getInstance()->write($message, 'warning');
    }

    public static function getLog(): string {
        return file_get_contents(static::getInstance()->getFileName());
    }
}
