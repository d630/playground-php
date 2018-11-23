<?php

declare(strict_types=1);

namespace D630\Corg\Controller\Customer\Response;

use D630\Corg\Config;
use D630\Corg\Entity\Customer;
use D630\Corg\Export\ExporterFactory;
use D630\Corg\Response\Response as PResponse;

class VcardResponse extends PResponse implements VcardResponseInterface
{
    private const HEADER_ALLOW = 'Allow: GET';

    public function __construct(array $models, array $settings, array $options)
    {
        parent::__construct(__NAMESPACE__, $models, $settings, $options);
    }

    public function connect(): void
    {
        header(self::HEADER_ALLOW);
        parent::connect();
    }

    public function delete(): void
    {
        header(self::HEADER_ALLOW);
        parent::delete();
    }

    public function get(): void
    {
        $this->options['customer_id'] = $this->options['customer_id'] ?? 0;
        if ($this->options['customer_id'] < 1) {
            throw new \Exception('invalid id', 400);
        }

        $customer = Customer::get($this->options['customer_id'], $this->modelCustomer);
        if (!$customer[0]) {
            throw new \Exception('no ids found', 404);
        }

        $exporter = (new ExporterFactory())->createVcardExporter();
        $exporter->convert($customer[0]);

        $func = $this->configResponse['status'][200];
        $func();

        header('Expires: ' . Config::UNIX_TIME);
        header('Content-Type: text/vcard; charset=UTF-8');

        $exporter->output();
    }

    public function head(): void
    {
        header(self::HEADER_ALLOW);
        parent::head();
    }

    public function options(): void
    {
        header(self::HEADER_ALLOW);
        parent::options();
    }

    public function post(): void
    {
        header(self::HEADER_ALLOW);
        parent::post();
    }

    public function put(): void
    {
        header(self::HEADER_ALLOW);
        parent::put();
    }

    public function trace(): void
    {
        header(self::HEADER_ALLOW);
        parent::trace();
    }
}
