<template>
    <div>
        <v-row>
            <v-col cols="4">
                <h5>Primary Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2" hide-inputs v-model="primaryColor">
                </v-color-picker>
            </v-col>
            <v-col cols="4">
                <h5>Secondary Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2"
                        hide-inputs
                        v-model="secondaryColor">
                </v-color-picker>
            </v-col>
            <v-col cols="4">
                <h5>Success Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2"
                        hide-inputs
                        v-model="successColor">
                </v-color-picker>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="4">
                <h5>Error Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2" hide-inputs v-model="errorColor">
                </v-color-picker>
            </v-col>
            <v-col cols="4">
                <h5>Info Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2"
                        hide-inputs
                        v-model="infoColor">
                </v-color-picker>
            </v-col>
            <v-col cols="4">
                <h5>Warning Color:</h5>
                <v-color-picker
                        @input="resetColors"
                        class="ma-2"
                        hide-inputs
                        v-model="warningColor">
                </v-color-picker>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        mounted() {
            if (!this.loaded) {
                this.primaryColor = this.colorThemes.primaryColor
                this.secondaryColor = this.colorThemes.secondaryColor
                this.successColor = this.colorThemes.successColor
                this.errorColor = this.colorThemes.errorColor
                this.infoColor = this.colorThemes.infoColor
                this.warningColor = this.colorThemes.warningColor
            }
            this.loaded = true;
        },
        data() {
            return {
                loaded: false,
                errorColor: '',
                primaryColor: '',
                secondaryColor: '',
                successColor: '',
                infoColor: '',
                warningColor: '',
            }
        },
        methods: {
            resetColors() {
                if (this.loaded) {
                    let themeColors = {
                        primaryColor: this.primaryColor,
                        secondaryColor: this.secondaryColor,
                        successColor: this.successColor,
                        errorColor: this.errorColor,
                        infoColor: this.infoColor,
                        warningColor: this.warningColor
                    }
                    this.$emit("changeColors", {themeColors})
                }
            }
        },
        computed: {
            colorThemes() {
                return this.$store.state.settings.themeColors
            },
        }
    }

</script>
