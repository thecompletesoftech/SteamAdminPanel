
<table id="all-data" class="table align-middle table-row-dashed fs-6 gy-5">
<!-- <div class="d-flex justify-content-end mb-4" style="float:left">
            <a class="btn btn-primary" href="{{ URL::to('#') }}">Export to PDF</a>
        </div> -->
<div class="mt-1 mb-4" style="float:right">
                        <div class="relative max-w-xs">
                            <form action="{{ route('admin.users.index') }}" method="GET">
                                <label for="search" class="sr-only" >
                                    Search
                                </label>
                                 <input type="search" name="search" id="search"
                                    class="block w-full p-3 pl-10 text-smpx border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400"
                                    placeholder="Search..." value="{{ request()->get('search') }}" />&nbsp;<i class="fa fa-search" style="font-size:20px;"></i>

                            </form>

                        </div>

                    </div>

<tr>
    <th>Sr No.</th>
    <th>Name</th>
    <th>EMAIL</th>
    <th>ROLE</th>
    <th>STATUS</th>
    <th>EDIT</th>
    <th>ACTION</th>
  </tr>
  @foreach($users as $user)
  <tr>
    <td>{{$user->id}}</td>
    <td>
    <!-- <a href="{{ url('/') }}/admin/users/{{$user->id}}/" title="profile"  style="color:blue"> -->


    {{$user->name}} {{$user->l_name}}
    <!-- </a> -->
  </td>

    <td>{{$user->email}}</td>
    <td>{{$user->role}}</td>


    <td>
      <a href="#" data-id="` + id + `" title="Status" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

    <span class="svg-icon svg-icon-3">
          <?php if($user->status==0){ ?>
            <i class='fa fa-user' style="color:blue"></i>
         <?php  }else{ ?>
          <i class='fa fa-user-slash' style="color:red"></i>
         <?php  } ?>

      </span>
                </a>
         </td>
  <td>
  <a href="{{ url('/') }}/admin/users/edit/{{$user->id}}" title="Edit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <span class="svg-icon svg-icon-3" >
                    <i class="fa fa-pen"></i>
                </span>
            </a>
  </td>
  <td>
  <a href="{{ url('/') }}/admin/users/destroy/{{$user->id}}" title="Delete" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" >
                <span class="svg-icon svg-icon-3" >
                    <i class="fa fa-trash"></i>
                </span>
            </a>
  </td>

  </tr>
  @endforeach
</table>
<div class="row">
<div class="col-lg-12">
  {{ $users->links() }}
         </div>
</div>

