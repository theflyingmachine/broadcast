<script>
    $(document).ready(function(){
   var table = $('#example').DataTable({
      'ajax': 'https://api.myjson.com/bins/1us28',
      'columnDefs': [
         {
            'targets': 0,
            'render': function(data, type, row, meta){
               if(type === 'display'){
                  data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
               }

               return data;
            },
            'checkboxes': {
               'selectRow': true,
               'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
            }
         }
      ],
      'select': 'multi',
      'order': [[1, 'asc']]
   });
});
</script>

<div class="container-fluid">
        @if(count($allmembers) > 0)
          
    <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
       <thead>
          <tr>
             <th></th>        
             <th>Name</th>
             <th>Gender</th>
             <th>Email</th>
             <th>Mobile</th>
            </tr>
       </thead>
       @foreach($allmembers as $members)
                <tr>
                <td></td>
                <td>{{$members->name}}</td>
                <td>{{$members->gender}}</td>
                <td>{{$members->email}}</td>
                <td>{{$members->mobile}}</td>
                </tr>
    
        @endforeach
       <tfoot>
          <tr>
             <th></th>      
             <th>Name</th>
             <th>Gender</th>
             <th>Email</th>
             <th>Mobile</th>
            </tr>
       </tfoot>
    </table>
    @else
    <p>Its Empty here, Add some menbers to start broadcast...</p>
@endif
    </div>