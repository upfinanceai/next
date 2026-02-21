<?php

namespace Modules\Customer\Widgets;

use Modules\Core\Abstracts\Widget;
use Modules\Customer\Models\Customer;

class CustomerMetric extends Widget
{
    protected mixed $view = 'customer::widgets.customer_metric';

    public function getTotalCustomers()
    {
        return Customer::count();
    }
}
