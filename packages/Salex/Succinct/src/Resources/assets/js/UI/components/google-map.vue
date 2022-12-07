<template>
    <div>
        <div>
            <gmap-autocomplete @place_changed="onSelectLocation"></gmap-autocomplete>

        </div>
        <br>
        <input name="lat" v-model="locationMarker.lat" type="hidden" />
        <input name="lng" v-model="locationMarker.lng" type="hidden" />
        <gmap-map @click="onMapClicked" :zoom="14" :center="center"
            style="width:100%;  height: 400px;overflow: hidden;border-radius: 12px;">
            <gmap-marker :position="locationMarker" @click="(center = locationMarker)"></gmap-marker>
        </gmap-map>
    </div>
</template>
   
<script>
export default {
    name: "GoogleMap",
    props: ['formerLocation'],
    data() {
        return {
            center: { lat: 13.6929, lng: -89.2182 },
            locationMarker: { lat: 13.6929, lng: -89.2182 },
        };
    },

    mounted() {
        this.locateGeoLocation();
        if (this.formerLocation) {
            this.locationMarker = this.formerLocation;
            // this.center = this.formerLocation;
            console.log(this.locationMarker);
        }
    },

    methods: {
        onMapClicked(e) {
            this.locationMarker = JSON.parse(JSON.stringify(e.latLng.toJSON(), null, 2));
        },

        onSelectLocation(loc) {
            this.addMarkerAndCenterMap(loc);
            this.selectAddress(loc);
        },

        selectAddress(loc) {
            var address = {};
            for (var i = 0; i < loc.address_components.length; i++) {
                address[loc.address_components[i].types[0]] = loc.address_components[i].long_name;
            }
            console.log(address);
            this.$emit('onAddressSelected', address);
        },

        addMarkerAndCenterMap(loc) {
            this.locationMarker = {
                lat: loc.geometry.location.lat(),
                lng: loc.geometry.location.lng()
            };
            this.center = this.locationMarker;
        },

        locateGeoLocation: function () {
            navigator.geolocation.getCurrentPosition(res => {
                this.center = {
                    lat: res.coords.latitude,
                    lng: res.coords.longitude
                };
            });
        }
    }
};
</script>