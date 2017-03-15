@extends('layouts.base')

@section('content')

<div class="container">
    <div class="ui-search-info jumbotron">
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
                        $('#ui-search-info').hide();
                        $('#ui-search-result').html($data['response']);
                    }
                }
                else if (xhr.status !== 200) {
                    //window.location = $fail_url;
                    console.log('Request failed.  Returned status of ' + xhr.status);
                }
            };
            
            xhr.send(JSON.stringify({
                
            }));
        }
        
        $(document).ready(function () {
            
            $success_url = $('#ui-ajax-request').attr('data-success-url');
            $fail_url    = $('#ui-ajax-request').attr('data-fail-url');
            $url         = $('#ui-ajax-request').attr('data-url');
            $csrf_token  = $('#ui-ajax-request').attr('data-csrf-token');
            
            runAjaxRequest($csrf_token, $url, $fail_url);
        });
        
    </script>
@append