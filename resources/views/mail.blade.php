<h2>Xin chào {{ $data['name'] }}</h2> 
<br>
    
<strong>------------Nội dung ------------ </strong><br>
{{ $data['message'] }} <br>

<strong>Name: </strong>{{ $data['name'] }} <br>
<strong>Subject: </strong>{{ $data['subject'] }} <br>

@foreach($data['data'] as $key => $value)
    <strong>{{$key}}: </strong>{{ $value }} <br>
@endforeach

  
Thank you