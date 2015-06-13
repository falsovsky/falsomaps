<?php

namespace Maps\Validator\File;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class IsGpx extends AbstractValidator
{
    const FALSE_TYPE   = 'fileGpxFalseType';
    const NOT_READABLE = 'fileGpxNotReadable';

    protected $messageTemplates = array(
        self::FALSE_TYPE   => "Not a valid GPX file",
        self::NOT_READABLE => "File is not readable or does not exist",
    );

    public function isValid($value, $file = null)
    {
        if (is_array($value)) {
            if (!isset($value['tmp_name']) || !isset($value['name']) || !isset($value['type'])) {
                throw new Exception\InvalidArgumentException(
                    'Value array must be in $_FILES format'
                );
            }
            $file     = $value['tmp_name'];
            $filename = $value['name'];
            $filetype = $value['type'];
        } else {
            $file     = $value;
            $filename = basename($file);
            $filetype = null;
        }
        $this->setValue($filename);

        // Is file readable ?
        if (empty($file) || false === stream_resolve_include_path($file)) {
            $this->error(static::NOT_READABLE);
            return false;
        }

        libxml_use_internal_errors(true);
        $xml = new \DOMDocument();
        $xml->load($file);

        // GPX 1.0?
        if ($xml->schemaValidate('./data/schema/gpx10.xsd')) {
          return true;
        }

        // GPX 1.1?
        if ($xml->schemaValidate('./data/schema/gpx11.xsd')) {
          return true;
        }

        $this->error(static::FALSE_TYPE);
        return false;
    }
}
