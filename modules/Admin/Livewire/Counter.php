<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Modules\Customer\Actions\CreateCustomer;
use Modules\Customer\Data\CustomerData;
use Modules\Customer\Models\Customer;

class Counter extends Component
{
    public int $count = 0;

    public string $email = '';
    public string $name = '';
    public string $password = '';

    public function createCustomer()
    {
        CreateCustomer::run(CustomerData::from([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]));
        $this->reset();
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
    }

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        if ($this->count > 0) {
            $this->count--;
        }
    }

    public function render()
    {
        return view('admin::livewire.counter');
    }
}
