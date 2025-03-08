<table class="table table-bordered table-striped" >
    <thead>
        <tr>
            <th width="10%">Sl</th>
            <th width="25%">Name</th>
            <th width="25%">Email</th>
            <th width="20%">Phone</th>
            <th>Type</th>
            
        </tr>
    </thead>
    <tbody id="list_view">
        <?php
            $sl = 1;
            $user_type = user_type();
            $users = App\Models\User::get();
        ?>
        @foreach($users as $user)
            <tr id="tr_{{$sl}}" onclick="load_php_data_to_form('{{$user->id}}')" style="cursor:pointer" >
                <td>{{$sl++}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>{{$user_type[$user->type] ?? ''}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    setFilterGrid("list_view",-1);
</script>