<?php

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Calendar\Model\LeapYear;

class LeapYearController
{
    public function indexAction(Request $request, $year)
    {
        $leap_year = new LeapYear();
        if ($leap_year->isLeapYear($year)) {
            return new Response('Да, это високосный год!');
        }

        return new Response('Нет, это не високосный год.');
    }
}