<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            {{ link_to('/', 'E-Tickets Service GmbH & Co. KG test', array('class="navbar-brand"')) }}
        </div>
        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
            {{--<ul class="nav navbar-nav">
                <li class="@if ($page_type === 'types' || $page_type === NULL) active @endif">
                    {{ link_to('/?c=types', 'Types') }}
                </li>
                <li class="@if ($page_type === 'blocks') active @endif">
                    {{ link_to('/?c=blocks', 'Blocks') }}
                </li>
            </ul>--}}
        </div>
    </div>
</nav>