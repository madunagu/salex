@extends('elegant::drivers.account.index')

@section('page_title')
{{ __('admin::app.dashboard.title') }}
@endsection

@section('account-content')
<div class="account-layout dashboard">
    <div class="account-head mb-10">
        <span class="back-icon"><a href="{{ route('driver.profile.index') }}"><i class="icon icon-menu-back"></i></a></span>

        <span class="account-heading">
            {{ __('admin::app.dashboard.title') }}
        </span>

        <div class="horizontal-rule"></div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.list.before') !!}

    <div class="account-items-list">


        <div class="dashboard-stats">

            <div class="dashboard-card">
                <div class="title">
                    {{ __('driver::app.dashboard.total-vehicles') }}
                </div>
                <a href="{{ route('admin.customer.index') }}">
                    <div class="data">
                        {{ $statistics['total_vehicles']['current'] }}

                        <span class="progress">
                            @if ($statistics['total_vehicles']['progress'] < 0) <span class="icon graph-down-icon"></span>
                        {{ __('admin::app.dashboard.decreased', [
                            'progress' => -number_format($statistics['total_vehicles']['progress'], 1)
                        ])
                    }}
                        @else
                        <span class="icon graph-up-icon"></span>
                        {{ __('admin::app.dashboard.increased', [
                            'progress' => number_format($statistics['total_vehicles']['progress'], 1)
                        ])
                    }}
                        @endif
                        </span>
                    </div>
                </a>
            </div>

            <div class="dashboard-card">
                <div class="title">
                    {{ __('driver::app.dashboard.total-shipments') }}
                </div>
                <a href="{{ route('admin.sales.orders.index') }}">
                    <div class="data">
                        {{ $statistics['total_shipments']['current'] }}

                        <span class="progress">
                            @if ($statistics['total_shipments']['progress'] < 0) <span class="icon graph-down-icon"></span>
                        {{ __('admin::app.dashboard.decreased', [
                            'progress' => -number_format($statistics['total_shipments']['progress'], 1)
                        ])
                    }}
                        @else
                        <span class="icon graph-up-icon"></span>
                        {{ __('admin::app.dashboard.increased', [
                            'progress' => number_format($statistics['total_shipments']['progress'], 1)
                        ])
                    }}
                        @endif
                        </span>
                    </div>
                </a>
            </div>

            <div class="dashboard-card">
                <div class="title">
                    {{ __('driver::app.dashboard.total-revenue') }}
                </div>

                <div class="data">
                    {{ core()->formatBasePrice($statistics['total_revenue']['current']) }}

                    <span class="progress">
                        @if ($statistics['total_revenue']['progress'] < 0) <span class="icon graph-down-icon"></span>
                    {{ __('admin::app.dashboard.decreased', [
                        'progress' => -number_format($statistics['total_revenue']['progress'], 1)
                    ])
                }}
                    @else
                    <span class="icon graph-up-icon"></span>
                    {{ __('admin::app.dashboard.increased', [
                        'progress' => number_format($statistics['total_revenue']['progress'], 1)
                    ])
                }}
                    @endif
                    </span>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="title">
                    {{ __('driver::app.dashboard.average-revenue') }}
                </div>

                <div class="data">
                    {{ core()->formatBasePrice($statistics['avg_revenue']['current']) }}

                    <span class="progress">
                        @if ($statistics['avg_revenue']['progress'] < 0) <span class="icon graph-down-icon"></span>
                    {{ __('admin::app.dashboard.decreased', [
                        'progress' => -number_format($statistics['avg_revenue']['progress'], 1)
                    ])
                }}
                    @else
                    <span class="icon graph-up-icon"></span>
                    {{ __('admin::app.dashboard.increased', [
                        'progress' => number_format($statistics['avg_revenue']['progress'], 1)
                    ])
                }}
                    @endif
                    </span>
                </div>
            </div>

            <div class="dashboard-card">
                <div class="title">
                    {{ __('driver::app.dashboard.total-unshipped-orders') }}
                </div>

                <div class="data">
                    {{ core()->formatBasePrice($statistics['total_unshipped_orders']) }}
                </div>
            </div>

        </div>


        <div class="graph-stats">
            <div class="left-card-container graph">
                <div class="card" style="overflow: hidden;">
                    <div class="card-title" style="margin-bottom: 30px;">
                        {{ __('driver::app.dashboard.deliveries') }}
                    </div>

                    <div class="card-info" style="height: 100%;">

                        <canvas id="myChart" style="width: 100%; height: 87%"></canvas>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-title">
                    {{ __('admin::app.dashboard.customer-with-most-sales') }}
                </div>

                <div class="card-info {{ !count($statistics['customer_with_most_shipments']) ? 'center' : '' }}">
                    <ul>

                        @foreach ($statistics['customer_with_most_shipments'] as $item)

                        <li>
                            @if ($item->customer_id)
                            <a href="{{ route('admin.customer.edit', $item->customer_id) }}">
                                @endif

                                <div class="image">
                                    <span class="icon profile-pic-icon"></span>
                                </div>

                                <div class="description do-not-cross-arrow">
                                    <div class="name ellipsis">
                                        {{ $item->customer_full_name }}
                                    </div>

                                    <div class="info">
                                        {{ __('admin::app.dashboard.order-count', ['count' => $item->total_shipments]) }}
                                        &nbsp;.&nbsp;
                                        {{ __('admin::app.dashboard.revenue', [
                                    'total' => core()->formatBasePrice($item->total_shipments)
                                    ])
                                }}
                                    </div>
                                </div>

                                <span class="icon angle-right-icon"></span>

                                @if ($item->customer_id)
                            </a>
                            @endif
                        </li>

                        @endforeach

                    </ul>

                    @if (! count($statistics['customer_with_most_shipments']))

                    <div class="no-result-found">

                        <i class="icon no-result-icon"></i>
                        <p>{{ __('admin::app.common.no-result-found') }}</p>

                    </div>

                    @endif
                </div>

            </div>


        </div>

        <div class="google-map">

            <div class="card" style="overflow: hidden;padding: 20px 15px 0px 20px;">
                <div class="card-title" style="margin-bottom: 30px;">
                    {{ __('driver::app.dashboard.deliveries') }}
                </div>

                <div class="card-info" style="height: 100%;">

                    <div id="gmap" style="width: 100%; height: 87%"></div>

                </div>
            </div>

        </div>
    </div>

    {!! view_render_event('bagisto.shop.customers.account.orders.list.after') !!}
</div>
@stop

@push('scripts')


<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4tKkckx-4IXco77Qqa4-C9mBgFG921WQ"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>

<script type="text/x-template" id="date-filter-template">
    <div id="calender-destop">
            <div class="control-group date">
                <date @onChange="applyFilter('start', $event)" hide-remove-button="1"><input type="text" class="control" id="start_date" value="{{ $startDate->format('Y-m-d') }}" placeholder="{{ __('admin::app.dashboard.from') }}" v-model="start"/></date>
            </div>

            <div class="control-group date">
                <date @onChange="applyFilter('end', $event)" hide-remove-button="1"><input type="text" class="control" id="end_date" value="{{ $endDate->format('Y-m-d') }}" placeholder="{{ __('admin::app.dashboard.to') }}" v-model="end"/></date>
            </div>
        </div>
    </script>

<script type="text/x-template" id="date-mobile-filter-template">
    <div>
            <div id="calender-mobile">
                <span  @click="openCalender()"></span>
            </div>
            <div v-if="toggleCalenderIcon">
                <div id="date-start" style="">
                    <div class="control-group start-date" style="margin-top:15px">
                    <label for="type">{{ __('admin::app.dashboard.from') }}</label>
                        <date @onChange="setDate('start', $event)" hide-remove-button="1">
                            <input type="text" class="control" id="start_date" value="{{ $startDate->format('Y-m-d') }}" placeholder="{{ __('admin::app.dashboard.from') }}" v-model="start"/>
                        </date>
                    </div>
                </div>

                <div id="date-end" style="">
                    <div class="control-group end-date" style="margin-top:15px">
                        <label for="type">{{ __('admin::app.dashboard.to') }}</label>
                        <date @onChange="setDate('end', $event)" hide-remove-button="1">
                            <input type="text" class="control" id="end_date" value="{{ $endDate->format('Y-m-d') }}" placeholder="{{ __('admin::app.dashboard.to') }}" v-model="end"/>
                        </date>
                    </div>
                </div>

                <div id="date-submit" style="">
                    <button class="btn btn-lg btn-primary" @click="applyFilter">Submit</button>
                </div>              
            </div>            
        </div>
    </script>

<script>
    Vue.component('date-filter', {

        template: '#date-filter-template',

        data: function() {
            return {
                start: "{{ $startDate->format('Y-m-d') }}",
                end: "{{ $endDate->format('Y-m-d') }}",
            }
        },

        methods: {
            applyFilter: function(field, date) {
                this[field] = date;

                window.location.href = "?start=" + this.start + '&end=' + this.end;
            }
        }
    });



    Vue.component('date-mobile-filter', {

        template: '#date-mobile-filter-template',

        data: function() {
            return {
                start: "{{ $startDate->format('Y-m-d') }}",
                end: "{{ $endDate->format('Y-m-d') }}",
                toggleCalenderIcon: 0
            }
        },

        methods: {

            openCalender: function() {

                if (this.toggleCalenderIcon) {
                    this.toggleCalenderIcon = 0;
                    $('#calender-mobile span').css('top', '0');
                } else {
                    this.toggleCalenderIcon = 1;
                    $('#calender-mobile span').css('top', '-40px');
                }
            },

            setDate: function(field, date) {
                this[field] = date;
            },

            applyFilter: function() {
                window.location.href = "?start=" + this.start + '&end=' + this.end;
            }
        }
    });

    $(document).ready(function() {

        var ctx = document.getElementById("myChart").getContext('2d');

        var data = @json($statistics['sale_graph']);

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data['label'],
                datasets: [{
                    data: data['total'],
                    backgroundColor: 'rgba(34, 201, 93, 1)',
                    borderColor: 'rgba(34, 201, 93, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        maxBarThickness: 20,
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            beginAtZero: true,
                            fontColor: 'rgba(162, 162, 162, 1)'
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                        },
                        ticks: {
                            padding: 20,
                            beginAtZero: true,
                            fontColor: 'rgba(162, 162, 162, 1)'
                        }
                    }]
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    displayColors: false,
                    callbacks: {
                        label: function(tooltipItem, dataTemp) {
                            return data['formated_total'][tooltipItem.index];
                        }
                    }
                }
            }
        });

        let map, activeInfoWindow, markers = [];

        /* ----------------------------- Initialize Map ----------------------------- */
        function initMap() {
            map = new google.maps.Map(document.getElementById("gmap"), {
                center: {
                    lat: 6.663988475912884,
                    lng: 3.5344982139493064,

                },
                zoom: 15
            });

            map.addListener("click", function(event) {
                mapClicked(event);
            });

            initMarkers();
        }

        /* --------------------------- Initialize Markers --------------------------- */
        function initMarkers() {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

            for (let index = 0; index < initialMarkers.length; index++) {

                const markerData = initialMarkers[index];
                const marker = new google.maps.Marker({
                    position: markerData.position,
                    label: markerData.label,
                    draggable: markerData.draggable,
                    map
                });
                markers.push(marker);

                const infowindow = new google.maps.InfoWindow({
                    content: `<b>Shipment ID: ${markerData.title[0]}, to ${markerData.title[1]}</b>`,
                });
                marker.addListener("click", (event) => {
                    if (activeInfoWindow) {
                        activeInfoWindow.close();
                    }
                    infowindow.open({
                        anchor: marker,
                        shouldFocus: false,
                        map
                    });
                    activeInfoWindow = infowindow;
                    markerClicked(marker, index);
                });

                marker.addListener("dragend", (event) => {
                    markerDragEnd(event, index);
                });
            }
        }

        /* ------------------------- Handle Map Click Event ------------------------- */
        function mapClicked(event) {
            console.log(map);
            console.log(event.latLng.lat(), event.latLng.lng());
        }

        /* ------------------------ Handle Marker Click Event ----------------------- */
        function markerClicked(marker, index) {
            console.log(map);
            console.log(marker.position.lat());
            console.log(marker.position.lng());
        }

        /* ----------------------- Handle Marker DragEnd Event ---------------------- */
        function markerDragEnd(event, index) {
            console.log(map);
            console.log(event.latLng.lat());
            console.log(event.latLng.lng());
        }

        initMap();
    });
</script>



@endpush