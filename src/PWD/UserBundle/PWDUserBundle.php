<?php

namespace PWD\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class PWDUserBundle extends Bundle {

    public function getParent() {
        return 'FOSUserBundle';
    }

}
