<?php

namespace app\reports;

interface ReportInterface
{
    public function setParam(string $name, mixed $value): ReportInterface;
    public function run(): array;

}
