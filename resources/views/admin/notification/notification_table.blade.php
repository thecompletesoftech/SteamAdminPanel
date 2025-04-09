<table class="table align-middle table-row-dashed fs-6 gy-5">
  <tr>
    <th>ID</th>
    <th>NOTIFICATION</th>

    <th>MESSAGE</th>
    
    <th>ACTION</th>
  </tr>
  <?php
         
         $id=1;
        
       ?>
  @foreach($notifications as $user)
  <tr>
  <td><?php echo $id; ?></td>
    <td>
            
    {{$user->notification}}
  
  </td>

    <td>
    {{$user->message}}
    </td>
   
    

  <td>
  <a href="{{ url('/') }}/admin/notifications/{{$user->id}}/edit" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <span class="svg-icon svg-icon-3" >
                    <i class="fa fa-pen"></i>
                </span>
            </a>
  <a onclick="return confirm('Are you sure you want to delete ?')" href="{{ url('/') }}/admin/notifications/destroy/{{$user->id}}/" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <span class="svg-icon svg-icon-3" >
                    <i class="fa fa-trash"></i>
                </span>
            </a>
  </td>
   
  </tr>
  <?php $id++;?>
  @endforeach
</table>
<div class="row">
<div class="col-lg-12">
  {{ $notifications->links() }}
         </div>
</div>