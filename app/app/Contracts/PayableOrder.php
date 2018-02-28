<?php

namespace App\Contracts;

/**
 * Interface PayableOrder
 *
 * @package App\Contracts
 */
interface PayableOrder
{
    const STATUS_CREATED = 0;
    const STATUS_PAID = 1;
    const STATUS_CANCELED = 2;
    const STATUS_ERROR = 3;

    /**
     * Get full order price
     *
     * @return float
     */
    public function getPrice(): float;

    /**
     * @return string
     */
    public function getUserName(): string;

    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @return string
     */
    public function getUserEmail(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param int $status
     */
    public function setPaymentStatusOrFail(int $status): void;
}