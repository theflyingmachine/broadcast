@extends('layouts.app')


@section('content')
<h1>Report for broadcast_id </h1>
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
            @if(count($broadcast_subject) > 0)
              
        <table id="example" class="table table-bordered table-striped" cellspacing="0" width="100%">
           <thead>
              <tr>
                 <th></th>        
                 <th>Name</th>
                 <th>Gender</th>
                 <th>Email</th>
                 <th>Response</th>
                 <th>Status</th>
                 <th>Last Updated</th>
                </tr>
           </thead>
           @foreach($broadcast_subject as $members)
                    <tr>
                    <td></td>
                    <td>{{$members->name}}</td>
                    <td>{{$members->gender}}</td>
                    <td>{{$members->email_to}}</td>
                    <td>{{$members->message}}</td>
                    <td>{{$members->status}}</td>
                    <td>{{$members->updated_at}}</td>
                    </tr>
        
            @endforeach
           <tfoot>
              <tr>
                 <th></th>      
                 <th>Name</th>
                 <th>Gender</th>
                 <th>Email</th>
                 <th>Response</th>
                 <th>Status</th>
                 <th>Last Updated</th>
                </tr>
           </tfoot>
        </table>
        @else
        <p>Its Empty here, Add some menbers to start broadcast...</p>
    @endif
        </div>

@endsection