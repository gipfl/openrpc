<?php

namespace gipfl\OpenRpc\Reflection;

class MethodCommentParser
{
    protected $paragraphs = [];
    protected $currentParagraph;

    /** @var MetaDataMethod */
    protected $meta;

    /** @var MetaDataTagParser|null */
    protected $currentTag;

    protected function __construct(MetaDataMethod $meta)
    {
        $this->meta = $meta;
    }

    public function getTitle()
    {
        return $this->meta->title;
    }

    public function getParams()
    {
        return $this->meta->parameters;
    }

    public function getResultType()
    {
        return $this->meta->resultType;
    }

    public function getDescription()
    {
        return \implode("\n", $this->paragraphs);
    }

    protected function parseLine($line)
    {
        // Strip * at line start
        $line = \preg_replace('~^\s*\*\s?~', '', $line);
        $line = \trim($line);
        if (\preg_match('/^@([A-z0-9]+)\s+([^\s]+)$/', $line, $match)) {
            $this->currentTag = new MetaDataTagParser($match[1], $match[2]);
            return;
        }

        if ($this->currentTag) {
            $this->currentTag->appendValueString($line);
            return;
        }

        $this->appendToParagraph($line);
    }

    protected function appendToParagraph($line)
    {
        if (trim($line) === '') {
            if ($this->currentParagraph !== null) {
                unset($this->currentParagraph);
                $this->currentParagraph = null;
            }
            return;
        }

        if ($this->currentParagraph === null) {
            $this->currentParagraph = & $this->paragraphs[];
            $this->currentParagraph = $line;
        } else {
            if (\substr($line, 0, 2) === '  ') {
                $this->currentParagraph .= "\n" . $line;
            } else {
                $this->currentParagraph .= ' ' . $line;
            }
        }
    }

    public static function parseMethod(MetaDataMethod $meta, $raw)
    {
        $self = new static($meta);
        $plain = $raw;
        static::stripStartOfComment($plain);
        static::stripEndOfComment($plain);
        foreach (\preg_split('~\n~', $plain) as $line) {
            $self->parseLine($line);
        }

        return $self;
    }

    /**
     * Removes comment start -> /**
     *
     * @param $string
     */
    protected static function stripStartOfComment(&$string)
    {
        $string = \preg_replace('~^\s*/\*\*\n~s', '', $string);
    }

    /**
     * Removes comment end ->  * /
     *
     * @param $string
     */
    protected static function stripEndOfComment(&$string)
    {
        $string = \preg_replace('~\n\s*\*/\s*~s', "\n", $string);
    }
}
