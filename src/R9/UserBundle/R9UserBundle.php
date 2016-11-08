<?php

namespace R9\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class R9UserBundle extends Bundle
{
    public function getParent()

  {

    return 'FOSUserBundle';

  }
}
