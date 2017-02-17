@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <form class="form-horizontal" name="product_form" id="product_form" action="{{ url('/products') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" id="record_id" name="record_id">
            <input type="hidden" id="table_index" name="table_index" value="">
                        <div class="form-group">
                            <label for="product_name" class="col-sm-2 control-label">Product</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_qty" class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-10">
                            <input type="number" class="form-control" id="product_qty" name="product_qty" placeholder="Quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_price" class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Price">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default" id="submit" name="submit">Submit</button>
                            </div>
                        </div>
               </form>
               
        </div>
    </div>
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th class="text-right">Quantity in stock</th>
                        <th class="text-right">Price per item</th>
                        <th class="text-right">Datetime submitted</th>
                        <th class="text-right">Total value number</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($data['data']) > 0)
                        @foreach($data['data'] as $k => $v) 
                        <tr id="t{{ $loop->index }}">
                            <td class="text-left prodname">{{ $v['prod_name']}}</td>
                            <td class="text-right prodqty">{{ $v['prod_qty']}}</td>
                            <td class="text-right prodprice">{{ $v['prod_price']}}</td>
                            <td class="text-right">{{ $v['added_on']}}</td>
                            <td class="text-right subtotal">{{ ($v['prod_price'] * $v['prod_qty']) }}</td>
                            <td class="text-right"><a href="{{ $k }}/{{ $loop->index }}" class="edit">Edit</a></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5">Total: <span class="total">{{ $data['total'] }}</span></td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
                    
                
            </table>          
        </div>
    </div>
 
</div>

@endsection
@push('scripts')
<script type="text/javascript">
    var config = {};
    config.SitePath = '{{ url('/') }}';
</script>
<script src="{{ url('/') }}/js/products.js"></script>

@endpush
                    