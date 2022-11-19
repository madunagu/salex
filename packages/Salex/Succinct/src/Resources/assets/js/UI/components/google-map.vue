<template>
    <div>
        <div>
            <gmap-autocomplete @place_changed="initMarker"></gmap-autocomplete>

        </div>
        <br>
        <input name="lat" v-model="latitude" style="display:none" />
        <input name="lng" v-model="longitude" style="display:none" />
        <gmap-map @click="saveLocation" :zoom="14" :center="center"
            style="width:100%;  height: 400px;overflow: hidden;border-radius: 12px;">
            <gmap-marker :key="index" v-for="(m, index) in locationMarkers" :position="m.position"
                @click="center = m.position"></gmap-marker>
        </gmap-map>
    </div>
</template>
   
<script>
export default {
    name: "GoogleMap",
    data() {
        return {
            center: {
                lat: 39.7837304,
                lng: -100.4458825
            },
            locationMarkers: [],
            locPlaces: [],
            existingPlace: null,
            latitude: null,
            longitude: null,
        };
    },

    mounted() {
        this.locateGeoLocation();
    },

    methods: {
        saveLocation(e) {
            console.log(JSON.stringify(e.latLng.toJSON(), null, 2));

            this.locationMarkers = [];
            const marker = JSON.parse(JSON.stringify(e.latLng.toJSON(), null, 2))
            this.locationMarkers.push({ position: marker });
            this.latitude = marker.lat;
            this.longitude = marker.lng;
        },
        initMarker(loc) {
            this.existingPlace = loc;
            this.addLocationMarker();
        },
        addLocationMarker() {
            if (this.existingPlace) {
                const marker = {
                    lat: this.existingPlace.geometry.location.lat(),
                    lng: this.existingPlace.geometry.location.lng()
                };
                this.locationMarkers.push({ position: marker });
                this.locPlaces.push(this.existingPlace);
                this.center = marker;
                this.latitude = marker.lat;
                this.longitude = marker.lng;
                this.existingPlace = null;
            }
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