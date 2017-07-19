<?php

namespace Prettus\Repository\Contracts;

interface TestResourceableInterface
{
    public function test_index();

    public function test_create();

    public function test_show();

    public function test_update();

    public function test_delete();
}