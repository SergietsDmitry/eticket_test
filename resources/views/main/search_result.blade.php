@if(isset($data->FareDisplayInfos) && (count($data->FareDisplayInfos) > 0))
    <table class="table">
        <tbody>
            <tr>
                <th>Рейс</th>
                <th>Вылет -> Прилет</th>
                <th>В пути</th>
                <th>Стоимость</th>
            </tr>
            @foreach ($data->FareDisplayInfos as $index => $fare)
                <tr>
                    <td>
                        @if(isset($fare->Segments->Legs->OperatingAirlineCode))
                            @if (isset($fare->Segments->Legs->ValidatingAirlineURL))
                                <img src="{{$fare->Segments->Legs->ValidatingAirlineURL}}" />
                            @endif
                            @if (isset($fare->Segments->Legs->OperatingAirlineCode)) {{$fare->Segments->Legs->OperatingAirlineCode}} @endif
                            @if (isset($fare->Segments->Legs->FlightNumber)) {{$fare->Segments->Legs->FlightNumber}} @endif
                        @else
                            @foreach ($fare->Segments->Legs as $index => $legs)
                                @if ($index == 1)
                                    @if (isset($legs->ValidatingAirlineURL))
                                        <img src="{{$legs->ValidatingAirlineURL}}" />
                                    @endif
                                    
                                    @if (isset($legs->OperatingAirlineCode)) {{$legs->OperatingAirlineCode}} @endif
                                    @if (isset($legs->FlightNumber)) {{$legs->FlightNumber}} @endif
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($fare->Segments->Legs->OperatingAirlineCode))
                            @if (isset($fare->Segments->Legs->DepartureDate))
                                {{$fare->Segments->Legs->DepartureDate}}
                            @endif
                            @if (isset($fare->Segments->Legs->DepartureTime))
                                {{$fare->Segments->Legs->DepartureTime}}
                            @endif
                            @if (isset($fare->Segments->Legs->DepartureCityCode) && (isset(\Cities::getCityByCode($fare->Segments->Legs->ArrivalCityCode)['name'])))
                                {{\Cities::getCityByCode($fare->Segments->Legs->DepartureCityCode)['name']}}
                            @endif
                            (
                            @if (isset($fare->Segments->Legs->DepartureAirportCode))
                                {{$fare->Segments->Legs->DepartureAirportCode}}
                            @endif
                            )
                            ->
                            @if (isset($fare->Segments->Legs->ArrivalDate))
                                {{$fare->Segments->Legs->ArrivalDate}}
                            @endif
                            @if (isset($fare->Segments->Legs->ArrivalTime))
                                {{$fare->Segments->Legs->ArrivalTime}}
                            @endif
                            @if (isset($fare->Segments->Legs->ArrivalCityCode) && (isset(\Cities::getCityByCode($fare->Segments->Legs->ArrivalCityCode)['name'])))
                                {{\Cities::getCityByCode($fare->Segments->Legs->ArrivalCityCode)['name']}}
                            @endif
                            (
                            @if (isset($fare->Segments->Legs->ArrivalAirportCode))
                                {{$fare->Segments->Legs->ArrivalAirportCode}}
                            @endif
                            )
                        @else
                            @foreach ($fare->Segments->Legs as $index => $legs)
                                {{ ++$index }}
                                .
                                @if (isset($legs->DepartureDate))
                                    {{$legs->DepartureDate}}
                                @endif
                                @if (isset($legs->DepartureTime))
                                    {{$legs->DepartureTime}}
                                @endif
                                @if (isset($legs->DepartureCityCode) && (isset(\Cities::getCityByCode($legs->DepartureCityCode)['name'])))
                                    {{\Cities::getCityByCode($legs->DepartureCityCode)['name']}}
                                @endif
                                (
                                @if (isset($legs->DepartureAirportCode))
                                    {{$legs->DepartureAirportCode}}
                                @endif
                                )
                                ->
                                @if (isset($legs->ArrivalDate))
                                    {{$legs->ArrivalDate}}
                                @endif
                                @if (isset($legs->ArrivalTime))
                                    {{$legs->ArrivalTime}}
                                @endif
                                @if (isset($legs->ArrivalCityCode) && (isset(\Cities::getCityByCode($legs->ArrivalCityCode)['name'])))
                                    {{\Cities::getCityByCode($legs->ArrivalCityCode)['name']}}
                                @endif
                                (
                                @if (isset($legs->ArrivalAirportCode))
                                    {{$legs->ArrivalAirportCode}}
                                @endif
                                )
                                <br />
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if(isset($fare->Segments->Duration))
                            {{$fare->Segments->Duration}}
                        @endif
                    </td>
                    <td>
                        @if(isset($fare->Fares->Total))
                            {{$fare->Fares->Total}}
                        @endif
                        @if(isset($fare->Fares->Currency))
                            {{$fare->Fares->Currency}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="container">
        <div class="jumbotron">
            <p>Sorry, no results received.</p>
            <p>Try other conditions.</p>
            <p>
                <a class="btn btn-primary btn-lg" href="{{route('index')}}" role="button">Try other conditions</a>
            </p>
        </div>
    </div>
@endif

