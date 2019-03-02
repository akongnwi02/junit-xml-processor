<?php
/**
 * Created by PhpStorm.
 * User: devert
 * Date: 2/17/19
 * Time: 6:57 PM
 */

namespace Devert\Model;


class Test
{
    private $category;
    private $subCategory;
    private $suite;
    private $signature;
    private $case;
    private $status;
    private $time;
    private $assertions;

    /**
     * @return mixed
     */
    public function getAssertions()
    {
        return $this->assertions;
    }

    /**
     * @param mixed $assertions
     */
    public function setAssertions($assertions)
    {
        $this->assertions = $assertions;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return Test
     */
    public function setTime($time): Test
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param mixed $case
     */
    public function setCase($case)
    {
        $this->case = $case;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getSuite()
    {
        return $this->suite;
    }

    /**
     * @param mixed $suite
     */
    public function setSuite($suite)
    {
        $this->suite = $suite;
    }

    /**
     * @return mixed
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @param mixed $subCategory
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

}