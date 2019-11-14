<?php
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 14.11.19
 * Time: 17:28
 */

namespace DB;


class RangeCriteria
{
    /**
     * @var \DateTimeInterface
     */
    private $from;
    /**
     * @var \DateTimeInterface
     */
    private $to;


    /**
     * RangeCriteria constructor.
     * @param \DateTimeInterface|null $from
     * @param \DateTimeInterface|null $to
     */
    public function __construct(\DateTimeInterface $from = null, \DateTimeInterface $to = null)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getTo()
    {
        return $this->to;
    }


}