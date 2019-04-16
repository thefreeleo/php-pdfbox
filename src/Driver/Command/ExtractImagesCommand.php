<?php
/*
 * This file is part of php-pdfbox.
 *
 * (c) Leo Lee <qeo@me.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pdfbox\Driver\Command;

use Pdfbox\Exception\InputFileMissingException;
use Pdfbox\Exception\InputFileNotFoundException;
use Pdfbox\Exception\OutputFileNotWritableException;

/**
 * pdfbox ExtractText command.
 */
class ExtractImagesCommand implements CommandInterface
{
    private $options;

    private $inputFile;

    private $outputFile;

    public function __construct()
    {
        $this->options = ['ExtractImages'];
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        if (!$this->inputFile) {
            throw new InputFileMissingException('Input file missing.');
        }

        $data = $this->options;
        array_push($data, $this->inputFile);

        if ($this->outputFile) {
            array_push($data, $this->outputFile);
        }

        return $data;
    }

    /**
     * Set <input-file>.
     * The PDF document to use.
     */
    public function inputFile(string $inputFile): self
    {
        if (!file_exists($inputFile)) {
            throw InputFileNotFoundException::create($inputFile);
        }

        $this->inputFile = $inputFile;

        return $this;
    }

    /**
     * Set <output-text-file>.
     * The file to write the text to.
     */
    public function outputFile(string $outputFile): self
    {
        if (!is_writable(dirname($outputFile))) {
            throw OutputFileNotWritableException::create($outputFile);
        }

        $this->outputFile = $outputFile;

        return $this;
    }

    /**
     * Set -password <password>.
     * Password to decrypt document.
     */
    public function password(string $password): self
    {
        return $this->setOption('-password', $password);
    }

    /**
     * Set -encoding <output encoding>.
     * UTF-8 (default) or ISO-8859-1, UTF-16BE, UTF-16LE, etc.
     */
    public function encoding(string $outputEncoding): self
    {
        return $this->setOption('-encoding', $outputEncoding);
    }
}
