<template>
    <div class="display">
        <div>
            <v-icon>mdi-tag-multiple-outline</v-icon>
            <div>{{installedVersion}}</div>
        </div>
        <div v-if="outdated">
            <a href="#">
                <v-icon color="green"> mdi-shield-sync</v-icon>
                <div style="color: forestgreen">{{currentVersion}}</div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.installedVersion = aps_globals.installedVersion
            this.currentVersion = aps_globals.currentVersion
        },
        data() {
            return {
                installedVersion: 0.1,
                currentVersion: 0.1
            }
        },
        methods: {},
        computed: {
            outdated() {
                return this.currentVersion > this.installedVersion
            },

            color() {
                return this.outdated ? 'forestgreen' : '#ada4a4'
            }

        }
    }

</script>
<style scoped lang="scss">
    .display {
        display: flex;
        justify-content: space-between;

        .outdated {
            color: forestgreen;
        }

        .current {
            color: #ada4a4;
        }
    }
</style>
