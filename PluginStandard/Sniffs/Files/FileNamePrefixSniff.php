<?php

namespace PluginStandard\Sniffs\Files;

use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Files\File;

class FileNamePrefixSniff implements Sniff
{
    public function register()
    {
        return [T_OPEN_TAG];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $fileName = basename($phpcsFile->getFileName(), '.php');
        $className = $phpcsFile->getDeclarationName($stackPtr);
        $classNameContent = $phpcsFile->getTokens()[$className]['content'];

        if (strpos($fileName, 'class.' . $classNameContent) !== 0) {
            $error = 'File name "%s" must start with "class.%s"';
            $data = [$fileName, $classNameContent];
            $phpcsFile->addError($error, $stackPtr, 'FileNamePrefix', $data);
        }
    }
}
