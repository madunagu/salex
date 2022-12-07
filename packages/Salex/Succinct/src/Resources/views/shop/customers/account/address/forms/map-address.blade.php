<script type="text/x-template" id="coupon-component-template">
    <div class="coupon-container">
            <div class="discount-control">
                <form class="custom-form" method="post" @submit.prevent="applyCoupon">
                    <div class="control-group" :class="[errorMessage ? 'has-error' : '']">
                        <input
                            type="text"
                            name="code"
                            class="control"
                            v-model="couponCode"
                            placeholder="{{ __('shop::app.checkout.onepage.enter-coupon-code') }}" />

                        <div class="control-error">@{{ errorMessage }}</div>
                    </div>

                    <button class="theme-btn light" :disabled="disableButton">{{ __('shop::app.checkout.onepage.apply-coupon') }}</button>
                </form>
            </div>

            <div class="applied-coupon-details" v-if="appliedCoupon">
                <label>{{ __('shop::app.checkout.total.coupon-applied') }}</label>

                <label class="right" style="display: inline-flex; align-items: center;">
                    <b>@{{ appliedCoupon }}</b>

                    <i class="rango-close fs18" title="{{ __('shop::app.checkout.total.remove-coupon') }}" v-on:click="removeCoupon"></i>
                </label>
            </div>
        </div>
    </script>

<script>
    Vue.component('coupon-component', {
        template: '#coupon-component-template',

        inject: ['$validator'],


        name: "GoogleMap",
        data() {
            return {
                center: {
                    lat: 13.6929,
                    lng: 89.2182
                },
                locationMarkers: [],
                locPlaces: [],
                existingPlace: null
            };
        },

        mounted() {
            this.locateGeoLocation();
        },

        methods: {
            initMarker(loc) {
                this.existingPlace = loc;
                this.addLocationMarker();
                console.log(loc);
            },
            addLocationMarker() {
                if (this.existingPlace) {
                    const marker = {
                        lat: this.existingPlace.geometry.location.lat(),
                        lng: this.existingPlace.geometry.location.lng()
                    };
                    this.locationMarkers.push({
                        position: marker
                    });
                    this.locPlaces.push(this.existingPlace);
                    this.center = marker;
                    this.existingPlace = null;
                }
            },
            locateGeoLocation: function() {
                navigator.geolocation.getCurrentPosition(res => {
                    this.center = {
                        lat: res.coords.latitude,
                        lng: res.coords.longitude
                    };
                });
            }
        },




        watch: {
            couponCode: function(value) {
                if (value != '') {
                    this.errorMessage = '';
                }
            }
        },


    });
</script>