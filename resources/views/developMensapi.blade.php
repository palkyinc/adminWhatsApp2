<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
                        border: 1px solid black;
                        border-radius: 10px;
                        }
    </style>
</head>
<body>
    <form method="GET" action="/conversations">
        <select name="phone_number">
                @if (empty($phone_clients))
                    <option value="">Sin Conversaciones</option>
                @else
                    @foreach ($phone_clients as $phone)
                        <option value={{$phone}}>{{$phone}}</option>
                    @endforeach
                @endif
        </select>
        <button value="submit">ver</button> 
    </form>

    @if (!empty($conversation))
        <table>
            <tr>
                <th>M_type</th>
                <th>Origin</th>
                <th>M_Text_body</th>
                <th>Status</th>
                <th>Reaction</th>
            </tr>
            @foreach ($conversation as $item)
                @if ($item->messages_type === "text")
                    <tr>
                        <td>{{$item->messages_type}}</td>
                        @if ($item->messages_from === "local")
                            <td>Tú</td>
                            <td>{{$item->send_text_body}}</td>
                        @else
                            <td>{{$item->profile_name}}</td>
                            <td>{{$item->messages_text_body}}</td>
                        @endif
                        <td>{{$item->statuses_status ?? "Not Informed."}}</td>
                        <td>{{$item->reaction_emoji}}</td>
                    </tr>
                    @if ($item->statuses_status !== "read")
                        @php
                            $item->markAsRead();
                        @endphp
                    @endif
                @endif
            @endforeach
        </table>    
        
        <form action="/sendTextMessage" method="POST">
            @csrf
            <input type="text" name="body">
            <input type="hidden" name="to" value={{$phone_number}}>
            <input type="hidden" name="develop_view" value=1>
            <button value="submit">Enviar</button>
        </form>
    
    @endif

</body>
</html>