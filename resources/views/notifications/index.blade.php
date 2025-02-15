@if(auth()->user())
    <div>
        <h4>Notifications</h4>
        <ul>
            @foreach(auth()->user()->notifications as $notification)
                <li>
                    {{ $notification->data['message'] }}
                    @if($notification->data['type'] === 'user_created')
                        <br> Email: {{ $notification->data['email'] }}
                        <br> Password: {{ $notification->data['password'] }}
                    @elseif($notification->data['type'] === 'role_changed')
                        <br> New Role: {{ $notification->data['extra_data']['new_role'] }}
                    @elseif($notification->data['type'] === 'department_lead_assigned')
                        <br> Assigned to Department: {{ $notification->data['extra_data']['department_name'] }}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif