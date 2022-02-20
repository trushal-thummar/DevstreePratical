@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5><strong>{{ $mode == 'add' ? 'Add' : 'Edit' }} Product</strong></h5>
        </div>
        <div class="card-body">
          <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
          </div>

          <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            
            <div class="form-group row">
              <label for="product_name" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Product Name') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <input id="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" name="product_name" value="{{ ($mode == 'add' ? old('product_name') : $product->product_name) }}" autocomplete="product_name" required autofocus>
                @error('product_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="logo" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Logo') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" autocomplete="logo" accept="image/*">
                @if(!empty($product->logo))
                  <a href="{{ asset('uploads/products/'.$product->logo) }}" target="_blank">View Current Logo</a>
                @endif

                @error('logo')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="price" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Price') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" autocomplete="price" step="any" min="0.1" onkeypress="isFloat(event)" value="{{ ($mode == 'add' ? old('price') : $product->price) }}" required>
                @error('price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="buy_min_quantity" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Buy Min Quantity') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <input id="buy_min_quantity" type="number" class="form-control @error('buy_min_quantity') is-invalid @enderror" name="buy_min_quantity" min="1" autocomplete="buy_min_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ ($mode == 'add' ? old('buy_min_quantity') : $product->buy_min_quantity) }}" required>
                @error('buy_min_quantity')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="buy_max_quantity" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Buy Max Quantity') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <input id="buy_max_quantity" type="number" class="form-control @error('buy_max_quantity') is-invalid @enderror" name="buy_max_quantity" min="1" autocomplete="buy_max_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ ($mode == 'add' ? old('buy_max_quantity') : $product->buy_max_quantity) }}" required>
                @error('buy_max_quantity')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Description') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <textarea class="form-control @error('description') is-invalid @enderror" name="description" required>{{ ($mode == 'add' ? old('description') : $product->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row">
              <label for="description" class="col-md-4 col-form-label text-md-right"><strong>{{ __('Status') }}</strong><span class="required clr-red">*</span></label>
              <div class="col-md-6">
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                  <option value="1" {{ ($mode == 'add' ? '' : ($product->is_status == 1 ? 'selected' : '')) }}>Active</option>
                  <option value="0" {{ ($mode == 'add' ? '' : ($product->is_status == 0 ? 'selected' : '')) }}>Inactive</option>
                </select>

                @error('description')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="clearfix"></div>
            <br />

            <div class="form-group row mb-0">
              <div class="col-md-10 text-right">
                <button type="submit" class="btn btn-primary">
                {{ $mode == 'add' ? 'Add' : 'Edit' }} Product
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<!-- Jquery Validator CDN -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
  function isFloat(event){
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
    }
  }
  
  $("#productForm").validate({
    rules: {
      product_name: "required",
      price: {
        required: true,
        number: true
      },
      buy_min_quantity: {
        required: true,
        digits: true
      },
      buy_max_quantity: {
        required: true,
        digits: true
      },
      description: "required",
      status: "required",
      @if($mode == 'add')
        logo: "required"
      @endif
    },
    messages: {
      product_name: "Product name field is required",
      price: {
        required: "Price field is required",
        number: "Price cannot contain alphabetic characters"
      },
      buy_min_quantity: {
        required: "Buy Minimum Quantity field is required",
        digits: "Buy Minimum Quantity cannot contain alphabetic characters"
      },
      buy_max_quantity: {
        required: "Buy Maximum Quantity field is required",
        digits: "Buy Maximum Quantity cannot contain alphabetic characters"
      },
      description: "Description is required",
      status: "Status is required",
      @if($mode == 'add')
        logo: "Logo field is required"
      @endif
    },
    submitHandler: function(form){
      $(".print-error-msg").find("ul").html('');
      
      var data = new FormData();

      //Form data
      var form_data = $('#productForm').serializeArray();
      $.each(form_data, function (key, input) {
          data.append(input.name, input.value);
      });

      //File data
      var file_data = $('input[name="logo"]').prop('files')[0];
      data.append("logo", file_data);

      @if($mode == 'edit')
        data.append("_method", 'PUT');
      @endif

      $.ajax({
        url: "{{ ($mode == 'add' ? route('products.store') : route('products.update', ['product' => $product->uuid])) }}",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        processData: false,
        contentType: false,
        data: data,
        success: function (data) {
          if(data.status != undefined){
            if(data.status == 'success'){
              alert(data.message);

              setTimeout(function() {
                window.location.href = '/home';
              }, 1000);
            }
            else{
              alert(data.message);
            }
          }else{
            printErrorMsg(data.error);
          }
        },
        error: function (e) {
            //error
        }
      });
    }
  });

  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
  }
</script>
@endsection