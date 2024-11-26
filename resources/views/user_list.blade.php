<h2>Users List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Description</th>
                <th>Profile Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->phone}}</td>
                <td>{{ $user->role->name}}</td>
                <td>{{ $user->description}}</td>
                <td><img src="{{  asset('storage/') }}/{{ $user->profile_image }}" width="50"></td>
            </tr>
            @endforeach
        </tbody>
    </table>