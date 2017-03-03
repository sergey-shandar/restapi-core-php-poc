<?php
namespace RestApiCore\Json;

final class SeqBuilder
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