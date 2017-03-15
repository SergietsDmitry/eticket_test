@extends('layouts.base')

@section('content')

<div class="container">
    @include('flash::message')
    <div class="row">
        <h1>{{$title}}</h1>
        <br>
        <br>
        
        {!! BootForm::open()
            ->post()
            ->action(route('get.search.id'))
            ->attribute('class', 'smart-form')
            ->attribute('id', 'ui-form-search')
        !!}
        
            {!! BootForm::date(
                'Departure datetime', 'departure_datetime', $data->departure_datetime ?? date('YY-mm-dd')
            )
            ->attribute('required', true)
            ->addClass('ui-date')
            !!}

            {!! BootForm::text(
                'Original location', 'original_location', $data->original_location ?? 'KGD'
            )
            ->attribute('required', true)
            ->attribute('minlength', 3)
            ->attribute('maxlength', 3)
            !!}
            
            {!! BootForm::text(
                'Destination location', 'destination_location', $data->destination_location ?? 'MOW'
            )
            ->attribute('required', true)
            ->attribute('minlength', 3)
            ->attribute('maxlength', 3)
            !!}
                
            {!! BootForm::text(
                'Passangers quantity', 'passangers_quantity', $data->passangers_quantity ?? 1
            )
            ->attribute('type', 'number')
            ->attribute('required', true)
            ->attribute('min', 1)
            !!}

            {{ Form::submit( 'Search', array(
                'id'    => 'ui-add-block-btn',
                'class' => 'btn btn-success'
            ) ) }}

        {!! BootForm::close() !!}
    </div>
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $alerts = document.querySelectorAll('div.alert:not(.alert-important)');
        $alerts.forEach(function($alert) {
            delay_hide($alert, 3000);
        });
        
        async function delay_hide($object, $ms)
        {
            await sleep($ms);
            $object.style.display = 'none';
        }
        
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        
        $(function() {
            $( ".ui-date" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@append