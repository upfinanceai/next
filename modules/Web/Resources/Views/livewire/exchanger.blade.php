<div>
    <div  class="d-flex flex-column align-items-center">
        <div>
            <label for="">From</label>
            <div class="input-group mb-3">
                <select class="form-select" name="from_currency" wire:model="from_currency" wire:change="onChange('from')">
                    <option selected>-</option>
                    @foreach($currency_from as $_currency)
                        <option value="{{$_currency->code}}">{{$_currency->code}}</option>
                    @endforeach
                </select>
                <input class="form-control" wire:change="onChange('from')" type="text" name="from_amount" placeholder="卖出数量"
                       wire:model="from_amount">
            </div>
        </div>
        <div>
            <button wire:click="switchCurrency" class="btn btn-outline">⬇️</button>
        </div>
        <div>
            <label for="">To</label>
            <div class="input-group mb-3">
                <select class="form-select" name="to_currency" wire:model="to_currency"  wire:change="onChange('to')">
                    <option selected>-</option>
                    @foreach($currency_to as $_currency)
                        <option value="{{$_currency->code}}">{{$_currency->code}}</option>
                    @endforeach
                </select>
                <input class="form-control" wire:change="onChange('to')" type="text" name="to_amount" placeholder="买入数量" wire:model="to_amount">
            </div>
            <button class="btn btn-primary" type="submit">提交</button>
        </div>
    </div>
</div>
