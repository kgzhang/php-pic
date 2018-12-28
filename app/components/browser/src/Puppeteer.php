<?php

namespace App\compo\browser\src;


use Spatie\Browsershot\Exceptions\ElementNotFound;
use Symfony\Component\Process\Process;

class Puppeteer
{
    protected $nodeBinary = null;
    protected $npmBinary = null;
    protected $nodeModulePath = null;
    protected $includePath = '$PATH:/usr/local/bin';
    protected $binPath = null;

    public function setNodeBinary(string $nodeBinary)
    {
        $this->nodeBinary = $nodeBinary;

        return $this;
    }

    public function setNpmBinary(string $npmBinary)
    {
        $this->npmBinary = $npmBinary;

        return $this;
    }

    public function setIncludePath(string $includePath)
    {
        $this->includePath = $includePath;

        return $this;
    }

    public function setBinPath(string $binPath)
    {
        $this->binPath = $binPath;

        return $this;
    }

    public function setNodeModulePath(string $nodeModulePath)
    {
        $this->nodeModulePath = $nodeModulePath;

        return $this;
    }

    protected function callBrowser(array $command)
    {
        $fullCommand = $this->getFullCommand($command);

        $process = (new Process($fullCommand))->setTimeout($this->timeout);
        $process->run();

        if ($process->isSuccessful()) {
            return rtrim($process->getOutput());
        }

        $process->clearOutput();
        if ($process->getExitCode() === 2) {
            throw new ElementNotFound($this->additionalOptions['selector']);
        }

        throw new ProcessFailedException($process);
    }

    protected function getFullCommand(array $command)
    {
        $nodeBinary = $this->nodeBinary ?: 'node';

        $binPath = $this->binPath ?: __DIR__.'/../bin/browser.js';

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $fullCommand =
                $nodeBinary.' '
                .escapeshellarg($binPath).' '
                .'"'.str_replace('"', '\"', (json_encode($command))).'"';

            return escapeshellcmd($fullCommand);
        }

        $setIncludePathCommand = "PATH={$this->includePath}";

        $setNodePathCommand = $this->getNodePathCommand($nodeBinary);

        return
            $setIncludePathCommand.' '
            .$setNodePathCommand.' '
            .$nodeBinary.' '
            .escapeshellarg($binPath).' '
            .escapeshellarg(json_encode($command));
    }

    protected function getNodePathCommand(string $nodeBinary): string
    {
        if ($this->nodeModulePath) {
            return "NODE_PATH='{$this->nodeModulePath}'";
        }
        if ($this->npmBinary) {
            return "NODE_PATH=`{$nodeBinary} {$this->npmBinary} root -g`";
        }

        return 'NODE_PATH=`npm root -g`';
    }
}
