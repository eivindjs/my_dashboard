<template>
    <tile :position="position" modifiers="overflow">
        <div class="events" v-for="game in games" v-bind:key="game.matchday">
            <div class="home">
                <img class="crestimg" v-bind:src="game.homeCrestURI"><br/> {{ game.homeTeamName }}
            </div>
            <div class="info">
                {{ game.date }}
            </div>
            <div class="away">
                <img class="crestimg" v-bind:src="game.awayCrestURI"><br /> {{ game.awayTeamName }}
            </div>
        </div>
    </tile>
</template>
<style>
    .events {
        flex-wrap: wrap;
        text-align: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        height: 50%;
        font-size: 0.8em;
    }
    .away {
        width: 30%;
        padding: 10px 0;
        box-sizing: border-box;
    }
    .home {
        width: 30%;
        padding: 10px 0;
        box-sizing: border-box;
    }
    .info {
        width: 40%;
        /* font-size: 13px; */
        font-weight: 300;
        padding: 10px 0;
        -ms-flex-item-align: center;
        -ms-grid-row-align: center;
        align-self: center; 
    }
    .crestimg {
        max-width: 40px; 
        max-height: 40px;
    }

</style>
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
