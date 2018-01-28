<template>
    <tile :position="position">
        <section class="time-weather">
            <span class="time-weather__time-zone">{{ text }}</span>
            <time class="time-weather__content">
                <span class="time-weather__date">{{ date }}</span>
                <span class="time-weather__time">{{ time }}</span>
                <span class="time-weather__weather">
                    <span class="time-weather__weather__temperature">{{ temperature }}</span>
                    <span class="time-weather__weather__description">
                        <img class="time-weather__img" v-bind:src="icon">
                    </span>
                </span>
            </time>
        </section>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import moment from 'moment-timezone';
    import saveState from 'vue-save-state';

    export default {

        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: {
            dateFormat: {
                type: String,
                default: 'DD.MM.YYYY',
            },
            timeFormat: {
                type: String,
                default: 'HH:mm:ss',
            },
            timeZone: {
                type: String,
            },
            position: {
                type: String,
            },
        },

        data() {
            return {
                temperature: '',
                icon: '',
                text: '',
                date: '',
                time: '',
            };
        },
          
        created() {
            this.refreshTime();
            setInterval(this.refreshTime, 1000);
        },

        methods: {
            refreshTime() {
                this.date = moment().tz(this.timeZone).format(this.dateFormat);
                this.time = moment().tz(this.timeZone).format(this.timeFormat);
            },

            getEventHandlers() {
                return {
                    'Yr.YrDataFetched': response => {
                        this.temperature = response.weather.temperature;
                        this.icon = response.weather.symbol;
                        this.text = response.weather.text;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: `yr`,
                };
            },
        },
    };
</script>
