<?php
namespace RestApiCore\Json;

/**
 * Class FromSeq.
 *
 * Build a JSON string from a sequence.
 *
 * @package RestApiCore\Json
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