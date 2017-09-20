    @if($message = session('messages'))
      <script type="text/javascript">
              new PNotify({
              title: '<h4>{{$message['title']}}</h4>',
              text: '<p class="lead">{{$message['message']}}</p>',
              type: '{{$message['type']}}', 
              icon: '{{$message['icon']}}',
              styling: 'fontawesome'
          });                                           
    </script>
    @endif