<div class="card">
    <div class="card-header">
        <p>Count: {{ $count }}</p>
    </div>
    <div class="card-body">
        <div class="d-flex flex-wrap gap-3">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach(\Modules\Customer\Models\Customer::all() as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                            <button class="btn btn-danger" wire:click="deleteCustomer({{$customer->id}})">delete
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex flex-wrap gap-3">
            <div>
                <label for="" class="form-label">Name</label>
                <input type="text" class="form-control" wire:model="name">
            </div>
            <div>
                <label for="" class="form-label">Email</label>
                <input type="text" class="form-control" wire:model="email">
            </div>
            <div>
                <label for="" class="form-label">Password</label>
                <input type="password" class="form-control" wire:model="passsowrd">
            </div>
        </div>
        <button class="btn btn-primary mt-3" wire:click="createCustomer">Create customer</button>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" wire:click="increment">+1</button>
        <button class="btn btn-primary" wire:click="decrement">-1</button>
    </div>
</div>
