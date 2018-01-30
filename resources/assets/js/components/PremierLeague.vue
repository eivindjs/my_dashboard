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
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in pl_leaguetable">
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
            </tr>
            </tbody>
        </table>
    </tile>
</template>

<script>
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';
    const items = [
        { position: 1, name: 'Manchester United', played: '24', won: '12', draw:'2',lose:'0', gd:'24', plus:'50',minus:'20'},
        { position: 2, name: 'Manchester Shitty', played: '24', won: '12', draw:'2',lose:'0', gd:'24', plus:'50',minus:'20'},
        { position: 3, name: 'West ham', played: '24', won: '12', draw:'2',lose:'0', gd:'24', plus:'50',minus:'20'}
    ]
    export default {

        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: ['position'],

        data() {
            return {
                pl_leaguetable: [],
                items: items,
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
