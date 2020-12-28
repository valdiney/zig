<?php

namespace System\Model;

use System\Database\Native;
use System\NativeQuery\NativeQuery;

class Model extends NativeQuery
{
    public function __construct()
    {
        parent::__construct(Native::connect());
    }
}
