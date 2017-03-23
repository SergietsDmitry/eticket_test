@extends('layouts.base')

@section('content')

<div class="container">
    <div id="ui-search-info" class="jumbotron">
        <p>
        Поиск авиабилетов
        <i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
        <span class="sr-only">Loading...</span>
        </p>
    </div>
    
    <div id='ui-search-result'>
        
    </div>
</div>

<div id="ui-ajax-request" data-csrf-token='{{ csrf_token() }}' data-fail-url="{{route('index')}}" data-url="{{route('get.search.result', ['request_id' => $request_id])}}"></div>

@endsection

@section('javascript')
    <script type="text/javascript">
        
        function runAjaxRequest($csrf_token, $url, $fail_url) {
            
            xhr = new XMLHttpRequest();

            xhr.open('POST', $url);
            
            xhr.setRequestHeader('X-CSRF-TOKEN', $csrf_token);
            
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    
                    var $data = JSON.parse(xhr.responseText);
                    
                    if ($data['status'] == 'error')
                    {
                        window.location = $fail_url;
                    }
                    else
                    {
                        document.getElementById('ui-search-info').style.display = 'none';
                        document.getElementById('ui-search-result').innerHTML = $data['response'];
                    }
                }
                else if (xhr.status !== 200) {
                    window.location = $fail_url;
                    //console.log('Request failed.  Returned status of ' + xhr.status);
                }
            };
            
            xhr.send(JSON.stringify({
                
            }));
        }
        
        $(document).ready(function () {
            
            $success_url = document.getElementById('ui-ajax-request').getAttribute('data-success-url');
            $fail_url    = document.getElementById('ui-ajax-request').getAttribute('data-fail-url');
            $url         = document.getElementById('ui-ajax-request').getAttribute('data-url');
            $csrf_token  = document.getElementById('ui-ajax-request').getAttribute('data-csrf-token');
            
            runAjaxRequest($csrf_token, $url, $fail_url);
        });
        
    </script>
@append