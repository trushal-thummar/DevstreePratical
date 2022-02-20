@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">Products</div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-12 text-right">
              <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>&nbsp;&nbsp;Add Product</a>
            </div>
          </div>
          <div class="clearfix"></div>
          <br />
          <div class="table-responsive">
            <table class="table" id="productListTable">
              <thead>
                <tr>
                  <th scope="col">Product Name</th>
                  <th scope="col">Logo</th>
                  <th scope="col">Price</th>
                  <th scope="col">Buy Minimum Quantity</th>
                  <th scope="col">Buy Maximum Quantity</th>
                  <th scope="col">Description</th>
                  <th scope="col">Status</th>
                  <th scope="col" class="w-160">Action</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready( function () {
    $("#productListTable").DataTable().destroy()
      var table = $('#productListTable').DataTable({  
      "processing": true,
      "serverSide": true,  
      "ordering":false,
      "searching":false, 
      "paging":true,  
      "pageLength": 50,    
      "order": [],
      "columnDefs": [
        { "orderable": false, "targets": [] }
      ],
      'orderCellsTop': true,
      'fixedHeader': true,
      "ajax": {
        'url': "{{ url('home') }}",
        'type': 'POST',                  
        'data' : {
          "_token" : '{{ csrf_token() }}'
        }
      },
      "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                
      },
      initComplete: function() {
        $('.dataTables_filter input').unbind();
        $('.dataTables_filter input').bind('keyup', function(e) {
          if(e.keyCode == 13) {
            //table.fnFilter(this.value);
            table.search(this.value).draw();
          }
        });                    
      },
      columns: [
        {data: 'product_name'},
        {data: 'logo'},
        {data: 'price'},
        {data: 'buy_min_quantity'},
        {data: 'buy_max_quantity'},
        {data: 'description'},  
        {data: 'status'},  
        {data: 'action'}  
      ],
      'createdRow': function(row, data, dataIndex){                 
        // 
      }              
    });
  });
</script>
@endsection