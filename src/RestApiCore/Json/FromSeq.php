<?php
namespace RestApiCore\Json;

/**
 * Build a JSON string from a sequence.
 */
final class FromSeq
{
    /**
     * @var string
     */
    private $result = '';

    /**
     * @param string $item
     */
    public function append($item) {
        $this->result .= ($this->result === '' ? '' : ',') . $item;
    }

    /**
     * @return string
     */
    public function get() {
        return $this->result;
    }
}