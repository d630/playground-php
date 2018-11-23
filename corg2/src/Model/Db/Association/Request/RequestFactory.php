<?php

declare(strict_types=1);

namespace D630\Corg\Model\Db\Association\Request;

use D630\Corg\Request\RequestFactory as PRequestFactory;

class RequestFactory extends PRequestFactory implements RequestFactoryInterface
{
    public function createFetchRequest(string $ns)
    {
        $m = $ns . '\\FetchRequest';
        return new $m();
    }
}
