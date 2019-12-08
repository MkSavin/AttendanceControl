<tr class="js-user-list-row">
    <td>{{ $id }}</td>
    <td>{{ $type }}</td>
    <td><a href="#" class="popup-toggle" popup-target=".user-data" popup-handler-after="popup-user-data-create" popup-data="{{ $id }}">{{ $name_short }}</a></td>
    <td>
        @if(isset($group))
        <a href="#" class="js-group popup-toggle" popup-target=".group-data" popup-handler-after="popup-group-data-create" popup-data="{{ $group['id'] }}">{{ $group['name'] }}</a>
        @endif
    </td>
</tr>