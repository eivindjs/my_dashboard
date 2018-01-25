<template>
    <tile :position="position" modifiers="overflow">
        <section class="github-file">
            <h1 class="github-file__title">{{ temperature }}</h1>
            <!--<div class="github-file__content" v-html="tasks"></div>-->
        </section>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';

    export default {

        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: ['position'],

        data() {
            return {
                temperature: '',
            };
        },

        methods: {
            getEventHandlers() {
                return {
                    'Yr.FetchWeatherData': response => {
                        console.log("hei");
                        console.log(response);
                        this.temperature = response.weather.temperature;
                        //this.tasks = response.tasks[this.teamMember];
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: `yr-${this.temperature}`,
                };
            },
        },
    };
</script>
