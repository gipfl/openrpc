<?php

namespace gipfl\OpenRpc\Reflection;

class MethodCommentParser
{
    protected $paragraphs = [];
    protected $currentParagraph;

    /** @var MetaDataMethod */
    protected $meta;

    /** @var Tag|null */
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
        if (\preg_match('/^@param\s+([^\s]+)\s+\$([^\s]+)\s*(.*?)$/', $line, $match)) {
            $param = new MetaDataParameter($match[2], $match[1], $match[3]);
            $this->meta->addParameter($param);
            $this->currentParagraph = &$param->description;

            return;
        }
        if (\preg_match('/^@return\s+([^\s]+)$/', $line, $match)) {
            // Multiple ones? Is incorrect, but we do not want to fail here.
            // Last one wins:
            $this->meta->resultType = $match[1];

            return;
        }

        if (\substr($line, 0, 1) === '@') {
            // ignoring other tags
            return;
        }
        /*
        if ($this->meta->title === null) {
            $this->meta->title = $line;
            return;
        }
        */
        if ($this->currentParagraph === null && empty($this->paragraphs)) {
            $this->currentParagraph = & $this->paragraphs[];
        }

        if ($line === '') {
            if ($this->currentParagraph !== null) {
                $this->currentParagraph = & $this->paragraphs[];
            }
            return;
        }
        if ($this->currentParagraph === null) {
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
