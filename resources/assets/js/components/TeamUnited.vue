<template>
    <tile :position="position" modifiers="overflow">
        <section class="calendar">
            <h1 class="calendar__title">Neste kamper Manchester United</h1>
            <ul class="calendar__events">
                <li v-for="game in games" class="calendar__event">
                    <h2 class="calendar__event__title">{{ game.homeTeamName }}</h2>
                    <div class="calendar__event__date"></div>
                </li>
            </ul>
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
                games: [],
            };
        },

        methods: {

            getEventHandlers() {
                return {
                    'FotballTeam.TeamDataFetched': response => {
                        this.games = response.team;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'united',
                };
            },
        },
    };

</script>
