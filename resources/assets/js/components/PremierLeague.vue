<template>
    <tile :position="position" modifiers="overflow">
        <table class="table table-sm table_pl" style="width: 100%; height: 0; font-size: 0.7em;">
            <thead>
            <tr>
                <th style="text-align:left">Pos</th>
                <th></th>
                <th></th>
                <th>S</th>
                <th>S</th>
                <th>U</th>
                <th>T</th> 
                <th>MF</th>
                <th>+</th>
                <th>-</th>
                <th>P</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in pl_leaguetable" v-bind:key="item.position" >
                <td>{{ item.position }}</td>
                <td><img style="max-width: 20px; max-height: 20px;" v-bind:src="item.crestURI"></td>
                <td>{{ item.teamName }}</td>
                <td>{{ item.playedGames }}</td>
                <td>{{ item.wins }}</td>
                <td>{{ item.draws }}</td>
                <td>{{ item.losses }}</td>
                <th>{{ item.goalDifference }}</th>
                <td>{{ item.goals }}</td>
                <td>{{ item.goalsAgainst }}</td>    
                <td>{{ item.points }}</td>       
            </tr>
            </tbody>
        </table>
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
                pl_leaguetable: [],
            };
        },

        methods: {
            
            getEventHandlers() {
                return {
                    'Fotball.DataFetched': response => {
                        console.log(response.data);
                        this.pl_leaguetable = response.data;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'pl_leaguetable',
                };
            },
        },
    };

</script>
